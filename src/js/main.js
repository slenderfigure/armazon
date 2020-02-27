class FetchRequest {
    static getProducts(categoryId = '', productId = '') {
        let formData = new FormData();
        formData.set('asyncrequest', true);
        formData.set('categoryId', categoryId);
        formData.set('productId', productId);

        fetch('include/get_products.inc.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(products => UI.showProducts(products, categoryId))
        .catch(err => console.log('Fetch Error ', err));
    }
}

class UI {
    static showProducts(products, categoryId) {
        let container = document.querySelector('.products-container');
        let hasFreeShipping = '';

        container.innerHTML = '';

        function currencyFormat(num) {
            return '$' + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
        }

        function appendProducts(product) {
            let productCard = document.createElement('div');
            productCard.className = 'product-card';

            hasFreeShipping = product.free_shipping == true ?
            '<p class="additional-info">FREE Shipping by Armazon</p>' : '';

            productCard.innerHTML =
            `<a class="product-img" 
            href="productpage.php?productId=${product.productId}">
                <img src="${product.images[0].url}" alt="${product.product_name}">
            </a>

            <div class="product-desc">
                <a class="name" 
                href="productpage.php?productId=${product.productId}">${product.product_name}</a>

                <p class="price">${currencyFormat(product.current_price)}</p>
                <p class="additional-info">Get it as soon as Tomorrow, Nov 22</p>
                ${hasFreeShipping}

                <button class="buy-now-btn">Buy Now</button>
            </div>`;

            container.appendChild(productCard); 
        }

        products.forEach(product => {
            product.current_price = parseFloat(product.current_price);
            product.listed_price  = parseFloat(product.listed_price);

            if (categoryId !== '' && product.categoryId == categoryId) {
                appendProducts(product);
            }
            else if (categoryId == '') {
                appendProducts(product);
            }       
        });
    }

    static filterByProductName(product) {
        let container = document.querySelector('.products-container');
        let productCards = document.querySelectorAll('.product-card');
        let results = true;

        if (product !== '') {
            productCards.forEach(card => {
                card.style.display = 'grid';
            });
    
            productCards.forEach(card => {
                let name = card.querySelector('.name').innerHTML.toUpperCase();
    
                if (name.indexOf(product.toUpperCase()) == -1) {
                    card.style.display = 'none';
                    results = false;
                } 
            });
        }
    }
}

//Event: Load All Products
document.addEventListener('DOMContentLoaded', () => FetchRequest.getProducts());


//Event: Filter Product List by Name
let filterByProduct = document.forms['filterForm']
.addEventListener('submit', e => {
    let product = e.target['product-name'].value.trim();

    e.preventDefault();       
    UI.filterByProductName(product);
});


//Event: Filter Product List by Category
let filterByCategory = document.querySelector('form[name="filterForm"] select')
.addEventListener('change', e => {
    let categoryId = e.target.value == '0' ? '' : e.target.value;
    FetchRequest.getProducts(categoryId);
});