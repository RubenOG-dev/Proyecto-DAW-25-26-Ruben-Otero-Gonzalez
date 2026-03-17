window.addEventListener('load', () => {
    const loader = document.getElementById('page-loader');
    
    if (loader) {
        loader.classList.add('loader-hidden');

        loader.addEventListener('transitionend', () => {
            if (document.body.contains(loader)) {
                document.body.removeChild(loader);
            }
        });
    }

    const myElement = document.querySelector('.alguna-clase');
    if (myElement) {
        myElement.classList.remove('active');
    }
});