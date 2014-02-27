#!/bin/bash

if [ ! -f `dirname $0`/config.sh ]; then
  echo "please copy config.sample.sh to config.sh, and edit"
  exit 1
fi
. `dirname $0`/config.sh

if [ -f `dirname $0`/../env_staging ]; then
  env="staging"
  if [ -z "$remote_env" ]; then
    remote_env="production"
  fi
elif [ -f `dirname $0`/../env_local ]; then
  env="local"
  if [ -z "$remote_env" ]; then
    remote_env="production"
  fi
else
  env="production"
fi

echo "env: $env"
env_database=`eval "echo \\$${env}_database"`
env_username=`eval "echo \\$${env}_username"`
env_password=`eval "echo \\$${env}_password"`
env_webroot=`eval "echo \\$${env}_webroot"`

if [ -n "$remote_env" ]; then
  echo "remote: $remote_env"
  remote_database=`eval "echo \\$${remote_env}_database"`
  remote_username=`eval "echo \\$${remote_env}_username"`
  remote_password=`eval "echo \\$${remote_env}_password"`
  remote_ssh=`eval "echo \\$${remote_env}_ssh"`
  remote_ssh_port=`eval "echo \\$${remote_env}_ssh_port"`
  remote_webroot=`eval "echo \\$${remote_env}_webroot"`
else
  echo "no remote env"
fi
