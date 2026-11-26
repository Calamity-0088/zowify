const $main = document.querySelector('.main'),
    $template = document.querySelector('.template').content;

const loadProducts = async () => {
    const params = new URLSearchParams(window.location.search),
        category = params.get('category');

    try {
        const products = await fetchProducts(category);
        renderProducts(products);
    } catch (err) {
        console.error(err.response
            ? `${err.response.statusText}\n${err.response.data.error}`
            : err
        );
    }
};

const fetchProducts = async (category) => {
    const response = await axios.get('/Api/Product/index', { params: { category: category ?? undefined } });
    return response.data.data;
};

const renderProducts = (products) => {
    const $fragment = document.createDocumentFragment();

    $main.replaceChildren();

    products.forEach(product => {
        const $clone = document.importNode($template, true);

        $clone.querySelector('.card').dataset.id = product.id;
        $clone.querySelector('.card__main').href = `/product?id=${product.id}`;
        $clone.querySelector('.card__img').src = `images/${product.image}`;
        $clone.querySelector('.card__text').textContent = product.title;
        $clone.querySelector('.card__discount').textContent = `-${product.discount}%`
        $clone.querySelector('.card__total').innerHTML = `<s>S/ ${product.price}</s>`;
        const discount = (product.price * product.discount) / 100;
        $clone.querySelector('.card__final').textContent = `S/ ${(product.price - discount).toFixed(2)}`;
        $fragment.appendChild($clone);
    });

    $main.appendChild($fragment);
};

const addToCart = async (productId) => {
    const response = await axios.post('/Api/Cart/store', {
        product_id: productId,
        quantity: 1,
    });
    return response.data.message;
};


const updateCounter = async (productId, action) => {
    return await axios.post(`/Api/Cart/update/${productId}`, { action });
};

document.addEventListener('DOMContentLoaded', loadProducts);

document.addEventListener('click', async e => {
    const $addToCartButton = e.target.closest('.card__cart--add'),
        $increaseButton = e.target.closest('.card__cart--increase'),
        $decreaseButton = e.target.closest('.card__cart--decrease'),
        $product = e.target.closest('.card');

    if (!$product) return;
    const productId = $product.dataset.id;

    try {
        if ($addToCartButton) {
            const message = await addToCart(productId);
            alert(message);
        }

        if ($increaseButton || $decreaseButton) {
            const action = $increaseButton ? 'increase' : 'decrease';
            await updateCounter(productId, action);
            loadProducts();
        }
    } catch (err) {
        console.error(err.response
            ? `${err.response.statusText}\n${err.response.data.error}`
            : err
        );
    }
});