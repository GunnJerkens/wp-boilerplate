#!/bin/bash

cd `dirname $0`/..

set -e

read -p "Local environment? (y/n) " -n 1
if [[ $REPLY =~ ^[Yy]$ ]]
then
  touch public/env_local
  echo -e "\nCreated environment file successfully"
else
  read -p "Staging environment? (y/n) " -n 1
  if [[ $REPLY =~ ^[Yy]$ ]]
  then
    touch public/env_staging
    echo -e "\nCreated environment file successfully"
  else
    echo -e "\nNo environment file was created."
  fi
fi

read -p "Initialize and update submodules? (y/n) " -n 1
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
  exit 1
fi

git submodule update --init

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