<?php

require_once "../ini.php";

check_access();
$title = "login";
gettheheader();
?>

<!-- <a href="/lang.php"> <?= lang("changelang") ?></a> -->
<a href="../../../../config/changelang/lang.php" class="change-login"> <?= lang("changelang") ?> <i class="fas fa-globe"></i></a>
<?PHP
get_login_form();

getthefooter();
?>
