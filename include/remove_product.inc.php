<?php

if (!isset($_POST['asyncrequest'])) {
    header('Location: ../viewmylistings.php');
    exit();
}

require '../classes/DBRequest.class.php';

$productId = $_POST['productId'];
$request   = new DBRequest();

echo $request->deleteProduct($productId);