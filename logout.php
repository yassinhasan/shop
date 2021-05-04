<?php
require_once "ini.php";
unset($_SESSION['User']);
session_destroy();
$username = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
setcookie("username",$username,time()-3000,"/","shop.com");
header("location: login.php");
exit(); 

