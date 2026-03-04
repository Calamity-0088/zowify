<header class="header">
    <div class="header__search">
        <ul class="header__ul">
            <li class="header__item">
                <a class="header__button header__button--logo" href="/workspace_php/zowify/public/home">
                    <img class="header__logo" src="images/zowify_logo.png" alt="">
                </a>
            </li>
            <li class="header__item  header__item--search">
                <input class="header__input" type="text" placeholder="Buscar en Zowify">
                <button class="header__submit" type="submit">
                    <i class="header__icon header__icon--search fa-solid fa-magnifying-glass"></i>
                </button>
            </li>
            <li class="header__item">
                <a class="header__button" href="/workspace_php/zowify/public/orders">
                    <i class="header__icon fa-solid fa-box-open"></i>
                    <span class="header__text">Mis pedidos</span>
                </a>
            </li>
            <li class="header__item">
                <a class="header__button header__button--cart" href="/workspace_php/zowify/public/cart">
                    <i class="header__icon fa-solid fa-bag-shopping"></i>
                    <span class="header__text">Mi carrito</span>
                </a>
            </li>
            <li class="header__item header__item--dropdown">
                <?php if (isset($_SESSION['user']['id'])): ?>
                    <div class="header__button header__button--menu">
                        <i class="header__icon fa-solid fa-user"></i>
                        <span class="header__text"><?= "Bienvenido, {$_SESSION['user']['first_name']}"; ?></span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>

                    <ul class="dropdown">
                        <li class="dropdown__item">
                            <a href="/workspace_php/zowify/public/profile" class="dropdown__button">
                                <i class="dropdown__icon fa-solid fa-address-card"></i>
                                <span class="dropdown__text">Mi perfil</span>
                            </a>
                        </li>
                        <li class="dropdown__item">
                            <button class="dropdown__button dropdown__button--logout" type="button">
                                <i class="dropdown__icon fa-solid fa-arrow-right-from-bracket"></i>
                                <span class="dropdown__text">Cerrar sesión</span>
                            </button>
                        </li>
                    </ul>
                <?php else: ?>
                    <div class="header__button header__button--login">
                        <i class="header__icon fa-solid fa-user"></i>
                        <span class="header__text"> Iniciar sesión</span>
                    </div>
                <?php endif; ?>
            </li>
        </ul>
    </div>
    <nav class="header__nav">
        <ul class="header__ul">
            <li class="header__category">
                <a class="header__button" href="/workspace_php/zowify/public/home">
                    <span class="header__text">Inicio</span>
                </a>
            </li>
            <li class="header__category">
                <a class="header__button" href="/workspace_php/zowify/public/home?category=offers">
                    <span class="header__text">Ofertas</span>
                </a>
            </li>
            <li class="header__category">
                <a class="header__button" href="/workspace_php/zowify/public/home?category=1">
                    <span class="header__text">Hombre</span>
                </a>
            </li>
            <li class="header__category">
                <a class="header__button" href="/workspace_php/zowify/public/home?category=2">
                    <span class="header__text">Mujer</span>
                </a>
            </li>
            <li class="header__category">
                <a class="header__button" href="/workspace_php/zowify/public/home?category=4">
                    <span class="header__text">Calzado</span>
                </a>
            </li>
            <li class="header__category">
                <a class="header__button" href="/workspace_php/zowify/public/home?category=5">
                    <span class="header__text">Accesorios</span>
                </a>
            </li>
            <li class="header__category">
                <a class="header__button" href="/workspace_php/zowify/public/home?category=7">
                    <span class="header__text">Belleza</span>
                </a>
            </li>
            <li class="header__category">
                <a class="header__button" href="/workspace_php/zowify/public/home?category=8">
                    <span class="header__text">Joyería</span>
                </a>
            </li>
            <li class="header__category">
                <a class="header__button" href="/workspace_php/zowify/public/home?category=9">
                    <span class="header__text">Perfumes</span>
                </a>
            </li>
            <li class="header__category">
                <a class="header__button" href="/workspace_php/zowify/public/home?category=11">
                    <span class="header__text">Otros</span>
                </a>
            </li>
        </ul>
    </nav>
</header>

<?php
if (!isset($_SESSION['user'])) require_once('auth_modal.php');
?>