<?php

$url = $_SERVER['REQUEST_URI'];

$strings = explode('/', $url);

$current_page = end($strings);

$dbname = 'wouldYouRatherDB';//Name your database library this in PHPmyAdmin
$dbuser = 'root';
$dbpass = '';
$dbserver = 'localhost';

?>
