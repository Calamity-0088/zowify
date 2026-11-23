<?php

require_once('../app/Core/Database.php');
require_once('../app/Core/Controller.php');
require_once('../app/Models/Product.php');
require_once('../app/Services/CartTotals.php');

class CartController extends Controller
{
    public $product;
    public $cartService;

    public function __construct()
    {
        $db = new Database();
        $this->product = new Product($db);
        $this->cartService = new CartTotals();
    }

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') $this->errorMethodNotAllowed();

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $_SESSION['cart'] ?? [],
            'totals' => [
                'subtotal' => $this->cartService->calculateSubtotal(),
                'total_base' => $this->cartService->calculateTotalBase(),
                'total_discount' => $this->cartService->calculateTotalDiscountAmount(),
                'total_quantity' => $this->cartService->calculateTotalQuantity(),
            ],
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
        if (!isset($data['product_id']) || !isset($data['quantity'])) $this->errorBadRequest('ID y cantidad requeridos');
        // if (empty($_SESSION['user'])) $this->errorUnauthorized('Sesión requerida');
        $product = $this->product->find($data['product_id']);
        if (!$product) $this->errorNotFound('Producto no encontrado');
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $cartItem) {
                if ($product->id == $cartItem['id']) $this->errorConflict('El producto ya está en el carrito.');
            }
        }

        $_SESSION['cart'][] = [
            'id' => $product->id,
            'title' => $product->title,
            'image' => $product->image,
            'quantity' => $data['quantity'],
            'discount_type' => $product->discount_type ?? 'percentage',
            'discount' => $product->discount ?? 0,
            'unit_base_price' => $product->price,
            'unit_final_price' => $product->calculateUnitFinalPrice(),
            'base_price' => $product->price * $data['quantity'],
            'final_price' => $product->calculateUnitFinalPrice() * $data['quantity'],
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
        if (!isset($id) || !isset($data['action'])) $this->errorBadRequest('ID y acción requeridos');
        if (empty($_SESSION['cart'])) $this->errorBadRequest('El carrito está vacío');

        foreach ($_SESSION['cart'] as $key => &$cartItem) {
            if ($id == $cartItem['id']) {
                $product = $this->product->find($id);

                if ($data['action'] === 'increase' && $cartItem['quantity'] >= $product->stock) $this->errorConflict('No hay más stock para este producto');
                $data['action'] === 'increase' ? $cartItem['quantity']++ : $cartItem['quantity']--;
                $cartItem['base_price'] = $product->price * $cartItem['quantity'];
                $cartItem['final_price'] = $product->calculateUnitFinalPrice() * $cartItem['quantity'];
                if ($cartItem['quantity'] <= 0) unset($_SESSION['cart'][$key]);
            }
        }

        unset($cartItem);

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
