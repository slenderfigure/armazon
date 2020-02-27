<?php

if (!isset($_POST['asyncrequest'])) {
    header('Location: ../becomeaseller.php');
    exit();
}

require '../classes/DBRequest.class.php';

$sellerDetails = json_decode($_POST['sellerDetails']);
$request = new DBRequest();

echo $request->sellerEnrollment(
    $sellerDetails->userlogin,
    $sellerDetails->shopname,
    $sellerDetails->product_type
);