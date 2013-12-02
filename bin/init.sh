#!/bin/bash

cd `dirname $0`/..

set -e

read -p "Do you want to remove your .git and reinitialize all submodules? (y/n) " -n 1
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
    exit 1
fi


rm -rf .git
git init


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


echo -e "\nWe have come so far! Onto the environments..."

echo -e "Is this a local environment? (y/n) "
read -n 1
if [[ $REPLY =~ ^[Yy]$ ]]
then

  read -p "What is the local hostname? (e.g., example not example.dev) " hostname
  sed -i.bak s/{hostname}/$hostname/g public/wp-config.php || true

  read -p "What is the local database name? (e.g., database_dev) " database
  sed -i.bak s/{database}/$database/g public/wp-config.php || true

  touch public/env_local
  echo -e "\nWould you like me to create a database? (y/n) "
  read -n 1
  if [[ $REPLY =~ ^[Yy]$ ]]
  then
    
    mysql -uroot -e "create database $database" || true
    echo -e "\nWould you like to import a sql file? (y/n) "
    read -n 1
    if [[ $REPLY =~ ^[Yy]$ ]]
    then
      read -p "Where is the file located? (e.g., /home/user/sql/example.sql) " sql
      mysql -uroot $database < $sql || true
      read -p "What is the table prefix?" table
      sed -i.bak s/gj_/$table/g public/wp-config.php || true
    else
      echo -e "\n::tableflip:: === off"
    fi
  else
    echo -e "\nNo database for you!"
  fi

else
echo -e "\nIs this a staging environment? (y/n) "
  read -n 1
  if [[ $REPLY =~ ^[Yy]$ ]]
  then

    read -p "What is the staging hostname? (e.g., use example not dev.example.com) " hostname
    sed -i.bak s/{hostname}/$hostname/g public/wp-config.php || true

    read -p "What is the staging database name? (e.g., database_dev) " database
    sed -i.bak s/{database}/$database/g public/wp-config.php || true

    touch public/env_stage

  else
    echo -e "\nWhy are you on a production box? >_<"
  fi
fi

echo -e "\nGrabbing secret keys for your config.."

salts=$(curl https://api.wordpress.org/secret-key/1.1/salt/| perl -pe 's/\n/\\n/g' | perl -pe 's/[\/&]/\\&/g')
sed -i.bak "s/{salts}/$salts/g" public/wp-config.php || true

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

rm -rf public/sed*
rm -rf public/*.bak

mkdir -p public/shared
ln -s ../shared uploads
mkdir public/content/upgrade

echo -e "Do you have sudo access and want to reset /public/ permissions to www-data? (y/n) "
read -n 1
if [[ $REPLY =~ ^[Yy]$ ]]
then
  sudo chown -R www-data public/content/ || true
  sudo chown -R www-data public/shared/ || true
  sudo chmod -R 775 public/content/ || true
  sudo chmod -R 775 public/shared/ || true
  echo -e "\n Ownership & permissions change completed."
else
  echo -e "\n You may need to manually set your permissions"
fi

cd public/wp && git checkout 3.7.1
echo -e "\nNow on latest branch -- WordPress 3.7.1"

echo -e "\nInitialization complete -- happy coding! Use db_sync.sh to sync databases."
