class productFormData {
    constructor(
        productId = null, 
        productName, 
        category, 
        price, 
        freeshipping,
        details,
        toUpload = null,
        toDelete = null
    ) {
        this.productData  = new FormData();
        this.productId    = productId;
        this.productName  = productName;
        this.category     = category;
        this.price        = price;
        this.freeshipping = freeshipping;
        this.details      = details;
        this.toUpload     = toUpload;
        this.toDelete     = toDelete;
    }

    createProductData(path) {
        this.details = this.details.map(detail => detail.value).join(';');

        this.productData.set('asyncrequest', true);
        this.productData.set('productId',    this.productId);
        this.productData.set('product-name', this.productName);
        this.productData.set('category',     this.category);
        this.productData.set('price',        this.price);
        this.productData.set('freeshipping', this.freeshipping);
        this.productData.set('details',      this.details);

        if (this.toUpload !== null && this.toUpload.length > 0) {
            this.toUpload.forEach(image => {
                this.productData.append('imagesToUpload[]', image, image.name);
            });
        }
    
        if (this.toDelete !== null && this.toDelete.length > 0) {
            this.toDelete.forEach(imageId => {
                this.productData.append('imagesToDelete[]', imageId);
            });
        }

        this.submitProductData(path);
    }

    submitProductData(path) {
        fetch(path, {
            method: 'POST',
            body: this.productData
        })
        .then(res => res.text())
        .then(value => console.log(value))
        .catch(err => console.log('Fetch Error: ', err));
    }
}