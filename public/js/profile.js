import { closeModal, openModal } from "./modules/modal.js";

const $form = document.querySelector('.form');
const $userName = document.querySelector('.profile__name .profile__value'),
    $userAddress = document.querySelector('.profile__address .profile__value'),
    $userEmail = document.querySelector('.profile__email .profile__value'),
    $userPassword = document.querySelector('.profile__password .profile__value'),
    $userCreated = document.querySelector('.profile__created .profile__value'),
    $userUpdated = document.querySelector('.profile__updated .profile__value'),
    $editButton = document.querySelector('.profile__button');
let user;

const getUser = async () => {
    try {
        const response = await axios.get('/Api/User/showById');
        user = response.data.data;
    } catch (err) {
        console.error(err.response
            ? `${err.response.statusText}\n${err.response.data.error}`
            : err
        );
        return;
    }

    $userName.textContent = user.first_name + ' ' + user.last_name;
    $userAddress.textContent = user.address;
    $userEmail.textContent = user.email;
    $userPassword.textContent = '********';
    $userCreated.textContent = user.created_at;
    $userUpdated.textContent = user.updated_at;
}

document.addEventListener('DOMContentLoaded', getUser);

document.addEventListener('click', e => {
    const $editButton = e.target.closest('.profile__button');

    if ($editButton) {
        $form.name.value = user.first_name;
        $form.lastname.value = user.last_name;
        $form.address.value = user.address;
        $form.email.value = user.email;
        openModal();
    }
});

document.addEventListener('submit', async e => {
    e.preventDefault();
    const $form = e.target;
    const data = {
        first_name: $form.name.value,
        last_name: $form.lastname.value,
        address: $form.address.value,
        email: $form.email.value,
    }

    try {
        await axios.post('/Api/User/update', data);
        getUser();
        closeModal();
    } catch (err) {
        console.error(err.response
            ? `${err.response.statusText}\n${err.response.data.error}`
            : err
        );
    }
});