<?php

if (!isset($_POST['signin-submit'])) {
    header('Location: ../signin.php');
    exit();
}

require '../classes/DBRequest.class.php';

$login       = $_POST['login'];
$password    = $_POST['password'];
$verifyLogin = new DBRequest();

if (!$verifyLogin->verifyUserCredentials($login, 'login')) {
    header("Location: ../signin.php?login=$login&status=not+found");
    exit();
}

if (!$verifyLogin->verifyUserCredentials($password, 'password')) {
    header("Location: ../signin.php?password=invalid&login=$login");
    exit();
}

/** AFTER ALL VALIDATIONS ARE MET */
$login = $verifyLogin->getUserLogin();
session_start();
$_SESSION['login'] = $login;
setrawcookie('userlogin', $login, time() + (86400 * 30), "/");

header('Location: ../index.php?signin+successful');