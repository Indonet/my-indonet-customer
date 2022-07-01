#!/bin/bash

###
###
###
## DO NOT MODIF

BASENAME=`basename $0`
PHPBIN='/usr/bin/php'

## EXIT IF another instance is still running
if [ $(pidof -x ${BASENAME} | wc -w) -gt 2 ]; then
        echo "Another of ${BASENAME} process is still running... exiting" >&2
        exit 0
fi


## DO CMD HERE

${PHPBIN} "/var/www/my.indonet.id/index.php" api_ax/set_cust_info_ax_kediri

exit 0
