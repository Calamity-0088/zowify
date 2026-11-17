const $main = d.querySelector('.main'),
    $template = d.querySelector('.template').content;

d.addEventListener('DOMContentLoaded', async () => {
    const params = new URLSearchParams(window.location.search),
        search = params.get('q'),
        $fragment = d.createDocumentFragment();
    let json;

    try {
        const url = search ? '/Api/Product/show' : '/Api/Product/index';
        const response = await axios.get(url, search ? { params: { search } } : {});
        json = response.data.data;
    } catch (err) {
        console.error(err.response
            ? `${err.response.statusText}\n${err.response.data.error}`
            : err
        );
        return;
    }

    json.forEach(product => {
        const $clone = d.importNode($template, true);
        const discount = (product.price * product.discount) / 100,
            finalPrice = (product.price - discount).toFixed(2);

        $clone.querySelector('.card').dataset.id = product.id;
        $clone.querySelector('.card__main').href = `/product?id=${product.id}`;
        $clone.querySelector('.card__img').src = `images/${product.image}`;
        $clone.querySelector('.card__text').textContent = product.title;
        $clone.querySelector('.card__discount').textContent = `-${product.discount}%`
        $clone.querySelector('.card__total').innerHTML = `<s>S/ ${product.price}</s>`;
        $clone.querySelector('.card__final').textContent = `S/ ${finalPrice}`;
        $fragment.appendChild($clone);
    });

    $main.appendChild($fragment);
});