const $modal = document.querySelector('.modal');
const $modalTitle = document.querySelector('.modal__title');

export const openModal = () => $modal?.showModal();

export const closeModal = () => $modal?.close();

export const configModal = title => $modalTitle.textContent = title;

export const onModalClose = handler => $modal?.addEventListener('close', handler);

export const initModal = () => {
    document.addEventListener('click', e => {
        const $closeButton = e.target.closest('.modal__close');

        if ($closeButton) {
            closeModal();
        }
    });
};