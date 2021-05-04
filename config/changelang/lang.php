<?php
defined("DS") ? NULL : define("DS", DIRECTORY_SEPARATOR);
require  "../../ini.php";

if( $_SESSION['lang'] == "AR")
{
    
    $_SESSION['lang'] = "EN";
}
else
{
    $_SESSION['lang'] = "AR";
}

$URL = $_SERVER['HTTP_REFERER'];
 header("location: $URL") ;

