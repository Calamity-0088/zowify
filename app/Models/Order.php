<?php

require_once('../app/Core/Model.php');

class Order extends Model
{
    public function getAll($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM `order` INNER JOIN order_item ON `order`.id = order_item.id_order WHERE `order`.id_user = :id");
        $stmt->execute(['id' => $id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($idUser, $idOrder)
    {
        $stmt = $this->conn->prepare("SELECT * FROM `order` INNER JOIN order_item ON `order`.id = order_item.id_order WHERE `order`.id_user = :id_user AND `order`.id = :id_order");
        $stmt->execute([
            'id_user' => $idUser,
            'id_order' => $idOrder
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($orderData, $cartData)
    {
        $this->conn->beginTransaction();
        try {

            $stmt = $this->conn->prepare("INSERT INTO `order` (id_user, total_price) VALUES (:id_user, :total_price)");
            $stmt->execute([
                'id_user' => $orderData['id_user'],
                'total_price' => $orderData['final_price']
            ]);

            $orderId = $this->conn->lastInsertId();
            $stmt = $this->conn->prepare("INSERT INTO order_item (id_order, id_product, quantity, price) VALUES (:id_order, :id_product, :quantity, :price)");

            foreach ($cartData as $product) {
                $stmt->execute([
                    'id_order' => $orderId,
                    'id_product' => $product['id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price']
                ]);
            }

            $this->conn->commit();
            return $orderId;
        } catch (Throwable $err) {
            $this->conn->rollBack();
            throw $err;
        }
    }

    public function update($id, $status, $cartData)
    {
        $this->conn->beginTransaction();
        try {
            $stmt = $this->conn->prepare("UPDATE `order` SET payment_status = :payment_status WHERE id = :id");
            $stmt->execute([
                'payment_status' => $status,
                'id' => $id
            ]);

            $stmt = $this->conn->prepare("UPDATE product SET stock = stock - :quantity WHERE id = :id");
            foreach ($cartData as $product) {
                $stmt->execute([
                    'quantity' => $product['quantity'],
                    'id' => $product['id']
                ]);
            }

            $this->conn->commit();
        } catch (Throwable $err) {
            $this->conn->rollBack();
            throw $err;
        }
    }
}
