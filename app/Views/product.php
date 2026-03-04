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
    <title></title>
</head>

<body>
    <?php require_once('includes/header.php'); ?>
    <div class="main main--product">
        <div class="product">
            <div class="product__image">
                <img class="product__img" src="" alt="">
            </div>
            <div class="product__info">
                <div class="product__top">
                    <h1 class="product__title"></h1>
                    <span class="product__vendor"></span>
                </div>
                <span class="product__description"></span>
                <div class="product__middle">
                    <div class="product__price">
                        <div class="product__final"></div>
                        <div class="product__discount"></div>
                    </div>
                    <div class="product__total"></div>
                </div>
                <div class="product__bottom">
                    <div class="product__buttons">
                        <div class="product__group">
                            <button class="product__cart product__cart--decrease">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                            <input class="product__quantity" type="text" name="quantity" value="1">
                            <button class="product__cart product__cart--increase">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                        <button class="product__cart product__cart--add" type="button">Agregar al carrito</button>
                    </div>
                    <span class="product__code"></span>
                </div>

            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/axios@1.13.2/dist/axios.min.js"></script>
        <script src="js/main.js"></script>
        <script src="js/product.js"></script>
</body>

</html>