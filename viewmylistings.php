<?php
    include 'header.php';
    include 'include/get_products.inc.php';

    if (!$details->seller) {
        header('Location: userpage.php');
        exit();
    }
?>
<main>
    <div class="userpage-wrapper wrapper">
        <ul class="user-options">
            <li><a href="userpage.php">Account Information</a></li>
            <li><a href="#">My Orders</a></li>
            <li><a href="#">Wish List</a></li>
            <li><a class="active-link" href="viewmylistings.php">View my listings</a></li>
            <li><a href="createproductlisting.php">Create new listing</a></li>
        </ul>

        <section class="control-panel">
            <h2>Your most recent listings</h2>
        <?php
            $products = getAllProducts('', '', $_SESSION['login']);
            
            foreach($products as $key => $product) {
                $product = (object)$product;
                
                echo '
                <section class=listing-container>
                <div class="listing-card">
                    <strong>'.($key + 1).'.</strong> 
                    <a href="#">
                        '.$product->product_name.'
                        <i class="material-icons">&#xe3c9;</i>
                    </a>';

                if (count($product->images) > 0) {
                    echo '<ul class="img-container">';
                    foreach(($product->images) as $key => $image) {
                        if ($key < 8) {
                            echo '
                            <li>
                                <img src="'.$image['url'].'" alt="Product Image '.($key + 1).'">
                            </li>';
                        }
                    }  
                    echo '</ul>';
                }
                echo '
                    <input id="productId" type="hidden" value="'.$product->productId.'">
                    <button class="btn delete-product">Remove this listing</button>
                </div>
            </section>';
            }
        ?>
       </section>
    </div>
</main>


<script src="src/js/viewmylistings.js"></script>
<script src="src/js/classes/productFormData.class.js"></script>
<?php
    include 'footer.html';
?>  