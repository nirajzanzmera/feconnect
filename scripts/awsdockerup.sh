#!/bin/bash
RV=0
usage() {
  cat <<EndOfUsage
usage $0: [options] (load|loadvars|shutdown|status required)
    -c, --config <file path> (default .env)
    -d, --shutdown  shutdown ECS task service
    -h, --help
    -n, --name <cluster name>   name to use (overrides .env)
        --loadvars
    -s, --status    show ECS task service status
    -u, --load      create and run ECS task service
    -v, --verbose   increase verbosity
EndOfUsage
}

TEMP=$(getopt -o c:n:dhsuv --long config:,name:,region:,help,load,loadvars,shutdown,status,verbose \
  -n awsdockerup.sh -- "$@")
if [ $? != 0 ]; then usage; exit 1; fi

eval set -- "$TEMP"

CONFIG='.env'
LOAD='off'
LOADVARS='off'
LOGDIR='log'
SHUTDOWN='off'
STATUS='off'
VERBOSE=0
NAMEOVERRIDE=''
REGIONOVERRIDE=''
while true; do
  case "$1" in
    -c | --config ) CONFIG="$2"; shift 2 ;;
    -d | --shutdown ) SHUTDOWN='on'; shift ;;
    -h | --help ) usage; exit $RV;;
    -n | --name ) NAMEOVERRIDE="$2"; shift 2 ;;
         --loadvars ) LOADVARS='on'; shift ;;
    -s | --status ) STATUS='on'; shift ;;
    -u | --load ) LOAD='on'; shift ;;
         --region ) REGIONOVERRIDE="$2"; shift 2 ;;
    -v | --verbose ) VERBOSE=$(($VERBOSE + 1)); shift ;;
    -- ) shift; break ;;
    * ) break ;;
  esac
done

if [ ! -r "$CONFIG" ]
then
  echo "'$CONFIG' is not readable" >&2
  usage
  exit 2
fi
source "$CONFIG"

if [ ! -z "$NAMEOVERRIDE" ]; then
  NAME=$NAMEOVERRIDE
fi

if [ ! -z "$REGIONOVERRIDE" ]; then
  AWS_DEFAULT_REGION=$REGIONOVERRIDE
fi


if [ "$LOAD" != 'on' -a "$LOADVARS" != 'on' -a "$SHUTDOWN" != 'on' -a "$STATUS" != 'on' ]
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

# exports needed for docker-compose.yml interpoation
export AWS_DEFAULT_REGION
export AWS_LIVE_IMAGE=`cat $LOGDIR/tmp_liverepo.tmp`
export NAME
export DOMAIN

if [ ! -f task-execution-assume-role.json ]; then
    echo "ERROR: missing file task-execution-assume-role.json"
    exit 1
fi

if [ ! -f ecs-params.yml ]; then
    echo "ERROR: missing file ecs-params.yml"
    exit 1
fi


ROLE_NAME=ecsTaskExecutionRole
POLICY_ARN=arn:aws:iam::aws:policy/service-role/AmazonECSTaskExecutionRolePolicy
ROLE_ARN=`aws iam --profile $AWS_CLI_PROFILE get-role --role-name $ROLE_NAME --query Role.Arn --output text`
if [ -z "$ROLE_ARN" ]
then
  aws iam --profile $AWS_CLI_PROFILE create-role --role-name ecsTaskExecutionRole --assume-role-policy-document file://task-execution-assume-role.json
fi

POLICY_NAME=`aws iam --profile $AWS_CLI_PROFILE list-attached-role-policies --role-name ecsTaskExecutionRole --query AttachedPolicies[].PolicyName --output text | grep AmazonECSTaskExecutionRolePolicy`
if [ -z "$POLICY_NAME" ]
then
aws iam --profile $AWS_CLI_PROFILE attach-role-policy --role-name ecsTaskExecutionRole --policy-arn arn:aws:iam::aws:policy/service-role/AmazonECSTaskExecutionRolePolicy
fi

ecs-cli configure --cluster $NAME --default-launch-type FARGATE --config-name $NAME --region $AWS_DEFAULT_REGION
if [ $? != 0 ]; then
  echo "ERROR: $0 failed, exiting"
  exit 1
fi

#ecs-cli configure profile --access-key $AWS_ACCESS_KEY_ID --secret-key $AWS_SECRET_ACCESS_KEY --profile-name $NAME-profile


if [ "$LOADVARS" = 'on' ]; then
    export CLUSTER_VPC=`grep 'VPC created:' $LOGDIR/tmp_loader.tmp | cut -f2 -d: | tr -d ' '`
    export CLUSTER_SUBNET1=`grep 'Subnet created:' $LOGDIR/tmp_loader.tmp | head -1 | cut -f2 -d: | tr -d ' '`
    export CLUSTER_SUBNET2=`grep 'Subnet created:' $LOGDIR/tmp_loader.tmp | tail -1 | cut -f2 -d: | tr -d ' '`
    export CLUSTER_SG=`grep SECURITYGROUPS $LOGDIR/tmp_sg.tmp | cut -f3`
fi
if [ "$SHUTDOWN" = 'on' ]; then
    ecs-cli compose \
        --project-name $NAME \
        service down \
        --cluster-config $NAME \
        --aws-profile $AWS_CLI_PROFILE
    ecs-cli down --force \
        --cluster-config $NAME \
        --aws-profile $AWS_CLI_PROFILE
fi

if [ "$LOAD" = 'on' ]; then

  DOCKERDIFF=`diff docker-compose.yml docker-compose.ecs.yml`
  if [ -z "$DOCKERDIFF" ]; then
      echo "docker-compose.yml verified to match docker-compose.ecs.yml"
  else
      echo "ERROR: docker-compose.yml does not match docker-compose.ecs.yml"
      exit 1
  fi

  # moved to install
  #aws iam --region us-west-2 create-role --role-name ecsTaskExecutionRole --assume-role-policy-document file://task-execution-assume-role.json
  #aws iam --region us-west-2 attach-role-policy --role-name ecsTaskExecutionRole --policy-arn arn:aws:iam::aws:policy/service-role/AmazonECSTaskExecutionRolePolicy
  #ecs-cli configure --cluster $NAME --default-launch-type FARGATE --config-name $NAME --region us-west-2
  #ecs-cli configure profile --access-key $AWS_ACCESS_KEY_ID --secret-key $AWS_SECRET_ACCESS_KEY --profile-name $NAME-profile

  ecs-cli up \
      --cluster-config $NAME \
      --aws-profile $AWS_CLI_PROFILE \
      --no-associate-public-ip-address \
          | tee $LOGDIR/tmp_loader.tmp
  if [ $? != 0 ]; then
    echo "ERROR: $0 failed, exiting"
    exit 1
  fi

  export CLUSTER_VPC=`grep 'VPC created:' $LOGDIR/tmp_loader.tmp | cut -f2 -d: | tr -d ' '`
  export CLUSTER_SUBNET1=`grep 'Subnet created:' $LOGDIR/tmp_loader.tmp | head -1 | cut -f2 -d: | tr -d ' '`
  export CLUSTER_SUBNET2=`grep 'Subnet created:' $LOGDIR/tmp_loader.tmp | tail -1 | cut -f2 -d: | tr -d ' '`

  #aws ec2 describe-security-groups
  aws ec2 describe-security-groups \
      --profile $AWS_CLI_PROFILE \
      --output text \
      --filters Name=vpc-id,Values=$CLUSTER_VPC \
          | tee $LOGDIR/tmp_sg.tmp
  if [ $? != 0 ]; then
    echo "ERROR: $0 failed, exiting"
    exit 1
  fi

  export CLUSTER_SG=`grep SECURITYGROUPS $LOGDIR/tmp_sg.tmp | cut -f3`

  # this allows access
  aws ec2 authorize-security-group-ingress \
      --profile $AWS_CLI_PROFILE \
      --group-id $CLUSTER_SG \
      --protocol tcp --port 80 \
      --cidr 0.0.0.0/0
  if [ $? != 0 ]; then
    echo "ERROR: $0 failed, exiting"
    exit 1
  fi

  ecs-cli compose \
      --project-name $NAME \
      service up \
      --aws-profile $AWS_CLI_PROFILE \
      --create-log-groups \
      --cluster-config $NAME
  if [ $? != 0 ]; then
    echo "ERROR: $0 failed, exiting"
    exit 1
  fi


  ecs-cli compose \
      --project-name $NAME \
      service ps \
      --aws-profile $AWS_CLI_PROFILE \
      --cluster-config $NAME
fi

if [ "$STATUS" = 'on' ]; then
    ecs-cli compose \
        --project-name $NAME \
        service ps \
        --cluster-config $NAME \
        --aws-profile $AWS_CLI_PROFILE
fi
exit $RV
