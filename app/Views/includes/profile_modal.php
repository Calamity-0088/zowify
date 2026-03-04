<dialog class="modal modal--profile">
    <div class="modal__container">
        <div class="modal__header">
            <h2 class="modal__title">Editar perfil</h2>
            <button class="modal__close" type="button">
                <i class="modal__icon fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="modal__body">
            <form class="form">
                <div class="form__item">
                    <label class="form__label">Nombres:</label>
                    <input class="form__input" type="text" name="name" required>
                </div>
                <div class="form__item">
                    <label class="form__label">Apellidos:</label>
                    <input class="form__input" type="text" name="lastname" required>
                </div>
                <div class="form__item">
                    <label class="form__label">Dirección:</label>
                    <input class="form__input" type="text" name="address">
                </div>
                <div class="form__item">
                    <label class="form__label">Correo electrónico:</label>
                    <input class="form__input" type="email" name="email" required>
                </div>
                <div class="form__item">
                    <label class="form__label">Contraseña:</label>
                    <input class="form__input" type="password" name="password">
                </div>
                <button class="form__submit" type="submit">Guardar cambios</button>
                <p class="form__status"></p>
            </form>
        </div>
    </div>
</dialog>