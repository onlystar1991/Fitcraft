<?php
// phpBB 3.1.x auto-generated configuration file
// Do not change anything in this file!
$dbms = 'phpbb\\db\\driver\\mysqli';
$dbhost = (getenv('APPLICATION_ENV') == 'development' || getenv('APPLICATION_ENV') == 'testing')?'50.62.209.7':'localhost';
$dbport = '3306';
$dbname = 'fitcraft_forum';
$dbuser = 'root';
$dbpasswd = 'root';
$table_prefix = 'zzBB_';
$phpbb_adm_relative_path = 'adm/';
$acm_type = 'phpbb\\cache\\driver\\file';

@define('PHPBB_INSTALLED', true);
//@define('PHPBB_DISPLAY_LOAD_TIME', true);
//@define('DEBUG', true);
//@define('DEBUG_CONTAINER', true);
