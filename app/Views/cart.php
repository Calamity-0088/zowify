<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/570a648c4a.js" crossorigin="anonymous"></script>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <title>Zowify | Mi Carrito</title>
</head>

<body>
    <?php require_once('includes/header.php'); ?>

    <main class="main main--cart">
        <div class="cart">
            <h1 class="cart__title">Carrito</h1>
            <div class="cart__content"></div>
        </div>
        <div class="summary">
            <h1 class="summary__title">Resumen de la orden</h1>
            <div class="summary__content">
                <div class="summary__resume">
                    <div class="summary__products">
                        <span class="summary__text">Productos:</span>
                        <span class="summary__value"></span>
                    </div>
                    <div class="summary__discount">
                        <span class="summary__text">Descuento:</span>
                        <span class="summary__value"></span>
                    </div>
                    <div class="summary__total">
                        <span class="summary__text">Total:</span>
                        <span class="summary__value"></span>
                    </div>
                    <button class="summary__buy" type="button">Continuar compra</button>
                </div>

            </div>
        </div>
    </main>

    <?php require_once('includes/payment_modal.php'); ?>

    <template class="template">
        <div class="cart__product">
            <div class="cart__info">
                <div class="cart__image">
                    <img class="cart__img" src="" alt="">
                </div>
                <div class="cart__name"></div>
            </div>
            <div class="cart__details">
                <div class="cart__price"></div>
                <div class="cart__quantity"></div>
                <div class="cart__group">
                    <button class="cart__button cart__button--decrease">
                        <i class="fa-solid fa-minus"></i>
                    </button>
                    <button class="cart__button cart__button--remove" type="button">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                    <button class="cart__button cart__button--increase">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </template>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.13.2/dist/axios.min.js"></script>
    <script type="module" src="js/main.js"></script>
    <script src="js/cart.js"></script>
    <script src="js/payment.js"></script>
</body>

</html>