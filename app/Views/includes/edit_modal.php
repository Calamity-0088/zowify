<dialog class="modal modal--admin">
    <div class="modal__container">
        <div class="modal__header">
            <h2 class="modal__title">Agregar producto</h2>
            <button class="modal__close" type="button">
                <i class="modal__icon fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="modal__body">
            <div class="modal__preview">
                <img class="modal__image" src="" alt="">
            </div>
            <form class="form" enctype="multipart/form-data">
                <div class="form__item">
                    <label class="form__label">ID:</label>
                    <input class="form__input" type="text" name="id" disabled>
                </div>
                <div class="form__item">
                    <label class="form__label">Nombre:</label>
                    <input class="form__input" type="text" name="title" value="">
                </div>
                <div class="form__item">
                    <label class="form__label">Descripción:</label>
                    <input class="form__input" type="text" name="description">
                </div>
                <div class="form__item">
                    <label class="form__label">Precio:</label>
                    <input class="form__input" type="text" name="price">
                </div>
                <div class="form__item">
                    <label class="form__label">Descuento:</label>
                    <input class="form__input" type="text" name="discount">
                </div>
                <div class="form__item">
                    <label class="form__label">Tipo de descuento:</label>
                    <input class="form__input" type="text" name="discount_type">
                </div>
                <div class="form__item">
                    <label class="form__label">Stock:</label>
                    <input class="form__input" type="text" name="stock" value="">
                </div>
                <div class="form__item">
                    <label class="form__label">Categoría:</label>
                    <input class="form__input" type="text" name="category_id">
                </div>
                <label class="form__item" for="form__file">
                    <span class="form__label form__label--file">Ningún archivo seleccionado.</span>
                    <button class="form__button form__button--file" type="button">Examinar...</button>
                </label>
                <input class="form__file" id="form__file" type="file" name="image" multiple hidden>
                <button class="form__submit" type="submit">Guardar cambios</button>
            </form>
        </div>
    </div>
</dialog>