<?php

class CartTotals
{

    public function calculateTotalQuantity(): int
    {
        $totalQuantity = 0;

        foreach ($_SESSION['cart'] as $product) {
            $totalQuantity += $product['quantity'];
        }

        return $totalQuantity;
    }

    public function calculateTotalDiscountAmount(): float
    {
        $totalDiscountAmount = 0;

        foreach ($_SESSION['cart'] as $product) {
            $totalDiscountAmount += $product['base_price'] - $product['final_price'];
        }

        return $totalDiscountAmount;
    }

    public function calculateSubtotal(): float
    {
        $subtotal = 0;

        foreach ($_SESSION['cart'] as $product) {
            $subtotal += $product['final_price'];
        }

        return $subtotal;
    }

    public function calculateTotalBase(): float
    {
        $totalBase = 0;

        foreach ($_SESSION['cart'] as $product) {
            $totalBase += $product['base_price'];
        }

        return $totalBase;
    }
}
