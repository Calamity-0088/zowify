<?php

require_once('../app/Core/Database.php');
require_once('../app/Core/Controller.php');
require_once('../app/Models/User.php');

class AuthController extends Controller
{
    public $user;

    public function __construct()
    {
        $db = new Database();
        $this->user = new User($db);
    }

    public function register()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $requiredFields = ['first_name', 'last_name', 'email', 'password'];

        if ($_SERVER['REQUEST_METHOD'] != 'POST') $this->errorMethodNotAllowed();
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) $this->errorBadRequest("$field requerido");
        }
        $user = $this->user->getByEmail($data['email']);
        if ($user) $this->errorConflict('Correo electrónico ya está siendo usado por otra cuenta');

        $data['address'] = $data['address'] ?? null;
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $result = $this->user->create($data);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => $result > 0,
            'message' => $result > 0 ? 'Usuario registrado correctamente' : 'Error al registrar'
        ]);
    }

    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if ($_SERVER['REQUEST_METHOD'] != 'POST') $this->errorMethodNotAllowed();
        if (!isset($data['email']) || !isset($data['password'])) $this->errorBadRequest('Credenciales requeridas');
        $user = $this->user->getByEmail($data['email']);
        if (!$user) $this->errorNotFound('Correo electrónico no asociado a una cuenta');
        if (!password_verify($data['password'], $user['password'])) $this->errorUnauthorized('Credenciales incorrectas');

        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => $user['id'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'created' => $user['created_at'],
            'updated' => $user['updated_at']
        ];

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message' => 'Sesión iniciada correctamente'
        ]);
    }

    public function logout()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') $this->errorMethodNotAllowed();

        session_destroy();

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message' => 'Sesión cerrada correctamente'
        ]);
    }
}
