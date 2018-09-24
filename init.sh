#!/bin/bash

#####################
#   VARS && INIT    #
#####################

wordpress=4.9.8

cd `dirname $0`

set -e

read -p "Is this a new project? (y/N) "
if [[ ! $REPLY =~ ^[Yy](es)?$ ]]; then
  read -p "Is this a clone of an existing project? (y/N) "
  if [[ $REPLY =~ ^[Yy](es)?$ ]]; then
    type=clone
    echo -e "\nSet project type to clone."
  else
    echo -e "\nNo project type set, exiting.."
    exit 1
  fi
else
  type=initial
  echo -e "\nSet project type to initial."
fi

#####################
#   GIT/WP/PLUGINS  #
#####################

if [[ $type = "initial" ]]; then

  rm -rf .git
  git init

  read -p "Use git repo other than GitHub for WP? (y/N) "
  if [[ $REPLY =~ ^[Yy](es)?$ ]]; then
    read -p "What is the ssh url of the repo? " url
    sed -i.bak s#git@github.com:WordPress/WordPress.git#$url#g .gitmodules || true
  fi

fi

if [ "$1" != "test" ]; then

  if [[ $type = "initial" ]]; then

    #Initialize Submodules
    git config -f .gitmodules --get-regexp '^submodule\..*\.path$' > tempfile

    while read -u 3 path_key path
      do
        url_key=$(echo $path_key | sed 's/\.path/.url/')
        url=$(git config -f .gitmodules --get "$url_key")
        rm -rf $path; git submodule add $url $path;
        echo "$path has been initialized";
      done 3<tempfile

    rm tempfile

    #Advanced Custom Fields
    curl -LOk http://downloads.wordpress.org/plugin/advanced-custom-fields.zip
    tar -zxvf advanced-custom-fields.zip
    mv advanced-custom-fields public/content/plugins/
    rm -rf advanced-custom-fields.zip

    #WordPress SEO
    curl -LOk http://downloads.wordpress.org/plugin/wordpress-seo.latest-stable.zip
    tar -zxvf wordpress-seo.latest-stable.zip wordpress-seo
    mv wordpress-seo public/content/plugins
    rm -rf wordpress-seo.latest-stable.zip

  else

    git submodule update --init

  fi

else
  echo -e "\nTesting enabled .. skipped WP & plugin downloads."
fi

#####################
#      CONFIGS      #
#####################

if [[ $type = "initial" ]]; then
  echo -e "\nCreating project wp-config and config.sh"
else
  echo -e "\nCreating config.sh only"
  echo -e "\nWARNING: All setings should match wp-config.php!"
fi

cp bin/config.sample.sh bin/config.sh
wpconfig="public/wp-config.php"
binconfig="bin/config.sh"



# Development Configs
read -p "What is the local hostname? (e.g., example.test) " hostname_test
read -p "What is the local database name? (e.g., database_test) " db_test

if [[ $type = "initial" ]]; then
  sed -i.bak s/{hostname_test}/$hostname_test/g $wpconfig || true
  sed -i.bak s/{db_test}/$db_test/g $wpconfig || true
fi

sed -i.bak s/{db_test}/$db_test/g $binconfig || true


# Staging Configs
read -p "What is the staging hostname? (e.g., staging.example.com) " hostname_staging
read -p "What is the staging database name? (e.g., database_staging) " db_staging
read -p "What is the staging webroot path? (e.g., /var/www/staging.example.com/public) " wr_staging
read -p "What is the staging ssh username? (e.g., root) " ssh_staging
read -p "What is the staging ssh port? (e.g., 22) " port_staging

if [[ $type = "initial" ]]; then
  sed -i.bak s/{hostname_staging}/$hostname_staging/g $wpconfig || true
  sed -i.bak s/{db_staging}/$db_staging/g $wpconfig || true
fi

sed -i.bak s/{hostname_staging}/$hostname_staging/g $binconfig || true
sed -i.bak s/{db_staging}/$db_staging/g $binconfig || true
sed -i.bak s/{ssh_staging}/$ssh_staging/g $binconfig || true
sed -i.bak s/{port_staging}/$port_staging/g $binconfig || true
sed -i.bak s/{wr_staging}/${wr_staging//\//\\\/}/g $binconfig || true


# Production Configs
read -p "What is the prod hostname? (e.g., example.com) " hostname_prod
read -p "What is the prod database name? (e.g., database_prod) " db_prod
read -p "What is the prod database username? (e.g., root) " un_prod
read -p "What is the prod database password? (e.g., drowsapp) " pw_prod
read -p "What is the prod ssh username? (e.g., root) " ssh_prod
read -p "What is the prod ssh port? (e.g., 22) " port_prod
read -p "What is the prod webroot path? (e.g., /var/www/example.com/public) " wr_prod

if [[ $type = "initial" ]]; then
  sed -i.bak s/{hostname_prod}/$hostname_prod/g $wpconfig || true
  sed -i.bak s/{db_prod}/$db_prod/g $wpconfig || true
  sed -i.bak s/{un_prod}/$un_prod/g $wpconfig || true
  sed -i.bak s/{pw_prod}/$(echo $pw_prod | sed -e 's/\\/\\\\/g' -e 's/\//\\\//g' -e 's/&/\\\&/g')/g $wpconfig || true
fi

sed -i.bak s/{hostname_prod}/$hostname_prod/g $binconfig || true
sed -i.bak s/{db_prod}/$db_prod/g $binconfig || true
sed -i.bak s/{un_prod}/$un_prod/g $binconfig || true
sed -i.bak s/{pw_prod}/$(echo $pw_prod | sed -e 's/\\/\\\\/g' -e 's/\//\\\//g' -e 's/&/\\\&/g')/g $binconfig || true
sed -i.bak s/{ssh_prod}/$ssh_prod/g $binconfig || true
sed -i.bak s/{port_prod}/$port_prod/g $binconfig || true
sed -i.bak s/{wr_prod}/${wr_prod//\//\\\/}/g $binconfig || true


echo -e "\nConfigs complete!"

echo -e "----------"

#####################
#   ENVIRONMENTS    #
#####################

# Development Environment
read -p "Is this a local environment? (y/N) "
if [[ $REPLY =~ ^[Yy](es)?$ ]]
then

  touch env_local

  read -p "Would you like me to create the local database? (y/N) "
  if [[ $REPLY =~ ^[Yy](es)?$ ]]
  then

    mysql -uroot -e "CREATE DATABASE $db_test COLLATE utf8_general_ci" || true
    read -p "Would you like to import a sql file? (y/N) "
    if [[ $REPLY =~ ^[Yy](es)?$ ]]
    then
      read -p "Where is the file located? (e.g., /home/user/sql/example.sql) " sql
      mysql -uroot $db_test < $sql || true
      if [[ $type = "initial" ]]; then
        read -p "What is the table prefix?" table
        sed -i.bak s/gj_/$table/g $wpconfig || true
      fi
    else
      echo -e "\n(╯°□°）╯︵ ┻━┻)"
    fi
  else
    echo -e "\nFine, we won't create a database together."
  fi


# Staging
else
read -p "Is this a staging environment? (y/n) "
  if [[ $REPLY =~ ^[Yy](es)?$ ]]
  then

    touch env_staging

    read -p "Would you like me to create the staging database? (y/n) "
    if [[ $REPLY =~ ^[Yy](es)?$ ]]
    then

      mysql -uroot -e "create database $db_staging" || true
      read -p "Would you like to import a sql file? (y/n) "
      if [[ $REPLY =~ ^[Yy](es)?$ ]]
      then
        read -p "Where is the file located? (e.g., /home/user/sql/example.sql) " sql
        mysql -uroot $db_staging < $sql || true
        if [[ $type = "initial" ]]; then
          read -p "What is the table prefix?" table
          sed -i.bak s/gj_/$table/g $wpconfig || true
        fi
      else
        echo -e "\nWe shant."
      fi
    else
    echo -e "\nFine, I didn't want to make one anyway."
    fi

  else
    echo -e "\nWhy are you on a production box? >_<"
  fi
fi

#####################
#    SALTS/README   #
#####################

if [[ $type = "initial" ]]; then

echo -e "\nGrabbing secret keys for your config.."

salts=$(curl https://api.wordpress.org/secret-key/1.1/salt/| perl -pe 's/\n/newline/s' | perl -pe 's/[\/&]/\\&/g')
sed -i.bak "s/{salts}/$salts/g" public/wp-config.php || true
sed -i.bak -e 's/newline/\'$'\n/g' public/wp-config.php || true

mv public/_.htaccess public/.htaccess

echo -e "\nCreated a .htaccess file successfully, creating blank readme.."

rm -rf README.md

cat > README.md <<EOF
Project Name
=============
Uses default markdown syntax from [GitHub Markup](https://github.com/github/markup)

Notes
------------

Developers
------------


------------
Project created using [Gunn/Jerkens WordPress Boilerplate](https://github.com/GunnJerkens/wp-boilerplate)
EOF
fi

#####################
#      DIRS/NPM     #
#####################

rm -rf LICENSE
rm -rf *.bak
rm -rf bin/*.bak
rm -rf public/sed*
rm -rf public/*.bak

mkdir -p public/shared
ln -s ../shared public/content/uploads
mkdir public/content/upgrade

cd public/wp && git checkout $wordpress
echo -e "\nNow on latest branch -- WordPress $wordpress"

read -p "Do you want to install node modules? (y/n) "
if [[ $REPLY =~ ^[Yy](es)?$ ]]
then
  npm install
  echo -e "\nNode modules installed."
else
  echo -e "\nYou'll need to run npm install from the project root to use Webpack."
fi

echo -e "\nInitialization complete -- happy coding! Use bin/db_fetch.sh to sync databases and bin/uploads_sync to sync images. You may need to manually set your permissions."
