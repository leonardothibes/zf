#!/bin/bash

DATE=$(date +%Y-%m-%d)
ROOT=$(dirname $0)/..
LOG=${ROOT}/data/logs
ME=$(whoami)

if [ ! -d $LOG ]; then
    mkdir $LOG
fi

sudo chmod 777 $LOG
sudo rm -f $LOG/*.log

sudo touch $LOG/php_$DATE.log
sudo touch $LOG/application_$DATE.log

sudo chown $ME $LOG/*.log
sudo chmod 777 $LOG/*.log
