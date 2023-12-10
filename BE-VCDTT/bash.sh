#!/bin/sh
cd /home/u230440822/domains/vcdtt.online/public_html/DATN-VCDTT/BE-VCDTT;
php artisan schedule:work >> /dev/null 2>&1
