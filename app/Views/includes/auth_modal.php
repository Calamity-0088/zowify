<dialog class="modal modal--auth">
    <div class="modal__container">
        <div class="modal__header">
            <h2 class="modal__title">Iniciar sesión</h2>
            <button class="modal__close" type="button">
                <i class="modal__icon fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="modal__body">
            <form class="form form--login">
                <div class="form__item">
                    <label class="form__label">Correo electrónico:</label>
                    <input class="form__input" type="text" name="email" required>
                </div>
                <div class="form__item">
                    <label class="form__label">Contraseña:</label>
                    <input class="form__input" type="password" name="password" required>
                </div>
                <button class="form__submit" type="submit">Iniciar sesión</button>
                <div class="form__signup">
                    <p>¿Necesitas una cuenta? <button class="form__link" type="button">Registrarse</button></p>
                </div>
                <p class="form__status"></p>
            </form>

            <form class="form form--register">
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
                    <input class="form__input" type="text" name="address" required>
                </div>
                <div class="form__item">
                    <label class="form__label">Correo electrónico:</label>
                    <input class="form__input" type="email" name="email" required>
                </div>
                <div class="form__item">
                    <label class="form__label">Contraseña:</label>
                    <input class="form__input" type="password" name="password" required>
                </div>
                <button class="form__submit" type="submit">Registrarse</button>
                <p class="form__status"></p>
            </form>
        </div>
    </div>
</dialog>