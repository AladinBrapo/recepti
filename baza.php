<?php
$db_host = 'localhost';
$db_name = 'jayram_techy-trgovina';
$db_user = 'jayram_techy';
$db_password = 'mAxDR_NpcNDJ';

// Create connection
$link = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}
mysqli_set_charset($link, "utf8mb4");
?>