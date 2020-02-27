function dropdownHandler(button) {
    let dropdown = document.querySelector('.dropdown');

    dropdown.classList.toggle('dropdown-active');

    document.addEventListener('click', e => {
        if (!e.target.matches('.account-icon')) {
            dropdown.classList.remove('dropdown-active');
        }
    });
}

let dropdownBtn = document.querySelector('.account-icon')
.addEventListener('click', e => dropdownHandler(e.target));