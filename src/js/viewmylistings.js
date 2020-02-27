function getProduct(productId) {
    let xhl = ServerRequest.XHLRequest(
        'include/get_products.inc.php', 
        `asyncrequest=true&categoryId=&productId=${productId}`
    );

    xhl.onload = function() {
        if (this.status == 200) {
            appendProductInfo(JSON.parse(this.responseText)[0]);
        }
    }
    xhl.onerror = () => console.log("There was an error fetching the data");
}

function deleteProduct(productId) {
    let xhl = ServerRequest.XHLRequest(
        'include/remove_product.inc.php', 
        `asyncrequest=true&productId=${productId}`
    );

    xhl.onload = function () {
        if (this.status == 200) {
            console.log(this.responseText);
        }
    }
    xhl.onerror = () => console.log("There was an error fetching the data");
}

function deleteProductConfirmation(productId) {
    let overlay = new DocOverlay();
    let msgbox = document.createElement('div');

    msgbox.className = 'msg-box msg-box-s';
    msgbox.innerHTML = `
    <i class="close-box material-icons">&#xe5cd;</i>

    <div class="msg-box-content">
        <h3>Confirmation</h3>

        <p>Are you sure you'd like to remove this product listing?</p>

        <span>Doing so will cause this product listing to no longer be 
        viewable by potential buyers, and all information (product rating,
        number of purchases, reviews, etc.) will be lost. You may 
        read more about Armazon terms & conditions for sellers by 
        clicking <a href="#">here</a></span>
    </div>
    <div class="button-wrapper">
        <button class="btn btn-s discard">Discard</button>
        <button class="btn btn-s proceed">Proceed</button>
    </div>`; 

    overlay.showOverlay(msgbox);

    document.querySelector('.discard').addEventListener('click', () => {
        overlay.hideOverlay();
    });

    document.querySelector('.proceed').addEventListener('click', () => {
        deleteProduct(productId);
        overlay.hideOverlay();
        setTimeout(() => location.href = 'viewmylistings.php', 300);
    });
}

function updateProductListing(form, toUpload, toDelete) {
    let productId    = form['productId'].value;
    let productName  = form['product-name'].value;
    let category     = form['category'].value;
    let price        = form['price'].value;
    let freeshipping = form['freeshipping'].value;
    let details      = Array.from(form['details[]']);
    let productData  = new productFormData(
        productId,
        productName,
        category,
        price,
        freeshipping,
        details,
        toUpload,
        toDelete
    );

    productData.createProductData('include/update_product.inc.php');
    setTimeout(() => location.href = 'viewmylistings.php', 1000);
}

function removeProductImage(toDelete, toUpload) {
    let container = document.querySelector('.product-imgs');
    
    container.addEventListener('click', e => {
        if (e.target.matches('.remove-img')) {
            let card = e.target.parentElement.parentElement;
            
            if (!card.classList.contains('unset')) {
                let imageId = card.dataset.imageid;
                
                toDelete.push(imageId);
            } else {
                toUpload.forEach((image, index) => {
                    if (card.id === image.name) {
                        toUpload.splice(index, 1);
                    }
                });
            }

            card.style.animation = 'deleted 0.1s ease forwards';
            setTimeout(() => card.remove(), 100);
        }
    });
}


function createProductImage(toUpload) {
    let container = document.querySelector('.product-imgs');
    let input     = document.querySelector('input[name="product-imgs"]');

    if (input == null) { return; }

    input.addEventListener('change', e => {
        let images   = Array.from(e.target.files);

        images.forEach(image => toUpload.push(image));

        images.forEach(image => {
            let src = URL.createObjectURL(image);
            let card = document.createElement('div');
           
            card.id = image.name;
            card.className = 'unset card';
            card.innerHTML = `
            <div class="overlay">
                <i class="remove-img fas fa-ban" title="Remove"></i>
            </div>
            
            <img src="${src}" alt="To be uploaded">`;
            card.style.animation = 'inserted 0.3s ease';

            container.insertBefore(card, container.querySelector('.add-img-btn')); 
        });

        input.value = '';
    });    
}


function appendProductInfo(product) {
    let container = document.createElement('div');
    let overlay   = new DocOverlay();
    let toUpload  = [];
    let toDelete  = [];
    
    container.className = 'product-edit-container';

    let category = () => {
        let select = document.querySelector('select[name="category"]');
        let categories = [
            'Appliances',
            'Beauty & Personal Care',
            'Cell Phones & Accessories',
            'Clothing, Shoes & Jewelry',
            'Collectibles & Fine Art',
            'Computers',
            'Electronics',
            'Handmade',
            'Home & Business Services',
            'Home & Kitchen',
            'Movies & TV',
            'Musical Instruments',
            'Vehicles',
            'Video Games',
        ]; 
        
        categories.forEach((category, index) => {
            let option = document.createElement('option');
            let categoryId = index + 1;

            option.value = categoryId;
            option.innerHTML = category;
    
            if (product.categoryId == categoryId) {
                option.selected = true;
            }

            select.appendChild(option);
        });
    }

    let freeshipping = () => {
        let options;

        if (product.free_shipping == 0) {
            options = `
            <option value="0" selected>No</option>
            <option value="1">Yes</option>`;
        } else {
            options = `
            <option value="0">No</option>
            <option value="1" selected>Yes</option>`;
        }
        return options;
    }
    
    let productDetails = () => {
        let  details  = '';
        product.product_details.split(';').forEach(detail => {
            details += `<input class="form-input" type="text" 
            name="details[]" value="${detail}">`;
        });
        return details;
    }

    let thumbnails = () => {
        let card = '';

        product.images.forEach(image => {
            card += `
            <div class="card" data-imageId="${image.imageId}">
                <div class="overlay">
                    <i class="remove-img fas fa-ban" title="Remove"></i>
                </div>
                
                <img src="${image.url}" alt="${product.product_name}">  
            </div>`;
        });

        if (product.images.length < 10) {
            card += `
            <label class="add-img-btn card">
                <i class="material-icons" title="add">&#xe145;</i>
                <input name="product-imgs" type="file" multiple>
            </label>`;
        }
        return card;
    }

    container.innerHTML = `
    <i class="close-box material-icons">&#xe5cd;</i>

    <form class="content" action="include/update_product.inc.php" method="POST"
    enctype="multipart/form-data" id="productImgForm" >
        <div class="product-info">
            <input type="hidden" name="productId" value=${product.productId}>
            <div class="row">
                <h3>Product name</h3>
                <input class="form-input" type="text" 
                name="product-name" value="${product.product_name}" 
                maxlength="200">
            </div>

            <div class="row">
                <h3>Category</h3>
                <select class="form-input" name="category"></select>
            </div>
            
            <div class="row">
                <h3>Price</h3>
                <input class="form-input" type="number" step="0.01" min="0" 
                name="price" value="${product.current_price}">
            </div>

            <div class="row">
                <h3>Has freeshipping?</h3>
                <select class="form-input" name="freeshipping">
                    ${freeshipping()}
                </select>
            </div>
            
            <div class="desc row">
                <h3>Product Details</h3>                            
                ${productDetails()}
            </div>
        </div>

        <div class="product-imgs">
            ${thumbnails()}
        </div>
    </form>
    <button class="save-btn btn" type="submit" 
    name="update-product" value="update" form="productImgForm">Save Changes</button>`;

    overlay.showOverlay(container);
    
    // Update category dropdown to reflect current product's category
    category();

    // Get Images
    createProductImage(toUpload);
    
    // Remove Image
    removeProductImage(toDelete, toUpload);

    // Form Submit Event
    document.querySelector('#productImgForm')
    .addEventListener('submit', e => {
        e.preventDefault();
        updateProductListing(e.target, toUpload, toDelete);
    });
}


// Event: Update/Delete Product Listing
let productListing = document.querySelector('.control-panel')
.addEventListener('click', e => {
    if (e.target.matches('a')) {
        e.preventDefault();
       
        let productId = e.target.parentElement.querySelector('#productId').value;
        getProduct(productId);
    }
    else if (e.target.matches('.delete-product')) {
        let productId = e.target.parentElement.querySelector('#productId').value;
        deleteProductConfirmation(productId);
    }
});