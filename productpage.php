<?php
    include 'header.php';
    include 'include/get_products.inc.php'; 
?>
<main>
<?php
    if (!isset($_GET['productId'])) {
        header('Location: index.php');
        exit();
    }

    $productId = filter_var($_GET['productId'],  FILTER_SANITIZE_NUMBER_INT);
    $product   = (object)getAllProducts('', $productId)[0];

    $productName    = $product->product_name;
    $listedPrice    = '$'.number_format($product->listed_price, 2);
    $currentPrice   = '$'.number_format($product->current_price, 2);
    $productDetails = explode(';', $product->product_details);
    $freeShipping   = $product->free_shipping;
    $ProductImages  = $product->images;
    $ProductImages  = $ProductImages;

    echo 
    '<section class="product-info-container">
        <div class="product-images-container">           
            <ul class="thumbnails-container">';
            foreach($ProductImages as $index => $image) {
                if ($index < 6) {
                    if ($index == 0) {
                        echo '<li class="thumbnails active"><img src="'.$image['url'].'" alt="'.$productName.'"></li>';
                    } else {
                        echo '<li class="thumbnails"><img src="'.$image['url'].'" alt="'.$productName.'"></li>';
                    }
                }
            }
    echo    '</ul>
            
            <img class="img-preview" src="'.$ProductImages[0]['url'].'" alt="'.$productName.'">
            
            <div class="order-menu">
                <p class="name">'.$productName.'</p>
                <p class="price">'.$currentPrice.'</p>';
                if ($freeShipping == true) { 
                    echo '<p class="freeshipping">FREE Shipping by Armazon</p>'; 
                }
    echo        '<p class="estimated-date">Get it as soon as Tomorrow, Nov 22</p>
                <button class="buy-now-btn">
                    Add to Cart
                    <i class="material-icons">&#xe8cc;</i>
                </button>
                <button class="buy-now-btn">
                    Buy Now
                    <i class="material-icons">&#xe5c8;</i>
                </button>
            </div>
        </div>
        
        <ul class="product-desc">
            <h2>Product Description:</h2>';
        foreach($productDetails as $item) {
            echo '<li>'.$item.'</li>';
        }
    echo
        '</ul>
    </section>';
?>
</main>

<script src="src/js/productpage.js"></script>>
<?php
    include 'footer.html';
?>  