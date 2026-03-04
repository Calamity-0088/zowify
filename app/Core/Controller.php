<?php

class Controller
{
    public function view($view, $data = [])
    {
        $zombie = $data;
        require_once("../app/Views/$view.php");
    }

    public function errorBadRequest($message)
    {
        header('Content-Type: application/json');
        http_response_code(400);
        echo json_encode(['error' => $message]);
        exit;
    }

    public function errorUnauthorized($message)
    {
        header('Content-Type: application/json');
        http_response_code(401);
        echo json_encode(['error' => $message]);
        exit;
    }

    public function errorNotFound($message)
    {
        header('Content-Type: application/json');
        http_response_code(404);
        echo json_encode(['error' => $message]);
        exit;
    }

    public function errorMethodNotAllowed()
    {
        header('Content-Type: application/json');
        http_response_code(405);
        echo json_encode(['error' => 'Método HTTP no permitido']);
        exit;
    }

    public function errorConflict($message)
    {
        header('Content-Type: application/json');
        http_response_code(409);
        echo json_encode(['error' => $message]);
        exit;
    }
}
