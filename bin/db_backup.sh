#!/bin/bash

. `dirname $0`/bootstrap.sh

mysqldump -u $env_username -p'$env_password' -r $sql_dir/$env_database.`date '+%Y%m%d'`.sql --add-drop-table $env_database
