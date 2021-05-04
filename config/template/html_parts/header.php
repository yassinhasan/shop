<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=  gettitle() ?></title>
    <link rel="stylesheet" href= <?= CSS_PATH."bootstrap.min.css" ?>>
      <link rel="stylesheet" href= <?= CSS_PATH."all.min.css" ?>>
      <link rel="stylesheet" href= <?= CSS_PATH."style.css" ?>>
      
      <?php global $title;
      
      echo (isset($title) && $title == 'login') ? "<link rel='stylesheet' href='./themes/css/login.css'" : ''?>
    
</head>
<body>
<?php
    // $url =trim($_SERVER["REQUEST_URI"] , '/');
    // $url = explode("/",$url);
    // // var_dump($url);
    // if( (isset($url[0]) && $url[0] == "admin" && count($url) == 1) || ( isset($url[1]) && $url[1] == "index.php") ) 
    // {
    //     return false;
    // }
    // else
    // {
    //     get_navbar();
    // }
 ?>   


