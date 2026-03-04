<?php

require_once('../app/Core/Database.php');
require_once('../app/Core/Controller.php');
require_once('../app/Models/User.php');

class UserController extends Controller
{
    public $user;

    public function __construct()
    {
        $db = new Database();
        $this->user = new User($db);
    }

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') $this->errorMethodNotAllowed();

        $users = $this->user->getAll();

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $users
        ]);
    }

    public function show($email)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') $this->errorMethodNotAllowed();
        if (!isset($email)) $this->errorBadRequest('Email requerido');

        $user = $this->user->getByEmail($email);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $user
        ]);
    }

    public function showById()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') $this->errorMethodNotAllowed();
        if (!isset($_SESSION['user']['id'])) $this->errorUnauthorized('Sesión requerida');

        $user = $this->user->getById($_SESSION['user']['id']);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $user
        ]);
    }

    public function update()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if ($_SERVER['REQUEST_METHOD'] != 'POST') $this->errorMethodNotAllowed();
        if (!isset($_SESSION['user']['id'])) $this->errorUnauthorized('Sesión requerida');
        if (isset($data['email'])) {
            $user = $this->user->getByEmailExceptMe($data['email'], $_SESSION['user']['id']);
            if ($user) $this->errorConflict('Correo electrónico ya está siendo usado por otra cuenta');
        }

        $result = $this->user->update($_SESSION['user']['id'], $data);
        $updatedUser = $this->user->getById($_SESSION['user']['id']);

        $_SESSION['user'] = [
            'id' => $updatedUser['id'],
            'first_name' => $updatedUser['first_name'],
            'last_name' => $updatedUser['last_name'],
            'email' => $updatedUser['email'],
            'created' => $updatedUser['created_at'],
            'updated' => $updatedUser['updated_at']
        ];

        header('Content-Type: application/json');
        echo json_encode([
            'success' => $result > 0,
            'message' => $result > 0 ? 'Usuario actualizado correctamente' : 'Usuario no encontrado'
        ]);
    }

    public function destroy($id)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'DELETE') $this->errorMethodNotAllowed();
        if (!isset($id) || !is_numeric($id)) $this->errorBadRequest('ID requerido y debe ser numérico');

        $result = $this->user->delete($id);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => $result > 0,
            'message' => $result > 0 ? 'Usuario eliminado correctamente' : 'Usuario no encontrado'
        ]);
    }
}
