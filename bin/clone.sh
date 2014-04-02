#!/bin/bash

cd `dirname $0`/..

set -e

read -p "Local environment? (y/n) "
if [[ $REPLY =~ ^[Yy]$ ]]
then
  touch public/env_local
  echo -e "\nCreated environment file successfully"
else
  read -p "Staging environment? (y/n) "
  if [[ $REPLY =~ ^[Yy]$ ]]
  then
    touch public/env_staging
    echo -e "\nCreated environment file successfully"
  else
    echo -e "\nNo environment file was created."
  fi
fi

read -p "Initialize and update submodules? (y/n) "
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
  exit 1
fi

git submodule update --init

read -p "Do you want to install node modules? (y/n) "
if [[ $REPLY =~ ^[Yy]$ ]]
then
  npm install
  echo -e "\nNode modules installed."
else
  echo -e "\nYou'll need to run npm install from the project root to use Grunt."
fi

SHARED=public/shared/
if [ ! -d "$SHARED" ];
then
  mkdir public/shared/ || true
  echo -e "\nCreated shared directory!"
else
  echo -e "\nShared directory exists!"
fi

UPSYM=public/content/uploads
if [ ! -L $UPSYM ]
then
  ln -s ../shared public/content/uploads
  echo "\nCreated symlink!"
else
  echo -e "\nSymlink exists!"
fi

echo -e "\nComplete! HaHa, Business!"