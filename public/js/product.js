const $main = document.querySelector('.main');

const params = new URLSearchParams(window.location.search),
    id = params.get('id');

const getAll = async () => {
    let product,
        productCart;
    try {
        const response = await axios.get(`/Api/Product/show/${id}`);
        const responseCart = await axios.get(`/Api/Cart/show/${id}`);
        product = response.data.data;
        productCart = responseCart.data.data;
    } catch (err) {
        console.error(err.response
            ? `${err.response.statusText}\n${err.response.data.error}`
            : err
        );
        return;
    }

    document.title = `Zowify | ${product.title}`;
    document.querySelector('.product').dataset.id = product.id;
    document.querySelector('.product__info').href = `/product?id=${product.id}`;
    document.querySelector('.product__img').src = `images/${product.image}`;
    document.querySelector('.product__title').textContent = product.title;
    document.querySelector('.product__vendor').innerHTML = `Vendido por: <a href="#">Zowify</a>`;
    document.querySelector('.product__description').textContent = product.description;
    document.querySelector('.product__discount').textContent = `-${product.discount}%`
    document.querySelector('.product__total').innerHTML = `<s>S/ ${product.price}</s>`;
    const discount = (product.price * product.discount) / 100;
    document.querySelector('.product__final').textContent = `S/ ${(product.price - discount).toFixed(2)}`;
    document.querySelector('.product__code').textContent = `Código: ${product.id}`;
    document.querySelector('.product__quantity').value = productCart?.quantity || 0;

    configureCartButton(productCart?.quantity || 0);
}

const configureCartButton = ($quantity) => {
    const $addToCartButton = document.querySelector('.product__cart--add');

    if ($quantity > 0) {
        $addToCartButton.textContent = 'Eliminar producto';
        return 'delete';
    } else {
        $addToCartButton.textContent = ' Agregar al carrito';
        return 'add';
    }
}

document.addEventListener('DOMContentLoaded', getAll);

document.addEventListener('click', async e => {
    const $addToCartButton = e.target.closest('.product__cart--add'),
        $increaseButton = e.target.closest('.product__cart--increase'),
        $decreaseButton = e.target.closest('.product__cart--decrease');

    let $counter = document.querySelector('.product__quantity').value;
    let data;

    if (!$addToCartButton && !$increaseButton && !$decreaseButton || !id) return;

    try {
        if ($addToCartButton) {
            const response = await axios.get(`/Api/Cart/show/${id}`);
            const quantity = response?.data?.data?.quantity;
            const action = configureCartButton(quantity);

            if ($counter == 0) $counter = 1;

            data = {
                id,
                quantity: $counter
            };

            if (action == 'add') {
                await axios.post('/Api/Cart/store', data);
                alert('Producto agregado al carrito');
            } else if (action == 'delete') {
                await axios.delete(`/Api/Cart/destroy/${id}`);
                alert('Producto eliminado del carrito');
            }

            return getAll();
        }

        $increaseButton ? $counter++ : $counter--;
        document.querySelector('.product__quantity').value = $counter;

        //* Si el nombre de la clave coincide con el nombre del valor, no se necesita escribirla dos veces.
        await axios.post(`/Api/Cart/update/${id}`, { quantity: $counter });

        const response = await axios.get(`/Api/Cart/show/${id}`);
        const currentQuantity = response?.data?.data?.quantity;

        configureCartButton(currentQuantity);
    } catch (err) {
        console.error(err.response
            ? `${err.response.statusText}\n${err.response.data.error}`
            : err
        );
    }
});