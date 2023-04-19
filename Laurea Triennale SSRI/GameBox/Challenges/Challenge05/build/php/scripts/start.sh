#!/bin/bash
python3 /var/scripts/garbage_collector_db.py &
/var/scripts/garbage_collector_uploads.sh &
apachectl -D FOREGROUND
