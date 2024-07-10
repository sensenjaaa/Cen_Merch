function search() {
    const searchInput = document.getElementById('search-item').value.toLowerCase();
    const products = document.querySelectorAll('.products');
    const productSections = document.querySelectorAll('.productsec');

    productSections.forEach(section => {
        section.style.display = 'none';
    });

    products.forEach(product => {
        const productName = product.querySelector('.productname').innerText.toLowerCase();
        if (productName.includes(searchInput)) {
            product.style.display = 'block';
            
            const section = product.closest('.listofproducts').previousElementSibling;
            section.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
}
