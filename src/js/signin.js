function empty(inputs) {
    let empty = false;
    
    inputs.forEach(input => {
        if (input.value == '') { empty = true; }
    });
    return empty;
}

let signupForm = document.querySelector('form[name="signForm"]')
.addEventListener('submit', e => {
    e.preventDefault();
    let inputs = e.target.querySelectorAll('input');
    
    if (empty(inputs)) { return; }

    e.target.submit();
});