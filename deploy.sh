#!/usr/bin/env bash

set -euo pipefail

ssh admin@94.136.188.124 <<EOF
cd /var/www/homecost.itechut.com
sudo -u www-data git pull
sudo -u www-data php artisan optimize
EOF
