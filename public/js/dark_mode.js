const btnDark = document.querySelector('#btnDark');

    btnDark.addEventListenter('click', () => {
        document.body.classList.toggle('c-dark-theme');
    });