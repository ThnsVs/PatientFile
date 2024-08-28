<?php
/*
    - - - CONNECTING TO THE patientfile DB. - - -
*/

define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'patientfile');

$link = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($link->connect_error)
    die("ERROR: Could not connect. " . $link->connect_error);

    
?>
