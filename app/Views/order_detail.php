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
    <title>Zowify | Orden</title>
</head>

<body>
    <?php require_once('includes/header.php'); ?>
    <main class="main main--detail">
        <div class="detail">
            <div class="detail__header">
                <h2 class="detail__title"></h2>
            </div>
            <div class="detail__body">
                <h2 class="detail__label">Resumen</h2>
                <div class="detail__summary">
                    <div class="detail__payment">
                        <span class="detail__label">Estado del pago:</span>
                        <span class="detail__value"></span>
                    </div>
                    <div class="detail__shipping">
                        <span class="detail__label">Estado del envio:</span>
                        <span class="detail__value"></span>
                    </div>
                    <div class="detail__date">
                        <span class="detail__label">Fecha de pago:</span>
                        <span class="detail__value"></span>
                    </div>
                </div>
                <h2 class="detail__label">Lista de productos</h2>
                <div class="detail__items"></div>
                <div class="detail__total">
                    <span class="detail__label">Total a pagar:</span>
                    <span class="detail__value"></span>
                </div>
            </div>
        </div>
    </main>
    <?php require_once('includes/footer.php'); ?>

    <template class="template">
        <div class="detail__product">
            <div class="detail__name">
                <span class="detail__value"></span>
            </div>
            <div class="detail__price">
                <span class="detail__label"><strong>Precio</strong></span>
                <span class="detail__value"></span>
            </div>
            <div class="detail__quantity">
                <span class="detail__label"><strong>Cantidad</strong></span>
                <span class="detail__value"></span>
            </div>
        </div>
    </template>

    <script src="https://cdn.jsdelivr.net/npm/axios@1.13.2/dist/axios.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/order_detail.js"></script>
</body>

</html>