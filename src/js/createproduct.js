function resetControlPanel() {
    document.querySelector('.add-details').classList.remove('add-details-active');

    document.querySelector('form[name="itemListingForm"]').reset();

    document.querySelectorAll('.img-card')
    .forEach(imgcard => {
        if (imgcard.querySelector('img') !== null) {
            imgcard.querySelector('img').remove();
        }
    });

    document.querySelectorAll('input[name="propduct-image"]')
    .forEach(input => input.value = '');

    document.querySelectorAll('.additionalInput')
    .forEach(additionalInput => additionalInput.remove());

    toUpload = [];
}

function validateinput(productName, price, details) {
    let validated = true;

    if (productName == '' || price == '0.00') {
        validated = false;
    }

    details.forEach(detail => {
        if (detail.value == '') { validated = false; }
    });

    if (toUpload.length == 0) { validated = false; }

    return validated;
}

function showAddDetailsBtn(input) {
    let button = input.parentElement.querySelector('.add-details');

    if (input.value !== '') {
        button.classList.add('add-details-active');
    } else {
        button.classList.remove('add-details-active');
    }
}

function addDetailsBTN() {
    let form  = document.querySelector('#itemListingForm');
    let limit = form.querySelectorAll('input[name="details[]"]').length;
    let row   = document.createElement('div');

    row.className = 'row';
    row.innerHTML = `
    <input class="form-input additionalInput" style="width: 100%" 
    type="text" name="details[]" 
    placeholder="Additional Detail #${limit}">`;

    if (limit == 10) { return; }
    
    form.insertBefore(row, form.querySelector('.product-images'));
}

function showImagePreview(input) {
    let imagecard = input.parentElement;
    let file = Array.from(input.files)[0];
    let preview = URL.createObjectURL(file);

    imagecard.innerHTML += `<img src="${preview}" alt="${file.name}">`;
    toUpload.push(file);
}

function createProductListing(form, toUpload) {
    let msgbox       = document.createElement('div');
    let overlay      = new DocOverlay();
    let productName  = form['product-name'].value;
    let category     = form['category'].value;
    let price        = form['price'].value;
    let freeshipping = form['freeshipping'].value;
    let details      = Array.from(form.querySelectorAll('input[name="details[]"]'));

    if (validateinput(productName.value, price.value, details) == false) {
        return;
    }

    let productData  = new productFormData(
        null,
        productName,
        category,
        price,
        freeshipping,
        details,
        toUpload
    );

    productData.createProductData('include/create_product.inc.php');

    msgbox.className = 'msg-box';
    msgbox.innerHTML = `
    <i class="close-box material-icons">&#xe5cd;</i>

    <div class="msg-box-content">
        <h3>Hurray!</h3>

        <p>You have made a new Product Listing for: 
        <strong>"${productName}"</strong>.</p>

        <span>You can now view your product on the main page, 
        and review your email <a href="#">'fakeemail@domain.com</a> 
        for further details.</span>
    </div>
    <div class="msg-box-bottom"></div>`;

    overlay.showOverlay(msgbox);
    overlay.autoHideOverlay(10000);

    resetControlPanel();
}


// Event: Create Product Listing
let toUpload = [];
let itemListingForm = 
document.querySelector('form[name="itemListingForm"]')
.addEventListener('submit', e => {
    e.preventDefault();
    createProductListing(e.target, toUpload);
});


// Event: Show Add More Detail Button
let showAddDetailsBTN = document.querySelector('form input[name="details[]"]')
.addEventListener('input', e => showAddDetailsBtn(e.target));


// Event: Add Details Button Click Event
let addDetailsField = document.querySelector('.add-details')
.addEventListener('click', addDetailsBTN);

// Event: Product Image Preview
let fileInput = document.querySelectorAll('.product-image')
.forEach(productImage => {
    productImage.addEventListener('change', e => showImagePreview(e.target));
});





function uniqueKey(limit) {
    let key = 'ADISON-';
    let chars = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, '!', '@', '#', '$', '%', '+', '*', '?', '&'];

    for(let i = 0; i < limit; i++) {
        let rand = parseInt((Math.random() * (chars.length - 1)).toFixed());
        key += chars[rand];
    }
    return key;
}

function bookmarkPromise(form) {
    return new Promise((resolve, reject) => {
        if (form !== null) { resolve(form); }
        else { reject('Not found!'); }
    });
}

function fetchBookmarks() {
    return !localStorage.getItem('Bookmarks') ? [] : 
    JSON.parse(localStorage.getItem('Bookmarks'));
}

function loadBookmarks() {
    let bookmarks = fetchBookmarks();
    let container = document.querySelector('.bookmarks-wrapper');
    
    container.innerHTML = '';

    bookmarks.forEach(bookmark => {
        container.innerHTML += `
        <div class="bookmark">
            <p>${bookmark.name}</p>
            <a id="url" href="${bookmark.url}" target="_blank">Visit</a>
            <input type="hidden" value="${bookmark.id}">
            <button class="remove">Remove</button>
        </div>`;
    });
}

function createBookmark(form) {
    let bookmarks = fetchBookmarks();
    let name = form['name'].value;
    let url  = form['url'].value;

    if (url == '' || name == '') { return; }
    
    bookmarks.push({ id: uniqueKey(10), name: name, url: url });
    localStorage.setItem('Bookmarks', JSON.stringify(bookmarks));
    form.reset();
}

function removeBookmark(id, callback) {
    let bookmarks = fetchBookmarks().filter(bookmark => bookmark.id !== id);

    localStorage.setItem('Bookmarks', JSON.stringify(bookmarks));
    callback();
}


// document.addEventListener('DOMContentLoaded', loadBookmarks);

// let form = document.querySelector('#bookmarksForm')
// .addEventListener('submit', e => {
//     e.preventDefault();
//     bookmarkPromise(e.target)
//     .then(createBookmark)
//     .then(loadBookmarks)
//     .catch(err => console.log(err));
// });

// let bookmarks = document.querySelector('.bookmarks-wrapper')
// .addEventListener('click', e => {
//     if (e.target.classList.contains('remove')) {
//         let id = e.target.parentElement.querySelector('input[type="hidden"]').value;
        
//         removeBookmark(id, loadBookmarks);
//     }
// });