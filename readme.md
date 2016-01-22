# FitCraft
STACK Details
Apache 2.2.4 or nginx 
mysql >= 5.6
php >=5.5
memcached 2.2.0

To connect another DB it is needed to change settings in file /Fitcraft/config/database.php
and make changes in next params:
host
database
username
password

To set up Forum it is needed to make changes in file /Fitcraft/public/forum/config.php
and make changes in next params:
$dbhost
$dbport
$dbname
$dbuser
$dbpasswd
