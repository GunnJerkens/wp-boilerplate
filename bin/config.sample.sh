#!/bin/bash

# If you're not sure what value a variable should have, please leave it blank.
#
# Anything wrapped in {} is set during the init.sh script

production_database={db_prod}
production_username={un_prod}
production_password='{pw_prod}'
# ssh user and server, or blank (e.g. remoteuser@remoteserver)
production_ssh={ssh_prod}@{hostname_prod}
production_ssh_port=22
production_webroot={wr_prod}

staging_database={db_staging}
staging_username=$production_username
staging_password=$production_password
# ssh user and server, or blank (e.g. remoteuser@remoteserver)
staging_ssh={ssh_staging}@{hostname_staging}
staging_ssh_port=22
staging_webroot={wr_staging}

local_database={db_dev}
local_username=root
local_password=

#leave this empty to use the default, otherwise "local", "staging" or "production"
remote_env=

sql_dir=`dirname $0`/../sql
