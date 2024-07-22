<?php
session_start();

$_SESSION = [];
if (isset($_COOKIE[session_name()])) setcookie(session_name(), '', time() - 4200, '/'); //Cookieに保存された値も削除する
session_destroy();
header("Location: /user/signin.php");
exit;