<?php
session_start();
setcookie('account_u', "", time() - 3600);
setcookie('nananina', "", time() - 3600);
session_destroy();
header("location: index.php") ;
?> 