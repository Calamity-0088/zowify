const $userName = d.querySelector('.profile__name .profile__value'),
    $userAddress = d.querySelector('.profile__address .profile__value'),
    $userEmail = d.querySelector('.profile__email .profile__value'),
    $userPassword = d.querySelector('.profile__password .profile__value'),
    $userCreated = d.querySelector('.profile__created .profile__value'),
    $userUpdated = d.querySelector('.profile__updated .profile__value'),
    $editButton = d.querySelector('.profile__button');
let user;

const getUser = async () => {
    try {
        const response = await axios.get('/workspace_php/zowify/public/Api/User/showById');
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

d.addEventListener('DOMContentLoaded', getUser);

d.addEventListener('click', e => {
    const $editButton = e.target.closest('.profile__button');

    if ($editButton) {
        $form.name.value = user.first_name;
        $form.lastname.value = user.last_name;
        $form.address.value = user.address;
        $form.email.value = user.email;
        $modal.showModal();
    }
});

d.addEventListener('submit', async e => {
    e.preventDefault();
    const $form = e.target;
    const data = {
        first_name: $form.name.value,
        last_name: $form.lastname.value,
        address: $form.address.value,
        email: $form.email.value,
    }

    try {
        await axios.post('/workspace_php/zowify/public/Api/User/update', data);
        getUser();
        $modal.close();
    } catch (err) {
        console.error(err.response
            ? `${err.response.statusText}\n${err.response.data.error}`
            : err
        );
    }
});