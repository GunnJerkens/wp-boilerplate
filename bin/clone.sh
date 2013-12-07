#!/bin/bash

cd `dirname $0`/..

set -e

read -p "Initialize and update submodules? (y/n) " -n 1
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
  exit 1
fi

git submodule update --init

mkdir public/shared/ || true
ln -s ../shared public/content/uploads

echo "Complete!"
