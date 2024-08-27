<?php

    //Making sure no errors can be displayed in the website.
    ini_set('display_errors', 0);
    //Telling PHP to log our errors instead.
    ini_set('log_errors', 1);
    //Letting PHP know where to log errors.
    ini_set('error_log', '../ERROR LOG/error.log');
    //Telling PHP which errors to report.
    error_reporting(E_ALL);

?>