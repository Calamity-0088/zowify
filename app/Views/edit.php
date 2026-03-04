<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/570a648c4a.js" crossorigin="anonymous"></script>
    <title>Zowify | Administrar productos</title>
</head>

<body>
    <main class="main main--edit">
        <article class="inventory">
            <div class="inventory__title">
                <ul class="inventory__list">
                    <li class="inventory__item">
                        <h2 class="inventory__text">Lista de productos</h2>
                    </li>
                    <li class="inventory__item">
                        <input class="inventory__input" type="text" name="query" placeholder="Buscar producto">
                        <button class="inventory__button inventory__button--search" type="submit">
                            <i class="header__icon header__icon--search fa-solid fa-magnifying-glass"></i>
                        </button>
                    </li>
                    <li class="inventory__item">
                        <button class="inventory__button inventory__button--add" type="button">Agregar producto</button>
                    </li>
                </ul>

            </div>
            <div class="inventory__content">
                <table class="products">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Categoría</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="products__body"></tbody>
                </table>
            </div>
        </article>
    </main>
    <?php require_once('includes/edit_modal.php') ?>
    <template class="template">
        <tr class="products__row">
            <td class="products__id"></td>
            <td class="products__title"></td>
            <td class="products__description"></td>
            <td class="products__price"></td>
            <td class="products__stock"></td>
            <td class="products__category"></td>
            <td class="products__actions">
                <button class="products__button products__button--edit" type="button">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
                <button class="products__button products__button--delete" type="button">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </td>
        </tr>
    </template>

    <script src="https://cdn.jsdelivr.net/npm/axios@1.13.2/dist/axios.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/admin_products.js"></script>
</body>

</html>