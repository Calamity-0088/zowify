<?php

require_once('../app/Core/Database.php');
require_once('../app/Core/Controller.php');
require_once('../app/Models/Product.php');

class CartController extends Controller
{
    public $cart;

    public function __construct()
    {
        $db = new Database();
        $this->cart = new Product($db);
    }

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') $this->errorMethodNotAllowed();

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $_SESSION['cart'] ?? []
        ]);
    }

    public function show($id)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') $this->errorMethodNotAllowed();
        if (empty($id) || !is_numeric($id)) $this->errorBadRequest('ID requerido y debe ser numérico');
        if (empty($_SESSION['cart'])) return; //! Sólo devuelve return para no detener el flujo del código JS.

        foreach ($_SESSION['cart'] as $product) {
            if ($product['id'] == $id) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'data' => $product
                ]);
                return;
            }
        }
    }

    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if ($_SERVER['REQUEST_METHOD'] != 'POST') $this->errorMethodNotAllowed();
        if (!isset($data['id']) || !isset($data['quantity'])) $this->errorBadRequest('ID y cantidad requeridos');
        if (empty($_SESSION['user'])) $this->errorUnauthorized('Sesión requerida');
        $product = $this->cart->getById($data['id']);
        if (!$product) $this->errorNotFound('Producto no encontrado');
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $cartItem) {
                if ($product['id'] === $cartItem['id']) return;
            }
        }

        $_SESSION['cart'][] = [
            'id' => $data['id'],
            'title' => $product['title'],
            'price' => $product['price'],
            'discount' => $product['discount'] ?? 0,
            'discount_type' => $product['discount_type'] ?? 'percentage',
            'quantity' => $data['quantity'],
            'image' => $product['image']
        ];

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message' => 'Producto agregado al carrito'
        ]);
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if ($_SERVER['REQUEST_METHOD'] != 'POST') $this->errorMethodNotAllowed();
        if (!isset($id) || !isset($data['quantity'])) $this->errorBadRequest('ID y cantidad requeridos');
        if (empty($_SESSION['cart'])) return;

        foreach ($_SESSION['cart'] as $key => &$product) {
            if ($id == $product['id']) {
                $productData = $this->cart->getById($id);
                if ($product['quantity'] >= $productData['stock']) break;
                $product['quantity'] = $data['quantity'];
                if ($product['quantity'] <= 0) unset($_SESSION['cart'][$key]);
            }
        }

        unset($product);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message' => 'Cantidad actualizada correctamente'
        ]);
    }

    public function destroy($id)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'DELETE') $this->errorMethodNotAllowed();
        if (!isset($id) || !is_numeric($id)) $this->errorBadRequest('ID requerido y debe ser numérico');

        $cartProductFound = false;

        //* Recorre como array asociativo para borrar el valor usando la clave, de lo contrario sólo borrará la copia temporal.
        foreach ($_SESSION['cart'] as $key => $product) {
            if ($id == $product['id']) {
                unset($_SESSION['cart'][$key]);
                $cartProductFound = true;
            }
        }

        if ($cartProductFound) {
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }

        unset($product);

        if ($cartProductFound) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Producto eliminado del carrito correctamente'
            ]);
        } else {
            $this->errorNotFound('Producto no encontrado en el carrito');
        }
    }

    public function clear() {}
}
