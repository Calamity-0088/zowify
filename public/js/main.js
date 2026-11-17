const d = document,
    $dropdown = d.querySelector('.dropdown'),
    $modal = d.querySelector('.modal'),
    $modalTitle = d.querySelector('.modal__title'),
    $paymentBrick = d.querySelector('.modal__brick--payment'),
    $statusBrick = d.querySelector('.modal__brick--status'),
    $form = d.querySelector('.form'),
    $formLogin = d.querySelector('.form--login'),
    $formRegister = d.querySelector('.form--register'),
    $authStatus = d.querySelector('.form__status'),
    $preview = d.querySelector('.modal__image'),
    $fileName = d.querySelector('.form__label--file');

d.addEventListener('click', async e => {
    const $searchButton = e.target.closest('.header__submit'),
        $menuButton = e.target.closest('.header__button--menu'),
        $closeButton = e.target.closest('.modal__close'),
        $loginButton = e.target.closest('.header__button--login'),
        $registerButton = e.target.closest('.form__link'),
        $logoutButton = e.target.closest('.dropdown__button--logout');

    if (!$menuButton) {
        if ($dropdown) $dropdown.classList.remove('active');
    }

    if ($menuButton) {
        if ($dropdown) $dropdown.classList.toggle('active');
    }

    if ($searchButton) {
        const query = d.querySelector('.header__input').value;
        window.location.href = `/search?q=${query}`;
    }

    if ($closeButton) {
        $modal.close();
    }

    if ($loginButton) {
        $modalTitle.textContent = 'Iniciar sesión';
        $formLogin.classList.add('active');
        $formRegister.classList.remove('active');
        $modal.showModal();
    }

    if ($registerButton) {
        $modalTitle.textContent = 'Registrarse';
        $formRegister.classList.add('active');
        $formLogin.classList.remove('active');
    }

    if ($logoutButton) {
        try {
            await axios.post('/Api/Auth/logout');
            location.reload();
        } catch (err) {
            console.error(err.response
                ? `${err.response.statusText}\n${err.response.data.error}`
                : err
            );
        }
    }
});

d.addEventListener('submit', async e => {
    let data,
        action;

    if (e.target === $formLogin) {
        data = {
            email: e.target.email.value,
            password: e.target.password.value
        };
        action = 'login';
    } else if (e.target === $formRegister) {
        data = {
            first_name: e.target.name.value,
            last_name: e.target.lastname.value,
            address: e.target.address.value,
            email: e.target.email.value,
            password: e.target.password.value
        };
        action = 'register';
    } else {
        return;
    }

    e.preventDefault();

    try {
        await axios.post(`/Api/Auth/${action}`, data);
        $modal.close();
        location.reload();
    } catch (err) {
        console.error(err.response
            ? `${err.response.statusText}\n${err.response.data.error}`
            : err
        );
        $authStatus.textContent = err.response?.data?.error;
    }
});

$modal?.addEventListener('close', () => {
    if ($form) $form.reset();
    if ($preview) $preview.src = '';
    if ($fileName) $fileName.textContent = 'Ningún archivo seleccionado.';
    if (window.statusScreenBrickController) window.statusScreenBrickController.unmount();
});