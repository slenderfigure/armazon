<?php
    include 'header.php';
?>
<main>
    <aside class="sidebar">
        <form action="" name="filterForm">
            <div class="row">
                <label name="category">Filter by Category</label>
                <select class="form-input" name="category">
                    <option value="0">All</option>
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
                <label for="product-name">Search Product</label>
                <input class="form-input" type="text" name="product-name" placeholder="Search">
            </div>

            <div class="row">
                <button class="btn btn-l" type="submit">Filter Results</button>
            </div>
        </form>
    </aside>

    <section class="products-container"></section>
</main>

<script src="src/js/main.js"></script>
<?php
    include 'footer.html';
?>  