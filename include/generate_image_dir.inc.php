<?php

function saveProductImage($productId, $name, $tmp_name) {
    $ext = pathinfo($name, PATHINFO_EXTENSION);
    $dir = "../data/product_images/productID____$productId/";
    $destination = $dir.uniqid("product-image____", true).mt_rand().".$ext";

    if (!file_exists($dir)) {
        mkdir($dir);
    }

    move_uploaded_file($tmp_name, $destination);

    return explode('../', $destination)[1];
}