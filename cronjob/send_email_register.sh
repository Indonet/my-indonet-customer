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

${PHPBIN} "/var/www/admin-my.indonet.id/index.php" api/send_email_registrasi

exit 0
