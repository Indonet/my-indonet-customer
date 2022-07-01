#!/bin/bash

###
###
###
## DO NOT MODIF

BASENAME=`basename $0`
PHPBIN='/usr/bin/php'

log=/var/www/my.indonet.id/cronjob/logs/get_data_ax_manual_by_subnet.log

## EXIT IF another instance is still running
if [ $(pidof -x ${BASENAME} | wc -w) -gt 2 ]; then
        echo "Another of ${BASENAME} process is still running... exiting" >&2
        exit 0
fi


## DO CMD HERE
rm $log
${PHPBIN} "/var/www/my.indonet.id/index.php" api/get_data_ax_manual_by_subnet >> $log

exit 0
