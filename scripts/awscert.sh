#!/bin/bash
RV=0
usage() {
  cat <<EndOfUsage
usage $0: [options]
    -c, --config <file path> (default .env)
    -h, --help
    -n, --name <cluster name>   name to use (overrides .env)
    -v, --verbose   increase verbosity
EndOfUsage
}

TEMP=$(getopt -o c:n:hv --long config:,name:,region:,help,verbose \
  -n awsdockerup.sh -- "$@")
if [ $? != 0 ]; then usage; exit 1; fi

eval set -- "$TEMP"

CONFIG='.env'
LOGDIR='log'
TARGET_GROUP_NAME="ecs-target-$NAME-tcp80"
VERBOSE=0
NAMEOVERRIDE=''
REGIONOVERRIDE=''
while true; do
  case "$1" in
    -c | --config ) CONFIG="$2"; shift 2 ;;
    -h | --help ) usage; exit ;;
    -n | --name ) NAMEOVERRIDE="$2"; shift 2 ;;
    -v | --verbose ) VERBOSE=$(($VERBOSE + 1)); shift ;;
    --region ) REGIONOVERRIDE="$2"; shift 2 ;;
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

ZONEID=`aws route53 list-hosted-zones \
    --profile $AWS_CLI_PROFILE  \
    --output json \
         | jq ".HostedZones[] | select(.Name==\"$DOMAIN.\") | .Id" -r`
#ZONEID=`aws route53 --profile $AWS_CLI_PROFILE_JSON  list-hosted-zones | jq ".HostedZones[0].Id" -r`
if [ -z "$ZONEID" ]; then
    echo "Zone for $DOMAIN not yet supported, creating..."
    echo "Adding it!"
	ref=$DOMAIN-$date
	aws route53 create-hosted-zone \
		--profile $AWS_CLI_PROFILE \
		--output json \
		--name $DOMAIN \
		--caller-reference $ref \
			| tee $LOGDIR/dnszone-$DOMAIN.log

    ZONEID=`aws route53 list-hosted-zones \
        --profile $AWS_CLI_PROFILE  \
        --output json \
            | jq ".HostedZones[] | select(.Name==\"$DOMAIN.\") | .Id" -r`
    echo "Found zone $ZONEID for $DOMAIN"

else
    echo "Found zone $ZONEID for $DOMAIN"
fi


CERTARN=`aws acm list-certificates \
    --profile $AWS_CLI_PROFILE \
    --output json \
        | jq ".CertificateSummaryList[] | select(.DomainName==\"*.$DOMAIN\") | .CertificateArn" -r`
if [ -z "$CERTARN" ]; then

    echo "No Cert found for *.$DOMAIN... creating"
    aws acm request-certificate \
        --profile $AWS_CLI_PROFILE \
        --output text \
        --validation-method DNS \
        --domain-name "*.$DOMAIN" \
            | tee $LOGDIR/tmp_certasn.tmp
    CERTARN=`cat $LOGDIR/tmp_certasn.tmp`
# {
#    "CertificateArn": "arn:aws:acm:us-west-2:754491681211:certificate/4518f2ab-e0ea-4d20-8d17-10467fa97f72"
#}
    sleep 10
fi

aws acm describe-certificate \
    --profile $AWS_CLI_PROFILE \
    --output json \
    --certificate-arn $CERTARN \
        | tee $LOGDIR/tmp_cert_desc.tmp
if [ $? != 0 ]; then
    echo "aws acm describe-certificate failed, exiting"
    exit 1
fi

newname=`jq " .Certificate.DomainValidationOptions[0].ResourceRecord.Name " -r $LOGDIR/tmp_cert_desc.tmp`
newtype=`jq " .Certificate.DomainValidationOptions[0].ResourceRecord.Type " -r $LOGDIR/tmp_cert_desc.tmp`
newvalue=`jq " .Certificate.DomainValidationOptions[0].ResourceRecord.Value " -r $LOGDIR/tmp_cert_desc.tmp`
validationstatus=`jq " .Certificate.DomainValidationOptions[0].ValidationStatus " -r $LOGDIR/tmp_cert_desc.tmp`

if [ -z "$newname" ]; then
    echo "validation of certificate failed, exiting: re-run!"
    exit 1
fi

if [ "$validationstatus" = "PENDING_VALIDATION" ]; then

    echo "Adding DNS for new cert"

    CHANGEBATCH=`cat <<EOF
'{
    "Comment": "Update DNS record for cert",
    "Changes": [
        {
            "Action": "UPSERT",
            "ResourceRecordSet": {
                "Type": "$newtype",
                "ResourceRecords": [{
                    "Value": "$newvalue"
                }],
                "Name": "$newname",
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
        | tee $LOGDIR/tmp_changedns_auth.tmp
    . $LOGDIR/tmp_changedns_auth.tmp
    

else
    echo "Found cert $CERTARN"
fi


#aws route53 list-hosted-zones \
#    --profile $AWS_CLI_PROFILE_JSON 


    echo aws acm describe-certificate \
        --profile $AWS_CLI_PROFILE \
        --output json \
        --certificate-arn $CERTARN 

    aws acm describe-certificate \
        --profile $AWS_CLI_PROFILE \
        --output json \
        --certificate-arn $CERTARN \
            | tee $LOGDIR/tmp_cert_desc.tmp

echo Useful commands:
echo aws route53 list-resource-record-sets \
    --profile $AWS_CLI_PROFILE  \
    --output json \
    --hosted-zone-id $ZONEID 
echo aws acm delete-certificate \
    --profile $AWS_CLI_PROFILE \
    --certificate-arn $CERTARN
echo aws route53 delete-hosted-zone \
    --profile $AWS_CLI_PROFILE \
    --id $ZONEID
echo aws acm describe-certificate \
        --profile $AWS_CLI_PROFILE \
        --output json \
        --certificate-arn $CERTARN

exit $RV
