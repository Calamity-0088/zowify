<?php

require_once('../app/Core/Model.php');

class User extends Model
{
    public function create($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO user (first_name, last_name, address, email, password) VALUES (:first_name, :last_name, :address, :email, :password)");
        $stmt->execute([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'address' => $data['address'],
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        return $stmt->rowCount();
    }

    public function getAll()
    {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE deleted_at IS NULL");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE id = :id AND deleted_at IS NULL");
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE email = :email AND deleted_at IS NULL");
        $stmt->execute(['email' => $email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEmailExceptMe($email, $id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE email = :email AND id != :id AND deleted_at IS NULL");
        $stmt->execute([
            'email' => $email,
            'id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data)
    {
        $fields = [];
        $params = ['id' => $id];

        foreach ($data as $field => $value) {
            if (isset($value) && !empty($value)) {
                $fields[] = "$field = :$field";
                $params[$field] = $value;
            }
        }

        $stmt = $this->conn->prepare("UPDATE user SET " . implode(', ', $fields) . " WHERE id = :id");
        $stmt->execute($params);

        return $stmt->rowCount();
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("UPDATE user SET deleted_at = NOW() WHERE id = :id");
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount();
    }
}
