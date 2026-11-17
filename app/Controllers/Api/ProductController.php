<?php

require_once('../app/Core/Database.php');
require_once('../app/Core/Controller.php');
require_once('../app/Models/Product.php');


class ProductController extends Controller
{
    public $product;

    public function __construct()
    {
        $db = new Database();
        $this->product = new Product($db);
    }

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') $this->errorMethodNotAllowed();

        $products = $this->product->getAll();

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $products
        ]);
    }

    public function indexOffers()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') $this->errorMethodNotAllowed();

        $products = $this->product->getOffer();

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $products
        ]);
    }

    public function show()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') $this->errorMethodNotAllowed();
        // if (!isset($name)) $this->errorBadRequest('Nombre requerido');
        if (!isset($_GET['search'])) $this->errorBadRequest('Parámetro de búsqueda requerido');
        $products = $this->product->getByName($_GET['search']);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $products
        ]);
    }

    public function showCategory($category)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') $this->errorMethodNotAllowed();
        if (!isset($category)) $this->errorBadRequest('Categoría requerida');

        $products = $this->product->getByCategory($category);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $products
        ]);
    }

    public function showId($id)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') $this->errorMethodNotAllowed();
        if (!isset($id) || !is_numeric($id)) $this->errorBadRequest('ID requerido y debe ser numérico');

        $products = $this->product->getById($id);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $products
        ]);
    }

    public function store()
    {
        $requiredFields = ['title', 'description', 'price', 'stock', 'category_id'];

        if ($_SERVER['REQUEST_METHOD'] != 'POST') $this->errorMethodNotAllowed();
        foreach ($requiredFields as $field) {
            if (!isset($_POST[$field]) || empty($_POST[$field])) $this->errorBadRequest("$field requerido");
        }

        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'price' => $_POST['price'],
            'discount' => $_POST['discount'] ?? 0,
            'discount_type' => $_POST['discount_type'] ?? 'percentage',
            'stock' => $_POST['stock'],
            'category_id' => $_POST['category_id']
        ];

        if (isset($_FILES['image'])) {
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $fileName = date('His') . '_' . time() . '.' . $extension;
            move_uploaded_file($_FILES['image']['tmp_name'], "images/$fileName");
            $data['image'] = $fileName;
        }

        $result = $this->product->create($data);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => $result > 0,
            'message' => $result > 0 ? 'Producto creado correctamente' : 'Producto no creado'
        ]);
    }

    public function update($id)
    {
        $requiredFields = ['title', 'description', 'price', 'stock', 'category_id'];

        if ($_SERVER['REQUEST_METHOD'] != 'POST') $this->errorMethodNotAllowed();
        if (!isset($id) || !is_numeric($id)) $this->errorBadRequest('ID requerido y debe ser numérico');
        foreach ($requiredFields as $field) {
            if (!isset($_POST[$field]) || empty($_POST[$field])) $this->errorBadRequest("$field requerido");
        }

        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'price' => $_POST['price'],
            'discount' => $_POST['discount'] ?? 0,
            'discount_type' => $_POST['discount_type'] ?? 'percentage',
            'stock' => $_POST['stock'],
            'category_id' => $_POST['category_id'],
        ];

        if (isset($_FILES['image'])) {
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $fileName = date('His') . '_' . time() . '.' . $extension;

            $data['image'] = $fileName;
            move_uploaded_file($_FILES['image']['tmp_name'], "images/$fileName");
        }

        $result = $this->product->update($id, $data);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => $result > 0,
            'message' => $result > 0 ? 'Producto actualizado correctamente' : 'Producto no encontrado'
        ]);
    }

    public function destroy($id)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'DELETE') $this->errorMethodNotAllowed();
        if (!isset($id) || !is_numeric($id)) $this->errorBadRequest('ID requerido y debe ser numérico');

        $result = $this->product->delete($id);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => $result > 0,
            'message' => $result > 0 ? 'Producto eliminado correctamente' : 'Producto no encontrado'
        ]);
    }
}
