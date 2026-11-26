import { configModal, openModal, closeModal, onModalClose } from "./modal.js";

const $formLogin = document.querySelector('.form--login');
const $formRegister = document.querySelector('.form--register');
const $authStatus = document.querySelector('.form__status');

export const initAuth = () => {
    document.addEventListener('click', async e => {
        const $loginButton = e.target.closest('.header__button--login');
        const $registerButton = e.target.closest('.form__link');
        const $logoutButton = e.target.closest('.dropdown__button--logout');

        const showForm = () => {
            const isLogin = !!$loginButton;

            configModal(isLogin ? 'Iniciar sesión' : 'Registrarse');
            $formLogin.classList.toggle('active', isLogin);
            $formRegister.classList.toggle('active', !isLogin);
        };

        if ($loginButton) {
            showForm();
            openModal();
        }

        if ($registerButton) {
            showForm();
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

    document.addEventListener('submit', async e => {
        let data;
        let action;

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
            closeModal();
            location.reload();
        } catch (err) {
            console.error(err.response
                ? `${err.response.statusText}\n${err.response.data.error}`
                : err
            );
            if ($authStatus) $authStatus.textContent = err.response?.data?.error;
        }
    });

    onModalClose(() => {
        $formLogin?.reset();
        $formRegister?.reset();
        if ($authStatus) $authStatus.textContent = '';
    });
};
