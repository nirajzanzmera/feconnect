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
REGIONOVERRIDE='';
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

if [ ! -d "$LOGDIR" ]
then
  mkdir $LOGDIR
fi

if [ ! -f task-execution-assume-role.json ]; then
    echo "ERROR: missing file task-execution-assume-role.json"
    exit 1
fi

if [ ! -f ecs-params.yml ]; then
    echo "ERROR: missing file ecs-params.yml"
    exit 1
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


#NOTE: To unwind:
# aws ecr delete-repository --repository-name=repo-$NAME
export AWS_DEFAULT_REGION
export NAME
export DOMAIN


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
  aws iam --profile $AWS_CLI_PROFILE --region $AWS_DEFAULT_REGION attach-role-policy --role-name ecsTaskExecutionRole --policy-arn arn:aws:iam::aws:policy/service-role/AmazonECSTaskExecutionRolePolicy
fi

ecs-cli configure --cluster $NAME --default-launch-type FARGATE --config-name $NAME --region=$AWS_DEFAULT_REGION
if [ $? != 0 ]; then
  echo "ERROR: $0 failed, exiting"
  exit 1
fi

#ecs-cli configure profile --access-key $AWS_ACCESS_KEY_ID --secret-key $AWS_SECRET_ACCESS_KEY --profile-name $NAME-profile

# TODO check if repo exists before creation
REPO_RUNNING=`aws ecr describe-repositories \
	--profile $AWS_CLI_PROFILE \
	--output json \
	 | jq ".repositories[] | select(.repositoryName==\"repo-$NAME\") | .repositoryUri" -r`
echo $REPO_RUNNING
if [ -z "$REPO_RUNNING" ]; then
	# create repository

		aws ecr create-repository --output json --profile $AWS_CLI_PROFILE --repository-name repo-$NAME --region=$AWS_DEFAULT_REGION | tee $LOGDIR/tmp_repo.tmp
    if [ $? != 0 ]; then
      echo "ERROR: $0 failed, exiting"
      exit 1
    fi
    AWS_ECS_REPO=`jq -r .repository.repositoryUri $LOGDIR/tmp_repo.tmp` 

	else

		AWS_ECS_REPO=`echo $REPO_RUNNING` # | cut -f7 | tr -d ' '`

fi
echo $AWS_ECS_REPO
if [ -z "$AWS_ECS_REPO" ]; then
  echo "Repo name retrieval failed."
  exit 1
fi
echo $AWS_ECS_REPO > $LOGDIR/tmp_reponame.tmp

# get auth token
aws ecr get-login-password --profile $AWS_CLI_PROFILE --region=$AWS_DEFAULT_REGION | docker login --username AWS --password-stdin $AWS_ECS_REPO
if [ $? != 0 ]; then
  echo "ERROR: $0 failed, exiting"
  exit 1
fi

# build the docker image
docker build -t $NAME .
if [ $? != 0 ]; then
  echo "ERROR: $0 failed, exiting"
  exit 1
fi

# tag the image
date=`date +%Y%m%d%H%M`
echo "ECS Image URI: '$AWS_ECS_REPO:$date'"
docker tag $NAME:latest $AWS_ECS_REPO:$date
if [ $? != 0 ]; then
  echo "ERROR: $0 failed, exiting"
  exit 1
fi

#   push the image to the AWS repo
docker push $AWS_ECS_REPO:$date
if [ $? != 0 ]; then
  echo "ERROR: $0 failed, exiting"
  exit 1
fi

echo $AWS_ECS_REPO:$date > $LOGDIR/tmp_liverepo.tmp

# used in docker-compose.yml - needed for local docker-compose up
echo "export AWS_LIVE_IMAGE=`cat $LOGDIR/tmp_liverepo.tmp`"
export AWS_LIVE_IMAGE=`cat $LOGDIR/tmp_liverepo.tmp`

exit $RV
