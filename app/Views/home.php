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
    <title>Zowify</title>
</head>

<body>
    <?php require_once('includes/header.php'); ?>
    <div class="app">
        <div class="layout">
            <main class="main main--home">

            </main>
            <?php require_once('includes/footer.php'); ?>
        </div>
    </div>

    <template class="template">
        <div class="card">
            <a href="" class="card__main">
                <div class="card__image">
                    <img class="card__img" src="" alt="">
                </div>
                <div class="card__title">
                    <span class="card__text"></span>
                </div>
                <div class="card__price">
                    <div class="card__final"></div>
                    <div class="card__discount"></div>
                </div>
                <div class="card__total"></div>
            </a>
            <div class="card__buttons">
                <button class="card__cart card__cart--decrease">
                    <i class="fa-solid fa-minus"></i>
                </button>
                <button class="card__cart card__cart--add" type="button">Agregar</button>
                <button class="card__cart card__cart--increase">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
        </div>
    </template>

    <script src="https://cdn.jsdelivr.net/npm/axios@1.13.2/dist/axios.min.js"></script>
    <script type="module" src="/js/main.js"></script>
    <script type="module" src="/js/home.js"></script>
</body>

</html>