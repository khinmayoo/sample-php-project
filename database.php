<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'Password123#@!';
$dbname = 'note';

//mysqli_report(MYSQLI_REPORT_OFF);

$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

if (!$conn) {
    die("error");
}

if (!mysqli_select_db($conn, $dbname)) {
    die("can not select db.");
}
