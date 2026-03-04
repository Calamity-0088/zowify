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
    <title>Zowify | Perfil</title>
</head>

<body>
    <?php require_once('includes/header.php'); ?>
    <main class="main main--profile">
        <h1 class="main__title">Perfil de Usuario</h1>
        <div class="profile">
            <div class="profile__field profile__name">
                <div class="profile__icon">
                    <i class="fa-regular fa-user"></i>
                </div>
                <div class="profile__text">
                    <span class="profile__title"><strong>Nombre</strong></span>
                    <span class="profile__value"></span>
                </div>
            </div>
            <div class="profile__field profile__address">
                <div class="profile__icon">
                    <i class="fa-regular fa-house"></i>
                </div>
                <div class="profile__text">
                    <span class="profile__title"><strong>Dirección</strong></span>
                    <span class="profile__value"></span>
                </div>
            </div>
            <div class="profile__field profile__email">
                <div class="profile__icon">
                    <i class="fa-regular fa-envelope"></i>
                </div>
                <div class="profile__text">
                    <span class="profile__title"><strong>Email</strong></span>
                    <span class="profile__value"></span>
                </div>
            </div>
            <div class="profile__field profile__password">
                <div class="profile__icon">
                    <i class="fa-solid fa-key"></i>
                </div>
                <div class="profile__text">
                    <span class="profile__title"><strong>Contraseña</strong></span>
                    <span class="profile__value"></span>
                </div>
            </div>
            <div class="profile__field profile__created">
                <div class="profile__icon">
                    <i class="fa-solid fa-file-circle-plus"></i>
                </div>
                <div class="profile__text">
                    <span class="profile__title"><strong>Creado</strong></span>
                    <span class="profile__value"></span>
                </div>
            </div>
            <div class="profile__field profile__updated">
                <div class="profile__icon">
                    <i class="fa-solid fa-file-pen"></i>
                </div>
                <div class="profile__text">
                    <span class="profile__title"><strong>Actualizado</strong></span>
                    <span class="profile__value"></span>
                </div>
            </div>
            <button class="profile__button" type="button">Editar Perfil</button>
        </div>
    </main>
    <?php require_once('includes/profile_modal.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/axios@1.13.2/dist/axios.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/profile.js"></script>
</body>

</html>