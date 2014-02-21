#!/bin/bash

cd `dirname $0`/..

set -e

read -p "Do you want to remove your .git and reinitialize all submodules? (y/n) "
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

#Advanced Custom Fields
curl -LOk http://downloads.wordpress.org/plugin/advanced-custom-fields.zip
tar -zxvf advanced-custom-fields.zip
mv advanced-custom-fields public/content/plugins/
rm -rf advanced-custom-fields.zip

#WordPress SEO
curl -LOk http://downloads.wordpress.org/plugin/wordpress-seo.1.4.24.zip
tar -zxvf wordpress-seo.1.4.24.zip wordpress-seo
mv wordpress-seo public/content/plugins
rm -rf wordpress-seo.1.4.24.zip

echo -e "\nWe have come so far! Onto the environments..."

read -p "What is the local hostname? (e.g., example.dev) " hostname_dev
sed -i.bak s/{hostname_dev}/$hostname_dev/g public/wp-config.php || true

read -p "What is the staging hostname? (e.g., dev.example.com) " hostname_staging
sed -i.bak s/{hostname_staging}/$hostname_staging/g public/wp-config.php || true

read -p "What is the local database name? (e.g., database_dev) " db_dev
sed -i.bak s/{db_dev}/$db_dev/g public/wp-config.php || true

read -p "What is the staging database name? (e.g., database_staging) " db_staging
sed -i.bak s/{db_staging}/$db_staging/g public/wp-config.php || true


# Development
read -p "Is this a local environment? (y/n) "
if [[ $REPLY =~ ^[Yy]$ ]]
then

  touch env_local
    
  read -p "Would you like me to create the local database? (y/n) "
  if [[ $REPLY =~ ^[Yy]$ ]]
  then
    
    mysql -uroot -e "create database $db_dev" || true
    read -p "Would you like to import a sql file? (y/n) "
    if [[ $REPLY =~ ^[Yy]$ ]]
    then
      read -p "Where is the file located? (e.g., /home/user/sql/example.sql) " sql
      mysql -uroot $db_dev < $sql || true
      read -p "What is the table prefix?" table
      sed -i.bak s/gj_/$table/g public/wp-config.php || true
    else
      echo -e "\n::tableflip:: === off"
    fi
  else
    echo -e "\nNo database for you!"
  fi


# Staging
else
read -p "Is this a staging environment? (y/n) "
  if [[ $REPLY =~ ^[Yy]$ ]]
  then

    touch env_stage

    read -p "Would you like me to create the staging database? (y/n) "
    if [[ $REPLY =~ ^[Yy]$ ]]
    then
    
      mysql -uroot -e "create database $db_staging" || true
      read -p "Would you like to import a sql file? (y/n) "
      if [[ $REPLY =~ ^[Yy]$ ]]
      then
        read -p "Where is the file located? (e.g., /home/user/sql/example.sql) " sql
        mysql -uroot $db_staging < $sql || true
        read -p "What is the table prefix?" table
        sed -i.bak s/gj_/$table/g public/wp-config.php || true
      else
        echo -e "\nWe shant."
      fi
    else
    echo -e "\nFine, I didn't want to make one anyway!"
    fi
    
  else
    echo -e "\nWhy are you on a production box? >_<"
  fi
fi

# Production
read -p "What is the production hostname? (e.g., example.com) " hostname_prod
sed -i.bak s/{hostname_prod}/$hostname_prod/g public/wp-config.php || true

read -p "What is the production database name? (e.g., database_prod) " db_prod
sed -i.bak s/{db_prod}/$db_prod/g public/wp-config.php || true
 
# Global
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

rm -rf public/sed*
rm -rf public/*.bak

mkdir -p public/shared
ln -s ../shared public/content/uploads
mkdir public/content/upgrade

cd public/wp && git checkout 3.8.1
echo -e "\nNow on latest branch -- WordPress 3.8.1"

read -p "Do you want to install node modules? (y/n) "
if [[ $REPLY =~ ^[Yy]$ ]]
then
  npm install
  echo -e "\nNode modules installed."
else
  echo -e "\nYou'll need to run npm install from the project root to use Grunt."
fi

echo -e "\nInitialization complete -- happy coding! Use db_sync.sh to sync databases. You may need to manually set your permissions."
