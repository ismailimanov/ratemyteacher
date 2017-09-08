<?php
session_start();

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'ratemyteacher';

$link = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($link->connect_error) {
    die('Connect Error ('.$link->connect_errno.') '.$link->connect_error);
}
$link->set_charset('utf8');

require 'functions.php';
?>
