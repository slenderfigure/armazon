<?php
    if (isset($_POST['asyncrequest'])) {
        $path = '../classes/DBRequest.class.php';
    } else {
        $path = 'classes/DBRequest.class.php';
    }

    require_once $path;
    $select = new DBRequest();

    $categoryId = !isset($_POST['categoryId']) ? '' : $_POST['categoryId']; 
    $productId  = !isset($_POST['productId'])  ? '' : $_POST['productId']; 

    function getAllProducts($categoryId, $productId, $seller = null) {
        $products  = array();
        global $select;
        
        function matchImages($productId) {
            global $select;
            $images = array();
    
            foreach($select->getProductImages($productId) as $image) {
                array_push($images, array("imageId" => $image['imageId'], 
                "url" => $image['url']));
            }
            return $images;
        }
        
        foreach ($select->getProducts($categoryId, $productId, $seller) as $value) {      
            $value['images'] = matchImages($value['productId']);
            array_push($products, $value);
        }

        return $products;
    }

    if (isset($_POST['asyncrequest'])) {
        echo json_encode(getAllProducts($categoryId, $productId));
    }
?>