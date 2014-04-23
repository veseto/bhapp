#!/bin/bash

date=`date -I`

mysqldump -h localhost -u root -pQwerty123456 bethelper | gzip > /home/backups/backup-$date.sql.gz

