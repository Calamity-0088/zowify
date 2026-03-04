const $main = d.querySelector('.main'),
    $template = d.querySelector('.template').content;

const getAll = async () => {
    const $fragment = d.createDocumentFragment(),
        params = new URLSearchParams(window.location.search),
        category = params.get('category');
    let response, json;

    try {
        if (category) {
            response = await axios.get(category === 'offers'
                ? '/workspace_php/zowify/public/Api/Product/indexOffers'
                : `/workspace_php/zowify/public/Api/Product/showCategory/${category}`
            );
        } else {
            response = await axios.get('/workspace_php/zowify/public/Api/Product/index');
        }

        json = response.data.data;
    } catch (err) {
        console.error(err.response
            ? `${err.response.statusText}\n${err.response.data.error}`
            : err
        );
        return;
    }

    $main.replaceChildren();

    json.forEach(product => {
        const $clone = d.importNode($template, true);

        $clone.querySelector('.card').dataset.id = product.id;
        $clone.querySelector('.card__main').href = `/workspace_php/zowify/public/product?id=${product.id}`;
        $clone.querySelector('.card__img').src = `images/${product.image}`;
        $clone.querySelector('.card__text').textContent = product.title;
        $clone.querySelector('.card__discount').textContent = `-${product.discount}%`
        $clone.querySelector('.card__total').innerHTML = `<s>S/ ${product.price}</s>`;
        const discount = (product.price * product.discount) / 100;
        $clone.querySelector('.card__final').textContent = `S/ ${(product.price - discount).toFixed(2)}`;
        $fragment.appendChild($clone);
    });
    $main.appendChild($fragment);
}

d.addEventListener('DOMContentLoaded', getAll);

d.addEventListener('click', async e => {
    const $addToCartButton = e.target.closest('.card__cart--add'),
        $increaseButton = e.target.closest('.card__cart--increase'),
        $decreaseButton = e.target.closest('.card__cart--decrease'),
        $product = e.target.closest('.card');

    if (!$product) return;
    const id = $product.dataset.id;

    try {
        if ($addToCartButton) {
            const data = {
                id,
                quantity: 1
            }
            await axios.post('/workspace_php/zowify/public/Api/Cart/store', data);
            alert('Producto añadido al carrito.')
        }

        if ($increaseButton || $decreaseButton) {
            const response = await axios.get(`/workspace_php/zowify/public/Api/Cart/show/${id}`);
            let quantity = response.data?.data?.quantity;

            if (!quantity) return;

            $increaseButton ? quantity++ : quantity--;

            await axios.post(`/workspace_php/zowify/public/Api/Cart/update/${id}`, { quantity });
            getAll();
        }
    } catch (err) {
        console.error(err.response
            ? `${err.response.statusText}\n${err.response.data.error}`
            : err
        );
    }
});