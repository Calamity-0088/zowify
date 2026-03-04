<?php

require_once('../app/Core/Model.php');

class Product extends Model
{
    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO product (title, description, price, discount, discount_type, stock, category_id, image) VALUES
        (:title, :description, :price, :discount, :discount_type, :stock, :category_id, :image)");
        $stmt->execute([
            'title' => $data['title'],
            'description' => $data['description'],
            'price' => $data['price'],
            'discount' => $data['discount'] ?? 0,
            'discount_type' => $data['discount_type'] ?? 'percentage',
            'stock' => $data['stock'],
            'category_id' => $data['category_id'],
            'image' => $data['image'] ?? null
        ]);

        return $stmt->rowCount();
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM product WHERE deleted_at IS NULL");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOffer()
    {
        $stmt = $this->db->prepare("SELECT * FROM product WHERE (discount_type = 'percentage' AND discount >= 20) OR (discount_type = 'fixed' AND discount >= 40) AND deleted_at IS NULL");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM product WHERE id = :id AND deleted_at IS NULL");
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByName($name)
    {
        $stmt = $this->db->prepare("SELECT * FROM product WHERE title LIKE :name AND deleted_at IS NULL");
        $stmt->execute(['name' => "%$name%"]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByCategory($category)
    {
        $stmt = $this->db->prepare("SELECT * FROM product WHERE category_id = :category_id AND deleted_at IS NULL");
        $stmt->execute(['category_id' => $category]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $data)
    {
        if (isset($data['image'])) {
            $stmt = $this->db->prepare("UPDATE product SET title = :title, description = :description, price = :price, discount = :discount, discount_type = :discount_type, stock = :stock, category_id = :category_id, image = :image WHERE id = :id");
            $stmt->execute([
                'id' => $id,
                'title' => $data['title'],
                'description' => $data['description'],
                'price' => $data['price'],
                'discount' => $data['discount'] ?? 0,
                'discount_type' => $data['discount_type'] ?? 'percentage',
                'stock' => $data['stock'],
                'category_id' => $data['category_id'],
                'image' => $data['image']
            ]);

            return $stmt->rowCount();
        } else {
            $stmt = $this->db->prepare("UPDATE product SET title = :title, description = :description, price = :price, discount = :discount, discount_type = :discount_type, stock = :stock, category_id = :category_id WHERE id = :id");
            $stmt->execute([
                'id' => $id,
                'title' => $data['title'],
                'description' => $data['description'],
                'price' => $data['price'],
                'discount' => $data['discount'] ?? 0,
                'discount_type' => $data['discount_type'] ?? 'percentage',
                'stock' => $data['stock'],
                'category_id' => $data['category_id']
            ]);

            return $stmt->rowCount();
        }
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("UPDATE product SET deleted_at = NOW() WHERE id = :id");
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount();
    }
}
