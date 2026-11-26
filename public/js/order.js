const $template = document.querySelector('.template').content,
    $main = document.querySelector('.main');
let json;
const getOrder = async () => {
    const $fragment = document.createDocumentFragment();

    try {
        const response = await axios.get('/Api/Order/index');
        json = response.data.data;
    } catch (err) {
        console.error(err.response
            ? `${err.response.statusText}\n${err.response.data.error}`
            : err
        );
        return;
    }

    json.forEach(order => {
        const $clone = document.importNode($template, true);

        $clone.querySelector('.order').dataset.id = order.id;
        $clone.querySelector('.order__main').href = `/detail?id=${order.id}`;
        $clone.querySelector('.order__title').textContent = `Pedido #${order.id}`;
        $clone.querySelector('.order__payment .order__value').textContent = order.payment_status;
        $clone.querySelector('.order__shipping .order__value').textContent = order.shipping_status;
        $clone.querySelector('.order__total').textContent = `S/ ${order.total_price}`;
        $fragment.appendChild($clone);
    });
    $main.appendChild($fragment);
}

document.addEventListener('DOMContentLoaded', getOrder);