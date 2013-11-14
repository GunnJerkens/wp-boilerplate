#!/bin/bash

ssh remoteuser@remoteserver \ 'mysqldump -u user -ppassword database' \ | mysql -u user -ppassword database