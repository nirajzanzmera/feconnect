#!/bin/bash

#TODO: add --remaster (to find current master, and make a new master of its own choosing)
#  will run scripts/run.sh --name=newmaster --load --master --oldproc=oldmaster

RV=0
usage() {
  cat <<EndOfUsage
usage $0: [options] (load|shutdown|status required)
    -c, --config <file path> (default .env)
    -d, --shutdown  shutdown ECS task service
    -r, --restart  shutdown and start again
    -h, --help
    -s, --status    show ECS task service status
        --allstat     show all the known status for name iterations in this region
        --shortstat     show the short status of the current name
        --remaster      find current instance, hot swap a new one then shutdown the old
                    similar to --load, --master, and --shutdown of named processes
    -u, --load      create and run ECS task service
    -l, --logs      show available recent logs
    -m, --master    switch current instance to master subdomain
    -o, --oldproc   shut down old process name after setting new master
        --region   override default region
    -v, --verbose   increase verbosity
EndOfUsage
}

TEMP=$(getopt -o c:n:o:dhsuvlrm --long config:,name:,oldproc:,region:,allstat,restart,remaster,help,load,logs,shutdown,status,verbose,master,shortstat \
  -n awsdockerup.sh -- "$@")
if [ $? != 0 ]; then usage; exit 1; fi

eval set -- "$TEMP"

CONFIG='.env'
OPTS=''
LOAD='off'
LOGDIR='log'
SCRIPTDIR=scripts
SHUTDOWN='off'
STATUS='off'
SHORTSTAT='off'
RESTART='off'
LOGS='off'
MASTER='off'
VERBOSE=0
NAMEOVERRIDE=''
OLDPROC=''
SLOT1SUFFIX='-1'
SLOT2SUFFIX='-2'
ALLSTAT='off'
REMASTER='off'
REGIONOVERRIDE=''
while true; do
  case "$1" in
    -c | --config ) CONFIG="$2"; OPTS="$OPTS -c $CONFIG"; shift 2 ;;
    -d | --shutdown ) SHUTDOWN='on'; shift ;;
    -r | --restart ) RESTART='on'; shift ;;
    -h | --help ) usage; exit ;;
    -n | --name ) NAMEOVERRIDE="$2"; OPTS="$OPTS -n $NAMEOVERRIDE"; shift 2 ;;
    -o | --oldproc ) OLDPROC="$2"; shift 2 ;;
    -s | --status ) STATUS='on'; shift ;;
         --shortstat ) SHORTSTAT='on'; shift ;;
         --allstat ) ALLSTAT='on'; shift ;;
         --remaster ) REMASTER='on'; shift ;;
         --region ) REGIONOVERRIDE="$2"; OPTS="$OPTS --region $REGIONOVERRIDE"; shift 2 ;;
    -u | --load ) LOAD='on'; shift ;;
    -l | --logs ) LOGS='on'; shift ;;
    -m | --master ) MASTER='on'; shift ;;
    -v | --verbose ) VERBOSE=$(($VERBOSE + 1)); OPTS="$OPTS -v"; shift ;;
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

if [ \
      "$LOAD" != 'on' -a \
      "$SHUTDOWN" != 'on' -a \
      "$STATUS" != 'on' -a \
      "$LOGS" != 'on' -a \
      "$RESTART" != 'on' -a \
      "$MASTER" != 'on' -a \
      "$SHORTSTAT" != 'on' -a \
      "$ALLSTAT" != 'on' -a \
      "$REMASTER" != 'on' -a \
      1 = 1 \
      ]
then
  usage
  exit 1;
fi

if [ "$SHORTSTAT" = 'on' ]; then
    bash $SCRIPTDIR/awsloadbalancer.sh ${OPTS} --shortstat 2> /dev/null
    exit 0
fi

if [ "$ALLSTAT" = 'on' ]; then
    for n in ${NAME}${SLOT1SUFFIX} ${NAME}${SLOT2SUFFIX} ${NAME} ${NAME}1 ${NAME}2 ; do
      echo -n "$n "
      bash $SCRIPTDIR/awsloadbalancer.sh --region=$AWS_DEFAULT_REGION --config=$CONFIG --name=$n --shortstat 2> /dev/null
    done
    exit 0
fi

if [ "$REMASTER" = 'on' ]; then
  if [ -z "$MASTER_SUBDOMAIN" ]; then
    echo "$0: error MASTER_SUBDOMAIN not specified, exiting"
    exit 1
  fi
  if [ -z "$DOMAIN" ]; then
    echo "$0: error DOMAIN not specified, exiting"
    exit 1
  fi

  echo "$0: remaster $MASTER_SUBDOMAIN.$DOMAIN on $NAME "
  echo "$0: checking for current instances"
  bash $0 ${OPTS} --allstat | tee $LOGDIR/allstat.log
  curinstcnt=$(grep active $LOGDIR/allstat.log | wc -l)
  curinstance=$(grep active $LOGDIR/allstat.log | head -1 | cut -f1 -d' ')
  echo "$0: Live instance count: $curinstcnt ; first: $curinstance"
  if [ $curinstcnt = 1 ]; then
    if [ "${NAME}${SLOT1SUFFIX}" != "$curinstance" ]; then
      echo "$0 Remastering into ${NAME}${SLOT1SUFFIX} from $curinstance"
      bash $0 --config=$CONFIG --name=${NAME}${SLOT1SUFFIX} --master --load --oldproc=$curinstance --region=$AWS_DEFAULT_REGION 
      if [ $? != 0 ]; then
        echo "ERROR: $0 failed, exiting"
        exit 1
      fi
    elif [ "${NAME}${SLOT2SUFFIX}" != "$curinstance" ]; then
      echo "$0 Remastering into ${NAME}${SLOT2SUFFIX} from $curinstance"
      bash $0 --config=$CONFIG --name=${NAME}${SLOT2SUFFIX} --master --load --oldproc=$curinstance --region=$AWS_DEFAULT_REGION 
      if [ $? != 0 ]; then
        echo "ERROR: $0 failed, exiting"
        exit 1
      fi

    else
      echo "$0 Error, could not remaster from $curinstance"
      exit 1
    fi
  elif [ $curinstcnt = 0 ]; then
    echo "$0 Remastering into ${NAME}${SLOT1SUFFIX} (no current instance)"
    bash $0 --config=$CONFIG --name=${NAME}${SLOT1SUFFIX} --master --load --region=$AWS_DEFAULT_REGION 
    if [ $? != 0 ]; then
      echo "ERROR: $0 failed, exiting"
      exit 1
    fi

  else
    echo "$0: ERROR: Currently more than once instance"
    exit 1
  fi
  exit 0
fi

if [ "$STATUS" = 'on' ]; then
    bash $SCRIPTDIR/awsdockerup.sh ${OPTS} --status
    bash $SCRIPTDIR/awsloadbalancer.sh ${OPTS} --status
    exit 0
fi

if [ "$LOGS" = 'on' ]; then
  aws logs tail ecs-${NAME}-task-logs \
      --profile=$AWS_CLI_PROFILE \
      --region=$AWS_DEFAULT_REGION
  exit 0
fi

if [ "$RESTART" = 'on' ]; then
    bash $SCRIPTDIR/run.sh ${OPTS} --shutdown
    bash $SCRIPTDIR/run.sh ${OPTS} --load
    if [ $? != 0 ]; then
      echo "ERROR: $0 failed, exiting"
      exit 1
    fi

    exit 0
fi

if [ "$SHUTDOWN" = 'on' ]; then
    bash $SCRIPTDIR/awsloadbalancer.sh ${OPTS} --shutdown
    bash $SCRIPTDIR/awsdockerup.sh ${OPTS} --shutdown
    exit 0
fi

# if [ "$MASTER" = 'on' ]; then
#     bash $SCRIPTDIR/awsloadbalancer.sh ${OPTS} --master
#     exit 0
# fi

if [ "$LOAD" = 'on' ]; then
    DOCKERDIFF=`diff docker-compose.yml docker-compose.ecs.yml`
    if [ -z "$DOCKERDIFF" ]; then
        echo "docker-compose.yml verified to match docker-compose.ecs.yml"
    else
        echo "ERROR: docker-compose.yml does not match docker-compose.ecs.yml"
        exit 1
    fi

    checkstat=`bash $SCRIPTDIR/run.sh ${OPTS} --shortstat`
    if [ "$checkstat" != 'off' ]; then
      echo "$0: ERROR: service $NAME is currently status $checkstat and must be off to load, exiting"
      exit 1
    fi


    bash $SCRIPTDIR/awsinstall.sh ${OPTS}
    if [ $? != 0 ]; then
      echo "ERROR: $0 failed, exiting"
      exit 1
    fi

    if [ -z "$AWS_LISTENER_CERT" ]; then
        bash $SCRIPTDIR/awscert.sh ${OPTS}
        if [ $? != 0 ]; then
          echo "ERROR: $0 failed, exiting"
          exit 1
        fi

    fi
    bash $SCRIPTDIR/awsdockerup.sh ${OPTS} --load
    if [ $? != 0 ]; then
      echo "ERROR: $0 failed, exiting"
      exit 1
    fi

    bash $SCRIPTDIR/awsloadbalancer.sh ${OPTS} --load
    if [ $? != 0 ]; then
      echo "ERROR: $0 failed, exiting"
      exit 1
    fi

    if [ "$MASTER" != 'on' ]; then
      exit 0
    else
      echo "$0: Continuing to remaster $NAME as $MASTER_SUBDOMAIN.$DOMAIN"
    fi
fi

if [ "$MASTER" = 'on' ]; then
    lbstat=''
    if [ -z "$MASTER_SUBDOMAIN" ]; then
      echo "ERROR: MASTER_SUBDOMAIN not defined"
      exit 1
    fi

    echo "$0: Waiting for loadbalancer status='active'..."
    while [ "$lbstat" != 'active' ]; do
        lbstat=`bash $SCRIPTDIR/awsloadbalancer.sh ${OPTS} --shortstat`
        if [ "$lbstat" = 'off' ]; then
          echo "ERROR: LoadBalancer status is off for $NAME, start new instance $NAME"
          exit 1
        fi
    done
    # lbstat is now active
    # give it a chance to instansiate
    echo "$0: Waiting 60 seconds for active load balancer boot for $NAME"
    sleep 60
    lbstat=`bash $SCRIPTDIR/awsloadbalancer.sh ${OPTS} --shortstat`
    if [ "$lbstat" = 'active' ]; then
        bash $SCRIPTDIR/awsloadbalancer.sh ${OPTS} --master
        if [ $? != 0 ]; then
          echo "ERROR: $0 failed, exiting"
          exit 1
        fi

        echo "New master $NAME established for $MASTER_SUBDOMAIN.$DOMAIN"
    else
        echo "$0: lbstat = $lbstat ; exiting"
        exit 1
    fi

    if [ ! -z "$OLDPROC" ]; then
        echo "$0: Shutting down $OLDPROC"
        bash $SCRIPTDIR/run.sh ${OPTS} --shutdown --name=$OLDPROC
        echo "$0: $OLDPROC shut down complete"
    fi

fi

exit $RV
