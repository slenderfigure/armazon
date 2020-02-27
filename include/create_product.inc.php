<?php
    if (!isset($_POST['asyncrequest'])) {
        header('Location: ../userpage.php');
        exit();
    }
    
    session_start();
    require '../classes/DBRequest.class.php';

    $request = new DBRequest();

    $seller         = $_SESSION['login'];
    $productName    = $_POST['product-name'];
    $category       = $_POST['category'];
    $price          = $_POST['price'];
    $freeshipping   = $_POST['freeshipping'];
    $details        = $_POST['details'];
    $imagesToUpload = !isset($_FILES['imagesToUpload']) ? null : $_FILES['imagesToUpload'];
    
    $request->createProductListing(
        $seller,
        $productName,
        $price,  
        $details, 
        $freeshipping,
        $category,
        $imagesToUpload
    );