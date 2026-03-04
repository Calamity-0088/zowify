const $main = d.querySelector('.main');

const params = new URLSearchParams(window.location.search),
    id = params.get('id');

const getAll = async () => {
    let product,
        productCart;
    try {
        const response = await axios.get(`/workspace_php/zowify/public/Api/Product/showId/${id}`);
        const responseCart = await axios.get(`/workspace_php/zowify/public/Api/Cart/show/${id}`);
        product = response.data.data;
        productCart = responseCart.data.data;
    } catch (err) {
        console.error(err.response
            ? `${err.response.statusText}\n${err.response.data.error}`
            : err
        );
        return;
    }

    d.title = `Zowify | ${product.title}`;
    d.querySelector('.product').dataset.id = product.id;
    d.querySelector('.product__info').href = `/workspace_php/zowify/public/product?id=${product.id}`;
    d.querySelector('.product__img').src = `images/${product.image}`;
    d.querySelector('.product__title').textContent = product.title;
    d.querySelector('.product__vendor').innerHTML = `Vendido por: <a href="#">Zowify</a>`;
    d.querySelector('.product__description').textContent = product.description;
    d.querySelector('.product__discount').textContent = `-${product.discount}%`
    d.querySelector('.product__total').innerHTML = `<s>S/ ${product.price}</s>`;
    const discount = (product.price * product.discount) / 100;
    d.querySelector('.product__final').textContent = `S/ ${(product.price - discount).toFixed(2)}`;
    d.querySelector('.product__code').textContent = `Código: ${product.id}`;
    d.querySelector('.product__quantity').value = productCart?.quantity || 0;

    configureCartButton(productCart?.quantity || 0);
}

const configureCartButton = ($quantity) => {
    const $addToCartButton = d.querySelector('.product__cart--add');

    if ($quantity > 0) {
        $addToCartButton.textContent = 'Eliminar producto';
        return 'delete';
    } else {
        $addToCartButton.textContent = ' Agregar al carrito';
        return 'add';
    }
}

d.addEventListener('DOMContentLoaded', getAll);

d.addEventListener('click', async e => {
    const $addToCartButton = e.target.closest('.product__cart--add'),
        $increaseButton = e.target.closest('.product__cart--increase'),
        $decreaseButton = e.target.closest('.product__cart--decrease');

    let $counter = d.querySelector('.product__quantity').value;
    let data;

    if (!$addToCartButton && !$increaseButton && !$decreaseButton || !id) return;

    try {
        if ($addToCartButton) {
            const response = await axios.get(`/workspace_php/zowify/public/Api/Cart/show/${id}`);
            const quantity = response?.data?.data?.quantity;
            const action = configureCartButton(quantity);

            if ($counter == 0) $counter = 1;

            data = {
                id,
                quantity: $counter
            };

            if (action == 'add') {
                await axios.post('/workspace_php/zowify/public/Api/Cart/store', data);
                alert('Producto agregado al carrito');
            } else if (action == 'delete') {
                await axios.delete(`/workspace_php/zowify/public/Api/Cart/destroy/${id}`);
                alert('Producto eliminado del carrito');
            }

            return getAll();
        }

        $increaseButton ? $counter++ : $counter--;
        d.querySelector('.product__quantity').value = $counter;

        //* Si el nombre de la clave coincide con el nombre del valor, no se necesita escribirla dos veces.
        await axios.post(`/workspace_php/zowify/public/Api/Cart/update/${id}`, { quantity: $counter });

        const response = await axios.get(`/workspace_php/zowify/public/Api/Cart/show/${id}`);
        const currentQuantity = response?.data?.data?.quantity;

        configureCartButton(currentQuantity);
    } catch (err) {
        console.error(err.response
            ? `${err.response.statusText}\n${err.response.data.error}`
            : err
        );
    }
});