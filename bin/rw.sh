#!/bin/bash

DATE=$(date +%Y-%m-%d)
ROOT=$(dirname $0)/../data
ME=$(whoami)

# Atribuindo permissão de escrita.
for DIR in $(ls $ROOT)
do
	chmod 777 ${ROOT}/${DIR}
done
# Atribuindo permissão de escrita.

# Limpando diretório de LOGs.
LOG=${ROOT}/logs
chmod 777 $LOG
rm -f $LOG/*.log

touch $LOG/php_$DATE.log
touch $LOG/application_$DATE.log

chown $ME $LOG/*.log
chmod 777 $LOG/*.log
# Limpando diretório de LOGs.
