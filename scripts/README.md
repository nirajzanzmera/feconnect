# How to use the AWS scripts:

Set up .env:
```
#AWS_SECRET_ACCESS_KEY=your key
#AWS_ACCESS_KEY_ID=your id
AWS_DEFAULT_REGION=us-west-2
AWS_CLI_PROFILE=yourprofile
DOMAIN=projectdomain.com
APP_PORT=80
CLUSTER_NAME=project-name
NAME=project-name
AWS_LISTENER_CERT=asn-of-cert-for-domain
```

When up, the project will appear at project-name.projectdomain.com


## RUN FROM THE PROJECT ROOT DIRECTORY TO START:

`bash scripts/run.sh [--help|--load|--shutdown|--status]`

## ALTERNATIVELY
-------------
Alternatively, you can run the scripts individually:

1. `bash scripts/awsinstall.sh`

Loads docker file into ECS

2. `bash scripts/awscert.sh`

Sets up DNS and SSL Certificates for specified DOMAIN.
Optional: only required if AWS_LISTENER_CERT not specified
Will not work until AWS controls DNS on specified DOMAIN.

3. `bash scripts/awsdockerup.sh [--help|--load|--shutdown|--status]`

Brings up the installed image in AWS ECS

4. `bash scripts/awsloadbalancer.sh [--help|--load|--shutdown|--status]`

Makes the image accessible on the internet via SSL load balancer
