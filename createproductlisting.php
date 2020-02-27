<?php
    include 'header.php';

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
            <li><a href="viewmylistings.php">View my listings</a></li>
            <li><a class="active-link" 
            href="createproductlisting.php">Create new listing</a></li>
        </ul>

        <section class="control-panel">
            <h2>Create product listing</h2>

            <form method="POST" name="itemListingForm" 
            enctype="multipart/form-data" id="itemListingForm">
                <div class="row">
                    <label for="product-name">Product name</label>
                    <input class="form-input" type="text" 
                    name="product-name" autofocus maxlength="200">
                </div>
                <div class="row">
                    <label for="category">Category</label>
                    <select class="form-input" name="category">
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
                        <option value="13">Vehicles</option>
                        <option value="14">Video Games</option>
                    </select>
                </div>
                <div class="row">
                    <label for="price">Price</label>
                    <input class="form-input" type="number" step="0.01" min="0" name="price" value="0.00">
                </div>
                <div class="row">
                    <label for="freeshipping">Has freeshipping?</label>
                    <select class="form-input" name="freeshipping">
                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <div class="row">
                    <label for="details">Product details</label>
                    <input class="form-input" type="text" name="details[]">
                    <i class="add-details material-icons">&#xe148;</i>
                </div>

                <div class="product-images">
                    <label class="img-card">
                        <i class='fas'>&#xf03e;</i>
                        <input class="product-image" 
                        name="propduct-image" type="file">     
                    </label>
                    <label class="img-card">
                        <i class='fas'>&#xf03e;</i>
                        <input class="product-image" 
                        name="propduct-image" type="file">
                    </label>
                    <label class="img-card">
                        <i class='fas'>&#xf03e;</i>
                        <input class="product-image" 
                        name="propduct-image" type="file">
                    </label>
                    <label class="img-card">
                        <i class='fas'>&#xf03e;</i>
                        <input class="product-image" 
                        name="propduct-image" type="file">
                    </label>
                    <label class="img-card">
                        <i class='fas'>&#xf03e;</i>
                        <input class="product-image" 
                        name="propduct-image" type="file">
                    </label>
                    <label class="img-card">
                        <i class='fas'>&#xf03e;</i>
                        <input class="product-image" 
                        name="propduct-image" type="file">
                    </label>
                    <label class="img-card">
                        <i class='fas'>&#xf03e;</i>
                        <input class="product-image" 
                        name="propduct-image" type="file">
                    </label>
                    <label class="img-card">
                        <i class='fas'>&#xf03e;</i>
                        <input class="product-image" 
                        name="propduct-image" type="file">
                    </label>
                </div>

                <div class="row">
        	        <button class="btn btn-l" type="submit" name="publish-listing">Publish Listing</button>
                </div>
            </form>

            <div class="advertisement"></div>
        </section>
    </div>
</main>

<script src="src/js/createproduct.js"></script>
<script src="src/js/classes/productFormData.class.js"></script>
<?php
    include 'footer.html';
?>  