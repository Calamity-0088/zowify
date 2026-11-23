<?php

require_once('../app/Core/Database.php');
require_once('../app/Core/Controller.php');
require_once('../app/Models/Product.php');
require_once('../app/Models/Order.php');

class OrderController extends Controller
{
    public $product;
    public $order;


    public function __construct()
    {
        $db = new Database();
        $this->product = new Product($db);
        $this->order = new Order($db);
    }

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') $this->errorMethodNotAllowed();
        if (!isset($_SESSION['user'])) $this->errorUnauthorized('Sesión requerida');

        $orderData = $this->order->getAll($_SESSION['user']['id']);
        $info = [];

        foreach ($orderData as $order) {
            $orderId = $order['id_order'];
            $product = $this->product->find($order['id_product']);

            if (!isset($info[$orderId])) {
                $info[$orderId] = [
                    'id' => $order['id_order'],
                    'id_user' => $order['id_user'],
                    'total_price' => $order['total_price'],
                    'payment_status' => $order['payment_status'],
                    'shipping_status' => $order['shipping_status'],
                    'created_at' => $order['created_at'],
                    'updated_at' => $order['updated_at']
                ];
            }

            $info[$orderId]['items'][] = [
                'id_product' => $order['id_product'],
                'name' => $product['title'],
                'quantity' => $order['quantity'],
                'price' => $order['price']
            ];
        }

        $orders = array_values($info);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $orders
        ]);
    }

    public function show($id)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') $this->errorMethodNotAllowed();
        if (!isset($_SESSION['user'])) $this->errorUnauthorized('Sesión requerida');

        $orderData = $this->order->getById($_SESSION['user']['id'], $id);

        //quitarle el id al objeto

        foreach ($orderData as $order) {
            $orderId = $order['id_order'];
            $product = $this->product->find($order['id_product']);

            if (!isset($info)) {
                $info = [
                    'id' => $order['id_order'],
                    'id_user' => $order['id_user'],
                    'total_price' => $order['total_price'],
                    'payment_status' => $order['payment_status'],
                    'shipping_status' => $order['shipping_status'],
                    'created_at' => $order['created_at'],
                    'updated_at' => $order['updated_at']
                ];
            }

            $info['items'][] = [
                'id_product' => $order['id_product'],
                'name' => $product['title'],
                'quantity' => $order['quantity'],
                'price' => $order['price']
            ];
        }

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $info
        ]);
    }

    //* Crea un nuevo pedido cada que se abre "Mi Carrito" y devuelve la información actualizada.
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') $this->errorMethodNotAllowed();
        if (empty($_SESSION['user'])) $this->errorUnauthorized('Sesión requerida');
        if (empty($_SESSION['cart'])) $this->errorBadRequest('Carrito requerido');

        $totalProducts = 0;
        $total = 0;
        $totalDiscount = 0;

        foreach ($_SESSION['cart'] as $product) {
            $totalProducts += $product['quantity'];
            //* Calcula subtotal del producto
            $subtotal = $product['price'] * $product['quantity'];
            //* Calcula descuento según el tipo (percentage o fixed)
            $discountValue = ($product['discount'] ?? 0);
            $discountType = ($product['discount_type'] ?? 'percentage');

            if ($discountType === 'percentage') {
                //* Descuento porcentual
                $productDiscount = ($subtotal * $discountValue) / 100;
            } else {
                //* Descuento fijo (monto por unidad)
                $productDiscount = $discountValue * $product['quantity'];
            }

            $total += $subtotal;
            $totalDiscount += $productDiscount;
        }
        $total = number_format($total, 2, '.', '');
        $totalDiscount = number_format($totalDiscount, 2, '.', '');
        $totalFinal = number_format($total - $totalDiscount, 2, '.', '');

        $_SESSION['order'] = [
            'id_user' => $_SESSION['user']['id'],
            'total_products' => $totalProducts,
            'total' => $total,
            'discount' => $totalDiscount,
            'final_price' => $totalFinal
        ];

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $_SESSION['order']
        ]);
    }
}
