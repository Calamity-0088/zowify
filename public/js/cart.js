const $cartContainer = d.querySelector('.cart__content'),
    $summaryProducts = d.querySelector('.summary__products'),
    $summaryDiscount = d.querySelector('.summary__discount'),
    $summaryTotal = d.querySelector('.summary__total'),
    $template = d.querySelector('.template').content;

const getAll = async () => {
    const $fragment = d.createDocumentFragment();
    let cartJson, summary;

    try {
        const cartResponse = await axios.get('/Api/Cart/index');
        const summaryResponse = await axios.get('/Api/Order/store');
        cartJson = cartResponse.data.data;
        summary = summaryResponse.data.data;
    } catch (err) {
        console.error(err.response
            ? `${err.response.statusText}\n${err.response.data.error}`
            : err
        );
        return;
    }

    $cartContainer.replaceChildren();

    cartJson.forEach(product => {
        const $clone = d.importNode($template, true);
        $clone.querySelector('.cart__product').dataset.id = product.id;
        $clone.querySelector('.cart__img').src = `images/${product.image}`;
        $clone.querySelector('.cart__name').textContent = product.title;
        $clone.querySelector('.cart__price').innerHTML = `<strong>S/ ${product.price}</strong>`;
        $clone.querySelector('.cart__quantity').textContent = `Cantidad: ${product.quantity}`;
        $fragment.appendChild($clone);
    });

    $cartContainer.appendChild($fragment);

    $summaryProducts.querySelector('.summary__text').textContent = `Productos (${summary.total_products})`;
    $summaryProducts.querySelector('.summary__value').textContent = `S/ ${summary.total}`;
    $summaryDiscount.querySelector('.summary__value').textContent = `S/ ${summary.discount}`;
    $summaryTotal.querySelector('.summary__value').textContent = `S/ ${summary.final_price}`;
}

d.addEventListener("DOMContentLoaded", getAll);

d.addEventListener("click", async e => {
    const $removeButton = e.target.closest('.cart__button--remove'),
        $increaseButton = e.target.closest('.cart__button--increase'),
        $decreaseButton = e.target.closest('.cart__button--decrease'),
        $product = e.target.closest('.cart__product'),
        $paymentButton = e.target.closest('.summary__buy');

    if ($paymentButton) {
        renderCardPaymentBrick(bricksBuilder);
        $modal.showModal();
    }

    //* Verifica si el elemento clickeado no es un producto
    if (!$product) return;

    const id = $product.dataset.id;
    let quantity;

    try {
        const response = await axios.get(`/Api/Cart/show/${id}`);
        quantity = response.data?.data?.quantity;

        if ($removeButton) {
            await axios.delete(`/Api/Cart/destroy/${id}`);
            return getAll();
        }

        $increaseButton ? quantity++ : quantity--;
        await axios.post(`/Api/Cart/update/${id}`, { quantity: quantity });
        getAll();
    } catch (err) {
        console.error(err.response
            ? `${err.response.statusText}\n${err.response.data.error}`
            : err
        );
    }
});