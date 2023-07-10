#!/bin/bash

if [ ! -f .env ]; then
    echo "Be sure to run this from the project root directory!"
    exit 1
fi

if [ "$1" = "install" ]; then

    docker container run --rm -v "$(pwd):/usr/src/app" -w /usr/src/app node:14 npm install

    exit $?
fi

if [ "$1" = "prod" ]; then

    if [ ! -d node_modules ]; then
        echo "You need to run '$0 install' first."
        exit 1
    fi

    docker container run --rm -v "$(pwd):/usr/src/app" -w /usr/src/app node:14 npm run prod
    exit $?

fi

echo "USAGE: $0 [install|prod]"
echo "install - install / update node_modules directory"
echo "prod - npm run prod in docker"

