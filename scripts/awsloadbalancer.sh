#!/bin/bash
RV=0
usage() {
  cat <<EndOfUsage
usage $0: [options] (load|shutdown|status required)
    -c, --config <file path> (default .env)
    -d, --shutdown  shutdown ECS task service
    -h, --help
    -n, --name <cluster name>   name to use (overrides .env)
    -s, --status    show ECS task service status
    --shortstat     single word status of system
    -u, --load      create and run ECS task service
    -v, --verbose   increase verbosity
    -m, --master    activate MASTER_SUBDOMAIN
EndOfUsage
}

TEMP=$(getopt -o c:n:dhsuvm --long config:,name:,region:,help,load,loadvars,shutdown,status,verbose,master,shortstat \
  -n awsdockerup.sh -- "$@")
if [ $? != 0 ]; then usage; exit 1; fi

eval set -- "$TEMP"

CONFIG='.env'
LOAD='off'
LOGDIR='log'
SHUTDOWN='off'
STATUS='off'
SHORTSTAT='off'
VERBOSE=0
MASTER='off'
NAMEOVERRIDE=''
REGIONOVERRIDE=''
while true; do
  case "$1" in
    -c | --config ) CONFIG="$2"; shift 2 ;;
    -d | --shutdown ) SHUTDOWN='on'; shift ;;
    -h | --help ) usage; exit ;;
    -n | --name ) NAMEOVERRIDE="$2"; shift 2 ;;
    -s | --status ) STATUS='on'; shift ;;
         --shortstat ) SHORTSTAT='on'; shift ;;
         --region ) REGIONOVERRIDE="$2"; shift 2 ;;
    -u | --load ) LOAD='on'; shift ;;
    -v | --verbose ) VERBOSE=$(($VERBOSE + 1)); shift ;;
    -m | --master ) MASTER='on'; shift ;;
    -- ) shift; break ;;
    * ) break ;;
  esac
done

if [ ! -r "$CONFIG" ]
then
  echo "'$CONFIG' is not readable" >&2
  usage
  exit 1
fi
source "$CONFIG"

if [ ! -z "$NAMEOVERRIDE" ]; then
  NAME=$NAMEOVERRIDE
fi

if [ ! -z "$REGIONOVERRIDE" ]; then
  AWS_DEFAULT_REGION=$REGIONOVERRIDE
fi


TARGET_GROUP_NAME="ecs-target-$NAME-tcp80"

if [ "$LOAD" != 'on' -a "$LOADVARS" != 'on' -a "$SHUTDOWN" != 'on' -a "$STATUS" != 'on' -a "$MASTER" != 'on' -a "$SHORTSTAT" != 'on' ]
then
  usage
  exit 1;
fi

if [ -z "$AWS_DEFAULT_REGION" ]; then
  echo "ERROR: AWS_DEFAULT_REGION not defined"
  exit 1
fi
if [ -z "$NAME" ]; then
  echo "ERROR: NAME not defined"
  exit 1
fi
if [ -z "$DOMAIN" ]; then
  echo "ERROR: DOMAIN not defined"
  exit 1
fi
if [ -z "$AWS_CLI_PROFILE" ]; then
  echo "ERROR: AWS_CLI_PROFILE not defined"
  exit 1
fi

export AWS_DEFAULT_REGION
export NAME
export DOMAIN

#reference: https://docs.aws.amazon.com/elasticloadbalancing/latest/application/tutorial-application-load-balancer-cli.html

if [ -f $LOGDIR/tmp_loader.tmp ]; then
    export CLUSTER_VPC=`grep 'VPC created:' $LOGDIR/tmp_loader.tmp | cut -f2 -d: | tr -d ' '`
    export CLUSTER_SUBNET1=`grep 'Subnet created:' $LOGDIR/tmp_loader.tmp | head -1 | cut -f2 -d: | tr -d ' '`
    export CLUSTER_SUBNET2=`grep 'Subnet created:' $LOGDIR/tmp_loader.tmp | tail -1 | cut -f2 -d: | tr -d ' '`
fi

LOAD_BALANCER_ARN=`aws elbv2 describe-load-balancers \
      --profile=$AWS_CLI_PROFILE \
      --output=json \
      --name=lb-$NAME | jq '.LoadBalancers[0].LoadBalancerArn' -r`
TARGET_GROUP_ARN=`aws elbv2 describe-target-groups \
      --profile=$AWS_CLI_PROFILE \
      --output=json \
      --name=$TARGET_GROUP_NAME \
        | jq '.TargetGroups[0].TargetGroupArn' -r `

TARGET_IP=`bash scripts/awsdockerup.sh --status --config=$CONFIG --name=$NAME 2>&1 \
    | grep $NAME | tr -s ' ' | cut -d' ' -f3 | cut -f1 -d:`

if [ "$SHUTDOWN" = 'on' ]; then
  if [ -z "$LOAD_BALANCER_ARN" ]; then
    echo "No Load Balancer running"
  else
    echo "Shutting down $LOAD_BALANCER_ARN"
    aws elbv2 delete-load-balancer \
        --profile=$AWS_CLI_PROFILE \
        --load-balancer-arn=$LOAD_BALANCER_ARN
  fi
  if [ -z "$TARGET_GROUP_ARN" ]; then
    echo "No Target Group running"
  else
    echo "Shutting down $TARGET_GROUP_ARN"
    aws elbv2 delete-target-group \
        --profile=$AWS_CLI_PROFILE \
        --target-group-arn $TARGET_GROUP_ARN
  fi
  echo "Shutdown complete"
  exit 0
fi

if [ "$LOAD" = 'on' ]; then
  if [ -z "$TARGET_IP" ]; then
      echo "No target running"
      exit 1
  fi

  if [ ! -d "$LOGDIR" ]
  then
    mkdir $LOGDIR
  fi

  # create Elastic Load Balancer Target Group
  if [ -z "$TARGET_GROUP_ARN" ]; then

    aws elbv2 create-target-group \
        --profile $AWS_CLI_PROFILE \
        --target-type ip \
        --name $TARGET_GROUP_NAME \
        --protocol TCP --port 80 \
        --output json \
        --vpc-id $CLUSTER_VPC \
          | tee $LOGDIR/create-target-group.log
    if [ $? != 0 ]; then
      echo "ERROR: $0 failed, exiting"
      exit 1
    fi

    export TARGET_GROUP_ARN=`jq ".TargetGroups[0].TargetGroupArn" -r $LOGDIR/create-target-group.log`
  fi

  if [ -z "$LOAD_BALANCER_ARN" ]; then
    aws elbv2 create-load-balancer \
        --profile $AWS_CLI_PROFILE \
        --name lb-$NAME --type network \
        --subnets $CLUSTER_SUBNET1 $CLUSTER_SUBNET2 \
        --output json \
          | tee $LOGDIR/create-load-balancer.log
    if [ $? != 0 ]; then
      echo "ERROR: $0 failed, exiting"
      exit 1
    fi

    export LOAD_BALANCER_ARN=`jq ".LoadBalancers[0].LoadBalancerArn" -r $LOGDIR/create-load-balancer.log`
  fi

  DEFAULT_ACTION='[{ "Type": "forward", "TargetGroupArn": "'${TARGET_GROUP_ARN}'", "Order": 1, "ForwardConfig": { "TargetGroups": [ {     "TargetGroupArn": "'${TARGET_GROUP_ARN}'" } ]}}]'

  # creates port 80 listener for testing
  echo SKIPPING: aws elbv2 create-listener \
      --profile $AWS_CLI_PROFILE \
      --output json \
      --load-balancer-arn $LOAD_BALANCER_ARN \
      --protocol TCP --port 80  \
      --default-actions Type=forward,TargetGroupArn=$TARGET_GROUP_ARN

  # allows override of listener cert
  if [ -z "$AWS_LISTENER_CERT" ]; then
    CERTARN=`aws acm list-certificates \
        --profile $AWS_CLI_PROFILE \
        --output json \
            | jq ".CertificateSummaryList[] | select(.DomainName==\"*.$DOMAIN\") | .CertificateArn" -r`
  else
    CERTARN=$AWS_LISTENER_CERT
  fi

  if [ -z "$CERTARN" ]; then

      echo "ERROR: No Cert found for *.$DOMAIN, exiting"
      exit 1

  else
      echo "Found cert $CERTARN"

      aws elbv2 create-listener \
        --profile $AWS_CLI_PROFILE \
        --output json \
        --load-balancer-arn $LOAD_BALANCER_ARN \
        --protocol TLS --port 443 \
        --alpn-policy None \
        --certificate CertificateArn=$CERTARN \
        --default-actions Type=forward,TargetGroupArn=$TARGET_GROUP_ARN \
          | tee $LOGDIR/create-listener-ssl.log
      if [ $? != 0 ]; then
        echo "ERROR: $0 failed, exiting"
        exit 1
      fi

  fi

  aws ecs list-tasks \
      --profile $AWS_CLI_PROFILE \
      --cluster $NAME \
      --output json \
        | tee $LOGDIR/curtasks.log
  TASK_ARN=`jq -r '.taskArns[0]' $LOGDIR/curtasks.log`
  sleep 5
  if [ -z "$TASK_ARN" ]; then
    echo "No task yet, try again"
    exit 1
  fi

  aws ecs describe-tasks \
      --profile $AWS_CLI_PROFILE \
      --cluster $NAME \
      --output text \
      --tasks "$TASK_ARN" \
      --query "tasks[0].containers[0].networkInterfaces[0].privateIpv4Address" \
        | tee $LOGDIR/taskdesc.log
  TARGET_IP=`cat $LOGDIR/taskdesc.log`

  if [ -z "$TARGET_IP" ]; then
    echo "No IP discovered, try again"
    exit 1
  else
    aws elbv2 register-targets \
        --profile $AWS_CLI_PROFILE \
        --output json \
        --target-group-arn $TARGET_GROUP_ARN \
        --targets Id=$TARGET_IP
    if [ $? != 0 ]; then
      echo "ERROR: $0 failed, exiting"
      exit 1
    fi
  fi

  aws elbv2 describe-target-health \
      --profile $AWS_CLI_PROFILE \
      --output json \
      --target-group-arn $TARGET_GROUP_ARN \
      | tee $LOGDIR/tmp_describe-target-health.json

  aws elbv2 describe-load-balancers \
      --profile=$AWS_CLI_PROFILE \
      --output=json \
      --name=lb-$NAME \
      | tee $LOGDIR/tmp_describe-load-balancers.json
  DNSNAME=`aws elbv2 describe-load-balancers \
      --profile=$AWS_CLI_PROFILE \
      --output=json \
      --name=lb-$NAME \
        | jq ".LoadBalancers[0].DNSName" -r`


  ZONEID=`aws route53 list-hosted-zones \
      --profile $AWS_CLI_PROFILE  \
      --output json \
           | jq ".HostedZones[] | select(.Name==\"$DOMAIN.\") | .Id" -r`
  #ZONEID=`aws route53 --profile $AWS_CLI_PROFILE_JSON  list-hosted-zones | jq ".HostedZones[0].Id" -r`
  if [ -z "$ZONEID" ]; then
      echo "Zone for $DOMAIN not yet supported"
      echo "DNS CNAME not added for $DNSNAME"

  else
      echo "Found zone $ZONEID for $NAME.$DOMAIN"
      echo "Adding CNAME for $DNSNAME"

      CHANGEBATCH=`cat <<EOF
'{
    "Comment": "Update DNS record to the new Loadbalancer Endpoint",
    "Changes": [
        {
            "Action": "UPSERT",
            "ResourceRecordSet": {
                "Type": "CNAME",
                "ResourceRecords": [{
                    "Value": "$DNSNAME"
                }],
                "Name": "$NAME.$DOMAIN",
                "TTL": 60
            }
        }
    ]
}'
EOF
`
      echo $CHANGEBATCH
      echo aws route53 change-resource-record-sets \
        --profile $AWS_CLI_PROFILE \
        --hosted-zone-id $ZONEID \
        --change-batch $CHANGEBATCH \
          | tee $LOGDIR/tmp_changedns.tmp
      . $LOGDIR/tmp_changedns.tmp \
          | tee $LOGDIR/tmp_changedns_done.tmp
      if [ $? != 0 ]; then
        echo "ERROR: $0 failed, exiting"
        exit 1
      fi

      echo "Setup complete for $NAME.$DOMAIN"

  fi
fi

if [ "$MASTER" = 'on' ]; then

  if [ -z "$MASTER_SUBDOMAIN" ]; then
    echo "$0: error MASTER_SUBDOMAIN not specified, exiting"
    exit 1
  fi

  if [ ! -z "$MASTER_SUBDOMAIN" ]; then

  aws elbv2 describe-load-balancers \
      --profile=$AWS_CLI_PROFILE \
      --output=json \
      --name=lb-$NAME \
      | tee $LOGDIR/tmp_describe_load_balancers.tmp
  DNSNAME=`aws elbv2 describe-load-balancers \
      --profile=$AWS_CLI_PROFILE \
      --output=json \
      --name=lb-$NAME \
        | jq ".LoadBalancers[0].DNSName" -r`


  ZONEID=`aws route53 list-hosted-zones \
      --profile $AWS_CLI_PROFILE  \
      --output json \
           | jq ".HostedZones[] | select(.Name==\"$DOMAIN.\") | .Id" -r`
  #ZONEID=`aws route53 --profile $AWS_CLI_PROFILE_JSON  list-hosted-zones | jq ".HostedZones[0].Id" -r`
  if [ -z "$ZONEID" ]; then
      echo "Zone for $DOMAIN not yet supported"
      echo "DNS CNAME not added for $DNSNAME"

  else
      echo "Found zone $ZONEID for $MASTER_SUBDOMAIN.$DOMAIN"
      echo "Adding CNAME for $DNSNAME"

      CHANGEBATCH=`cat <<EOF
'{
    "Comment": "Update DNS record to the new Loadbalancer Endpoint",
    "Changes": [
        {
            "Action": "UPSERT",
            "ResourceRecordSet": {
                "Type": "CNAME",
                "ResourceRecords": [{
                    "Value": "$DNSNAME"
                }],
                "Name": "$MASTER_SUBDOMAIN.$DOMAIN",
                "TTL": 60
            }
        }
    ]
}'
EOF
`
      echo $CHANGEBATCH
      echo aws route53 change-resource-record-sets \
        --profile $AWS_CLI_PROFILE \
        --hosted-zone-id $ZONEID \
        --change-batch $CHANGEBATCH \
          | tee $LOGDIR/tmp_changedns.tmp
      . $LOGDIR/tmp_changedns.tmp \
          | tee $LOGDIR/tmp_master_change_dns.tmp
      if [ $? != 0 ]; then
        echo "ERROR: $0 failed, exiting"
        exit 1
      fi

      echo "Setup complete for $MASTER_SUBDOMAIN.$DOMAIN"

  fi
fi
fi

if [ "$SHORTSTAT" = 'on' ]; then
  if [ -z "$LOAD_BALANCER_ARN" ]; then
    echo "off"
  else
    aws elbv2 describe-load-balancers \
        --profile=$AWS_CLI_PROFILE \
        --output=json \
        --name=lb-$NAME \
          | jq -r '.LoadBalancers[0].State.Code'
  fi
  exit 0


fi

if [ "$STATUS" = 'on' ]; then
  if [ -z "$TARGET_GROUP_ARN" ]; then
    echo "No Target Group running"
  else
    echo $TARGET_GROUP_ARN
    aws elbv2 describe-target-health \
        --profile $AWS_CLI_PROFILE \
        --output json \
        --target-group-arn $TARGET_GROUP_ARN \
        | tee $LOGDIR/tmp_describe-target-health.json
  fi
  # aws elbv2 describe-target-groups \
  #     --profile=$AWS_CLI_PROFILE \
  #     --output=json \
  #     --name=$TARGET_GROUP_NAME
  if [ -z "$LOAD_BALANCER_ARN" ]; then
    echo "No Load Balancer running"
  else
    aws elbv2 describe-load-balancers \
        --profile=$AWS_CLI_PROFILE \
        --output=json \
        --name=lb-$NAME \
          | tee $LOGDIR/status_desc.json
    jq -r '.LoadBalancers[0].State.Code' $LOGDIR/status_desc.json
  fi
    exit 0
fi

exit $RV
