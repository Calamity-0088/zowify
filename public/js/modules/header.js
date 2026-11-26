const $dropdown = document.querySelector(".dropdown");

export const initHeader = () => {
    document.addEventListener('click', e => {
        const $searchButton = e.target.closest('.header__submit');
        const $menuButton = e.target.closest('.header__button--menu');

        if ($searchButton) {
            const query = document.querySelector('.header__input').value.trim();
            if (query) window.location.href = `/search?q=${query}`;
        }

        if ($menuButton) {
            $dropdown?.classList.toggle('active');
        } else {
            $dropdown?.classList.remove('active');
        }
    });
};