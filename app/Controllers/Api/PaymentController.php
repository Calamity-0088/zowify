<?php

require_once('../app/Core/Database.php');
require_once('../app/Core/Controller.php');
require_once('../app/Models/Order.php');

use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\MercadoPagoConfig;

class PaymentController extends Controller
{
    public $order;

    public function __construct()
    {
        $db = new Database();
        $this->order = new Order($db);
        MercadoPagoConfig::setAccessToken($_ENV['ACCESS_TOKEN_MP']);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') $this->errorMethodNotAllowed();
        if (empty($_SESSION['order']) || empty($_SESSION['cart'])) $this->errorBadRequest('Orden y carrito requeridos');

        $data = json_decode(file_get_contents('php://input'), true);
        $orderData = $_SESSION['order'];
        $cartData = $_SESSION['cart'];
        $orderId = $this->order->create($orderData, $cartData);

        try {
            $client = new PaymentClient();
            $request_options = new RequestOptions();
            $request_options->setCustomHeaders(["X-Idempotency-Key: zowify_$orderId"]);

            $payment = $client->create([
                "transaction_amount" => (float) $_SESSION['order']['final_price'],
                "token" => $data['token'],
                "external_reference" => $orderId,
                "description" => $data['description'] ?? "Orden #$orderId en Zowify",
                "installments" => $data['installments'],
                "payment_method_id" => $data['payment_method_id'],
                "issuer_id" => $data['issuer_id'],
                "payer" => [
                    "email" => $data['payer']['email'],
                    "identification" => [
                        "type" => $data['payer']['identification']['type'],
                        "number" => $data['payer']['identification']['number']
                    ]
                ]
            ], $request_options);

            $status = $payment->status;

            $this->order->update($orderId, $status, $cartData);
            if ($status == 'approved') {
                $_SESSION['cart'] = [];
                unset($_SESSION['order']);
            }

            header('Content-Type: application/json');
            echo json_encode($payment);
        } catch (Throwable $err) {
            header('Content-Type: application/json');
            echo json_encode(['error' => $err->getMessage()]);
        }
    }
}
