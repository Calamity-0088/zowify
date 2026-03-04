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
    <title>Zowify | Mis Pedidos</title>
</head>

<body>
    <?php require_once('includes/header.php'); ?>
    <main class="main main--order"></main>
    <?php require_once('includes/footer.php'); ?>

    <template class="template">
        <div class="order">
            <a href="" class="order__main">
                <div class="order__header">
                    <h2 class="order__title"></h2>
                    <span class="order__total"></span>
                </div>
                <div class="order__body">
                    <div class="order__payment">
                        <span class="order__label">Estado del pago:</span>
                        <span class="order__value"></span>
                    </div>
                    <div class="order__shipping">
                        <span class="order__label">Estado del envio:</span>
                        <span class="order__value"></span>
                    </div>
                </div>
            </a>
        </div>
    </template>

    <script src="https://cdn.jsdelivr.net/npm/axios@1.13.2/dist/axios.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/order.js"></script>
</body>

</html>