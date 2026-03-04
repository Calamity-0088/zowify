<?php

session_name('zowify_session');
session_start();

require_once '../vendor/autoload.php';

//* Llama al método de la clase Dotenv a través de un namespace, recibe la ubicación del archivo .env y devuelve un objeto.
$dotenv = Dotenv\Dotenv::createImmutable('../');
//* Carga las variables del archivo .env como variables de entorno disponibles a través de $_ENV.
$dotenv->load();

class Router
{
    /* protected $routes;

    // Método que definirá las acciones
    public function add($method, $controllerName, $action)
    {
        $controller = new $controllerName();
        $controller->$action();
    }

    // Método que ejecuta un controlador si la acción está definida y es solicitada
    public function dispatch()
    {
        $requestUrl = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($requestUrl) && isset($requestMethod)) {
        }
    } */

    public function route()
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $request = str_replace('/workspace_php/zowify/public', '', $path);

        if ($request === '' || $request === '/') $request = '/home';

        if (str_starts_with($request, '/Api/')) {
            $items = explode('/', $request);
            $controllerName = $items[2] . 'Controller';
            $action = $items[3];
            $param = $items[4] ?? null;

            try {
                require_once("../app/Controllers/Api/{$controllerName}.php");

                $controller = new $controllerName();
                $controller->$action($param);
            } catch (Throwable $err) {
                header('Content-Type: application/json');
                http_response_code(500); // O el código que corresponda
                echo json_encode([
                    'success' => false,
                    'error' => $err->getMessage()
                ]);
            }
        } else {
            switch ($request) {
                case '/home':
                    require_once('../app/Views/home.php');
                    break;
                case '/admin':
                    require_once('../app/Views/edit.php');
                    break;
                case '/search':
                    require_once('../app/Views/search.php');
                    break;
                case '/product':
                    require_once('../app/Views/product.php');
                    break;
                case '/profile':
                    require_once('../app/Views/profile.php');
                    break;
                case '/cart':
                    require_once('../app/Views/cart.php');
                    break;
                case '/orders':
                    require_once('../app/Views/orders.php');
                    break;
                case '/detail':
                    require_once('../app/Views/order_detail.php');
                    break;
                default:
                    require_once('../app/Views/404.php');
                    break;
            };
        }
    }
}
