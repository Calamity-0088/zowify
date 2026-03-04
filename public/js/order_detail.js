const $template = d.querySelector('.template').content,
    $items = d.querySelector('.detail__items');

const getAll = async () => {
    const id = new URLSearchParams(window.location.search).get('id'),
        $fragment = d.createDocumentFragment();

    let data,
        items;

    try {
        const response = await axios.get(`/workspace_php/zowify/public/Api/Order/show/${id}`);
        data = response.data.data;
        items = response.data.data.items;
    } catch (err) {
        console.error(err.response
            ? `${err.response.statusText}\n${err.response.data.error}`
            : err
        );
        return;
    }

    d.title = `Zowify | Detalle del pedido #${data.id}`;
    d.querySelector('.detail').dataset.id = data.id;
    d.querySelector('.detail__title').textContent = `Pedido #${data.id}`;
    d.querySelector('.detail__payment .detail__value').textContent = data.payment_status;
    d.querySelector('.detail__shipping .detail__value').textContent = data.shipping_status;
    d.querySelector('.detail__date .detail__value').textContent = data.created_at;
    d.querySelector('.detail__total .detail__value').textContent = `S/ ${data.total_price}`;

    items.forEach(item => {
        const $clone = d.importNode($template, true);
        $clone.querySelector('.detail__product .detail__value').dataset.id = item.id;
        $clone.querySelector('.detail__name .detail__value').textContent = item.name;
        $clone.querySelector('.detail__price .detail__value').textContent = `S/ ${item.price}`;
        $clone.querySelector('.detail__quantity .detail__value').textContent = item.quantity;
        $fragment.appendChild($clone);
    });

    $items.appendChild($fragment);
}

d.addEventListener('DOMContentLoaded', getAll);