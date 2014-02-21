#!/bin/bash

# If you're not sure what value a variable should have, please leave it blank.
#
production_database=db_production
production_username=root
production_password=password
# ssh user and server, or blank (e.g. remoteuser@remoteserver)
production_ssh=
production_webroot=

staging_database=db_staging
staging_username=$production_username
staging_password=$production_password
# ssh user and server, or blank (e.g. remoteuser@remoteserver)
staging_ssh=
staging_webroot=

local_database=db_dev
local_username=root
local_password=

#leave this empty to use the default, otherwise "local", "staging" or "production"
remote_env=

sql_dir=`dirname $0`/../sql
