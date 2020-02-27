<?php
    include 'header.php';
    include 'include/get_products.inc.php';

    if ($details->seller) {
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
            <li><a class="active-link" href="becomeaseller.php">Become a seller</a></li>
        </ul>

        <section class="control-panel">
            <article>
                <h3>Do you own a shop or wish to start your new business? Take it to the next level by becoming a seller with Armazon Seller Program!</h3>

                <p>Enjoy incredible benefits to help your selling business flourish. Discover everything you need to know about Armazon Seller Program from A to Z, simply by clicking <a href="#">here</a>, or become a seller right away by filling out our easy-steps appliaction form below.</p>
            </article>

            <form method="post" name="sellerForm">
                <div class="row">
                    <label for="shopname">Your shop name</label>
                    <input class="form-input" type="text" name="shopname" autofocus>
                </div>
                <div class="row">
                    <label for="typeofproduct">What types of products you sell?</label>
                    <select class="form-input" name="typeofproduct">
                        <option value="1">Appliances</option>
                        <option value="2">Beauty & Personal Care</option>
                        <option value="3">Cell Phones & Accessories</option>
                        <option value="4">Clothing, Shoes & Jewelry</option>
                        <option value="5">Collectibles & Fine Art</option>
                        <option value="6">Computers</option>
                        <option value="7">Electronics</option>
                        <option value="8">Handmade</option>
                        <option value="9">Home & Business Services</option>
                        <option value="10">Home & Kitchen</option>
                        <option value="11">Movies & TV</option>
                        <option value="12">Musical Instruments</option>
                        <option value="12">Vehicles</option>
                        <option value="14">Video Games</option>
                    </select>
                </div>
                <div class="row spcl">
                    <span class="enrollment-agreement">I hereby state to have read all Terms & Conditions, and all infromation regarding Armazon Seller Program and associates.</span>
                    <span>I Agree</span> <input type="checkbox" name="agreement">
                </div>
                <div class="row">
                    <button class="btn btn-l">Become a Seller</button>
                </div>
            </form>
       </section>

       
    </div>
</main>

<script src="src/js/becomeaseller.js"></script>
<?php
    include 'footer.html';
?> 