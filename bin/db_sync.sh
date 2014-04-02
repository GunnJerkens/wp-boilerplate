#!/bin/bash

. `dirname $0`/bootstrap.sh

if [ -z "$remote_env" ]; then
  echo "this server appears to be at the top of the food chain (production?)"
  exit 1
elif [ -z "$remote_ssh" ]; then
  echo "please specify a remote SSH user"
  exit 1
fi

echo -n "(local mysql) "
ssh -p $remote_ssh_port $remote_ssh \ "mysqldump -u$remote_username -p'$remote_password' $remote_database" \ | mysql -u$env_username -p$env_password $env_database