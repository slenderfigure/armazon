function getUserLogin() {
    let userLogin;

    document.cookie.split(';').forEach(cookie => {
        if (cookie.indexOf('userlogin') != -1) {
            cookie = cookie.replace('userlogin=', '').trim();
            userLogin = cookie;
        }
    });
    return userLogin;
}

function sellerEnrollment(form) {
    let shopname    = form['shopname'].value;
    let productType = form['typeofproduct'].value;
    let agreement   = form['agreement'];
    
    if ((shopname || productType) == '' || !agreement.checked) {
        return;
    }

    let sellerDetails = {
        userlogin: getUserLogin(),
        shopname: shopname,
        product_type: productType
    }

    let xhl = ServerRequest.XHLRequest(
        'include/sellerprogram.inc.php',
        `asyncrequest=true&sellerDetails=${JSON.stringify(sellerDetails)}`
    );

    xhl.onload = function() {
        if (this.status == 200) {
            console.log(this.responseText);
        }
    }
    setTimeout(() => location.href = 'userpage.php', 1000);
}

let sellerForm = document.querySelector('form[name="sellerForm"]')
.addEventListener('submit', e => {
    e.preventDefault();
    sellerEnrollment(e.target);
});