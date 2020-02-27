<?php

if (!isset($_POST['asyncrequest'])) {
    header('Location: ../viewmylistings.php');
    exit();
}

require '../classes/DBRequest.class.php';
include '../include/generate_image_dir.inc.php';

$request = new DBRequest();

$productId      = $_POST['productId'];
$productName    = $_POST['product-name'];
$category       = $_POST['category'];
$price          = $_POST['price'];
$freeshipping   = $_POST['freeshipping'];
$details        = $_POST['details'];
$imagesToUpload = !isset($_FILES['imagesToUpload']) ? null : $_FILES['imagesToUpload'];
$imagesToDelete = !isset($_POST['imagesToDelete'])  ? null : $_POST['imagesToDelete'];
$dbImageURI     = array ();

if ($imagesToUpload !== null) {
    for($i = 0; $i < count($imagesToUpload['name']); $i++) {
        $name = $imagesToUpload['name'][$i];
        $tmp_name = $imagesToUpload['tmp_name'][$i];
        array_push($dbImageURI, saveProductImage($productId, $name, $tmp_name));
    }
}

$request->updateProduct(
    $productId,
    $productName,
    $price,  
    $details, 
    $freeshipping,
    $category,
    $imagesToDelete,
    $dbImageURI
);