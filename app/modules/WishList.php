<?php

namespace app\modules;

use app\connection\Connection;

class WishList
{
    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection->getConnection();
    }

    public function addProduct($productName, $productImage, $productQuantity, $productPrice) {
        return $this->connection->addProduct($productName, $productImage, $productQuantity, $productPrice);
    }

    public function checkProduct($productName) {
        return $this->connection->checkProduct($productName);
    }

    public function getProducts() {
        return $this->connection->getProducts();
    }

    public function removeProduct($productName) {
        return $this->connection->removeProduct($productName);
    }

    public function removeAllProducts() {
        return $this->connection->removeAllProducts();
    }
}