#!/bin/bash
python3 /var/scripts/garbage_collector_db.py &
apachectl -D FOREGROUND
