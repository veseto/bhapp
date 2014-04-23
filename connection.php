<?php
$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_password = "Qwerty123456";
$mysql_database = "bethelper";
$prefix = "";
$mysqli = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password, $mysql_database);
if (mysqli_connect_errno($mysqli)) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
date_default_timezone_set('Europe/Sofia');

?>