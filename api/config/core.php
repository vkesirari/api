<?php
//show error reporting
error_reporting(E_ALL);
ini_set('display error',1);

//home url
$home_url = "http://localhost/api/";
//page given in url paramter ,  default page is 1
$page = isset( $_GET['page']) ? $_GET['page'] : 1;

//set number of record per page
$records_per_page = 5;

//query limit clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
