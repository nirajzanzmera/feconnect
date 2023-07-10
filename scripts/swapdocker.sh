#!/bin/bash


WHICHFILE=$1

DIFFECS=`diff docker-compose.yml docker-compose.ecs.yml`
DIFFLOCAL=`diff docker-compose.yml docker-compose.local.yml`
BAKVERIFIED='off'


if [ -z "$DIFFECS" -o -z "$DIFFLOCAL" ]; then
    BAKVERIFIED='on'
else
    echo "docker-compose.yml must match either docker-compose.ecs.yml or docker-compose.local.yml"
    exit 1
fi

if [ "$WHICHFILE" = 'status' ]; then
    if [ -z "$DIFFECS" ]; then
        echo "Using ECS version"
    fi
    if [ -z "$DIFFLOCAL" ]; then
        echo "Using local version"
    fi
    exit 0
fi

if [ "$WHICHFILE" = 'ecs' -a -f docker-compose.ecs.yml ]; then
    if [ -z "$DIFFECS" ]; then
        echo "Already using ECS version"
        exit 0
    fi

    echo "Switching docker-compose.yml to ECS version"
    cp docker-compose.ecs.yml docker-compose.yml
    exit 0
fi

if [ "$WHICHFILE" = 'local' -a -f docker-compose.local.yml ]; then
    if [ -z "$DIFFLOCAL" ]; then
        echo "Already using local version"
        exit 0
    fi
    echo "Switching docker-compose.yml to local version"
    cp docker-compose.local.yml docker-compose.yml
    exit 0
fi

echo "USAGE: $0 [ecs|local|status]"
echo "  ecs - ready for ecs"
echo "  local - ready for local use"
echo "  status - report status"
exit 1

#echo BAKVERIFIED $BAKVERIFIED 
#echo DIFFECS $DIFFECS 
#echo DIFFLOCAL $DIFFLOCAL
