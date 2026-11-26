import { openModal, configModal, closeModal, onModalClose } from "./modules/modal.js";

const $form = document.querySelector('.form');
const $preview = document.querySelector('.modal__image');
const $fileName = document.querySelector('.form__label--file');
const $productTable = document.querySelector('.products'),
    $tableBody = document.querySelector('.products__body'),
    $submitButton = document.querySelector('.form__submit'),
    $attachment = document.querySelector('.form__file'),
    $template = document.querySelector('.template').content;

const getAll = async () => {
    const $fragment = document.createDocumentFragment(),
        params = new URLSearchParams(window.location.search),
        search = params.get('q');
    let json;

    try {
        const response = await axios.get(`/Api/Product/index`, { params: { name: search ?? undefined } });
        json = response.data.data;
    } catch (err) {
        console.error(err.response
            ? `${err.response.statusText}\n${err.response.data.error}`
            : err
        );
        return;
    }

    $tableBody.replaceChildren();

    json.forEach(product => {
        const $clone = document.importNode($template, true);

        $clone.querySelector('.products__id').textContent = product.id;
        $clone.querySelector('.products__title').textContent = product.title;
        $clone.querySelector('.products__description').textContent = product.description;
        $clone.querySelector('.products__price').textContent = 'S/. ' + product.price;
        $clone.querySelector('.products__stock').textContent = product.stock;
        $clone.querySelector('.products__category').textContent = product.category_id;
        $clone.querySelector('.products__row').dataset.id = product.id;
        $clone.querySelector('.products__row').dataset.title = product.title;
        $clone.querySelector('.products__row').dataset.description = product.description;
        $clone.querySelector('.products__row').dataset.price = product.price;
        $clone.querySelector('.products__row').dataset.discount = product.discount;
        $clone.querySelector('.products__row').dataset.discount_type = product.discount_type;
        $clone.querySelector('.products__row').dataset.stock = product.stock;
        $clone.querySelector('.products__row').dataset.category_id = product.category_id;
        $clone.querySelector('.products__row').dataset.image = product.image;
        $fragment.appendChild($clone);
    });
    $tableBody.appendChild($fragment);
}

document.addEventListener('DOMContentLoaded', getAll);

document.addEventListener('submit', async e => {
    const formData = new FormData(e.target),
        hasImages = e.target.image.files.length > 0,
        id = e.target.id.value;
    let message;

    if (e.target === $form) e.preventDefault();
    if (!hasImages) formData.delete('image');

    try {
        if (!id) {
            await axios.post('/Api/Product/store', formData);
            message = 'Producto agregado correctamente';
        } else {
            await axios.post(`/Api/Product/update/${id}`, formData);
            message = 'Producto actualizado correctamente';
        }

        closeModal();
        getAll();
        setTimeout(() => alert(message), 100);
    } catch (err) {
        console.error(err.response
            ? `${err.response.statusText}\n${err.response.data.error}`
            : err
        );
    }
});

document.addEventListener('click', async e => {
    const $searchButton = e.target.closest('.inventory__button--search'),
        $addButton = e.target.closest('.inventory__button--add'),
        $editButton = e.target.closest('.products__button--edit'),
        $deleteButton = e.target.closest('.products__button--delete');

    if ($searchButton) {
        const searchValue = document.querySelector('.inventory__input').value;
        window.location.href = `/admin?q=${searchValue}`;
    }

    if ($addButton) {
        configModal('Agregar producto');
        openModal();
    }

    if ($editButton) {
        const rowData = $editButton.closest('.products__row').dataset;

        configModal('Actualizar producto');
        $preview.src = `images/${rowData.image}`;
        $form.id.value = rowData.id;
        $form.title.value = rowData.title;
        $form.description.value = rowData.description;
        $form.price.value = rowData.price;
        $form.discount.value = rowData.discount;
        $form.discount_type.value = rowData.discount_type;
        $form.stock.value = rowData.stock;
        $form.category_id.value = rowData.category_id;
        openModal();
    }

    if ($deleteButton) {
        const id = e.target.closest('.products__row').dataset.id,
            isDelete = confirm('¿Seguro que desea eliminar este producto?');

        if (isDelete) {
            try {
                await axios.delete(`/Api/Product/destroy/${id}`);
                getAll();

            } catch (err) {
                console.error(err.response
                    ? `${err.response.statusText}\n${err.response.data.error}`
                    : err
                );
            }
        }
    }
});

$attachment.addEventListener('change', () => {
    if ($attachment.files.length == 0) {
        $fileName.innerHTML = 'Ningún archivo seleccionado!';
    } else if ($attachment.files.length > 1) {
        $fileName.innerHTML = $attachment.files.length + ' archivos seleccionados.';
    } else {
        $fileName.innerHTML = $attachment.files[0].name;
        $preview.src = URL.createObjectURL($attachment.files[0]);
    }
});

onModalClose(() => {
    $form?.reset();
    if ($preview) $preview.src = '';
    if ($fileName) $fileName.textContent = 'Ningún archivo seleccionado.';
});