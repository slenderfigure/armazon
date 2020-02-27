<?php

if (!isset($_POST['signup-submit'])) {
    header('Location: ../signup.php');
    exit();
}

require '../classes/DBRequest.class.php';

$fullname   = $_POST['fullname'];
$email      = $_POST['email'];
$password   = $_POST['password'];

function validateInput($input, $type) {
    switch ($type) {
        case 'name':
            $input = strtolower($input);
            $input = trim($input);
            $input = ucwords($input);
            break;
        case 'password':
            $input = password_hash($input, PASSWORD_BCRYPT);
            break;
        default:
            echo 'Invalid Option';
            break;
    }
    return $input;
}

$request = new DBRequest();
$request->createAccount(
    validateInput($fullname, 'name'),
    $email,
    validateInput($password, 'password')
);
header('Location: ../signup.php?acct+creation=true');