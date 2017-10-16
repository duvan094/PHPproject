<?php

#our config file, has information about the database, about the current page we're on

$url = $_SERVER['REQUEST_URI'];

$strings = explode('/', $url);

$current_page = end($strings);

$dbname = 'wouldYouRatherLib';//Name your database library this in PHPmyAdmin
$dbuser = 'root';
$dbpass = '';
$dbserver = 'localhost';

//$url = $_SERVER['REQUEST_URI'];
//print_r($url);
//echo "</br>";
//$strings = explode('/', $url);
//print_r($strings);
//echo "</br>";
//$current_page = end($strings);
//print_r($current_page);
//echo "</br>";
//$dbname = 'library';
//$dbuser = 'root';
//$dbpass = '';
//$dbserver = 'localhost';
?>
