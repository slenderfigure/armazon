<?php

if (!isset($_POST['signout-submit'])) {
    header('Location: ../userpage.php');
    exit();
}

session_start();
unset($_SESSION['login']);
setcookie('userlogin', '', time() - 3600, '/');
session_destroy();
header('Location: ../index.php?signed+out');