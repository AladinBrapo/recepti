<?php
$db_host = 'localhost';
$db_name = 'jayram_yummies';
$db_user = 'jayram_yummies';
$db_password = 'dUUees,=k$3C';

// Create connection
$link = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}
mysqli_set_charset($link, "utf8mb4");
?>