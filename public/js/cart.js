const $cartContainer = d.querySelector('.cart__content'),
    $summaryProducts = d.querySelector('.summary__products'),
    $summaryDiscount = d.querySelector('.summary__discount'),
    $summaryTotal = d.querySelector('.summary__total'),
    $template = d.querySelector('.template').content;

const getAll = async () => {
    const $fragment = d.createDocumentFragment();
    let cartJson, totals;

    try {
        const response = await axios.get('/Api/Cart/index');
        cartJson = response.data.data;
        totals = response.data.totals;
        console.log(response);
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
        $clone.querySelector('.cart__price').innerHTML = `<strong>${formatPrice(product.final_price)}</strong>`;
        $clone.querySelector('.cart__quantity').textContent = `Cantidad: ${product.quantity}`;
        $fragment.appendChild($clone);
    });

    $cartContainer.appendChild($fragment);

    $summaryProducts.querySelector('.summary__text').textContent = `Productos (${totals.total_quantity})`;
    $summaryProducts.querySelector('.summary__value').textContent = `${formatPrice(totals.total_base)}`;
    $summaryDiscount.querySelector('.summary__value').textContent = `${formatPrice(totals.total_discount)}`;
    $summaryTotal.querySelector('.summary__value').textContent = `${formatPrice(totals.subtotal)}`;

}

const formatPrice = (price) => {
    return new Intl.NumberFormat('es-PE', {
        style: 'currency',
        currency: 'PEN'
    }).format(price);
}

d.addEventListener("DOMContentLoaded", getAll);

d.addEventListener("click", async e => {
    const $removeButton = e.target.closest('.cart__button--remove'),
        $increaseButton = e.target.closest('.cart__button--increase'),
        $decreaseButton = e.target.closest('.cart__button--decrease'),
        $product = e.target.closest('.cart__product'),
        $itemButtons = e.target.closest('.cart__group'),
        $paymentButton = e.target.closest('.summary__buy');

    if ($paymentButton) {
        renderCardPaymentBrick(bricksBuilder);
        $modal.showModal();
    }

    if (!$product || !$itemButtons) return;

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