<?php

require_once('../app/Core/Model.php');

class Product extends Model
{
    public $attributes = [];

    public function __get(string $attribute)
    {
        return $this->attributes[$attribute] ?? null;
    }

    public function create(array $data): int
    {
        $stmt = $this->conn->prepare("INSERT INTO product (title, description, price, discount, discount_type, stock, category_id, image) VALUES
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

    public function getAll(array $filters = []): array
    {
        $sql = "SELECT * FROM product WHERE deleted_at IS NULL";
        $params = [];

        if (!empty($filters['name'])) {
            $sql .= " AND title LIKE :name";
            $params['name'] = "%{$filters['name']}%";
        }

        if (!empty($filters['category'])) {
            if ($filters['category'] === 'offers') {
                $sql .= " AND ((discount_type = 'percentage' AND discount >= 20) OR (discount_type = 'fixed' AND discount >= 40))";
            } else {
                $sql .= " AND category_id = :category_id";
                $params['category_id'] = $filters['category'];
            }
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?self
    {
        $stmt = $this->conn->prepare("SELECT * FROM product WHERE id = :id AND deleted_at IS NULL");
        $stmt->execute(['id' => $id]);

        $productData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($productData) {
            $product = new self($this->database);
            $product->attributes = $productData;
            return $product;
        }

        return null;
    }

    public function update(int $id, array $data): int
    {
        if (isset($data['image'])) {
            $stmt = $this->conn->prepare("UPDATE product SET title = :title, description = :description, price = :price, discount = :discount, discount_type = :discount_type, stock = :stock, category_id = :category_id, image = :image WHERE id = :id");
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
            $stmt = $this->conn->prepare("UPDATE product SET title = :title, description = :description, price = :price, discount = :discount, discount_type = :discount_type, stock = :stock, category_id = :category_id WHERE id = :id");
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

    public function delete(int $id): int
    {
        $stmt = $this->conn->prepare("UPDATE product SET deleted_at = NOW() WHERE id = :id");
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount();
    }

    public function calculateUnitFinalPrice(): float
    {
        if ($this->discount > 0) {
            $discountAmount = $this->discount_type === 'percentage'
                ? $this->price * ($this->discount / 100)
                : $this->discount;

            return $this->price - $discountAmount;
        }

        return $this->price;
    }
}
