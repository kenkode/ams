<?php
define('CURRENCY', 'Kshs.');
define('WEB_URL', 'http://localhost:84/ams/');
define('ROOT_PATH', 'C:\xampp\htdocs\ams/');


define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'ams_mb');
$link = mysql_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD) or die(mysql_error());mysql_select_db(DB_DATABASE, $link) or die(mysql_error());?>