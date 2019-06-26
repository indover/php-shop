<?php

namespace app\modules;

use app\connection\Connection;

class Cart
{
    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection->getConnection();
    }

    public function getTotalQuantity()
    {
        $count = 0;
        foreach($this->getProducts() as $product) {
           $count += $product['quantity'];
        }
        return $count;
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

    public function increaseProductQuantity($productName)
    {
        return $this->connection->increaseProductQuantity($productName);
    }

    public function decreaseProductQuantity($productName)
    {
        return $this->connection->decreaseProductQuantity($productName);
    }

    public function removeAllProducts() {
        return $this->connection->removeAllProducts();
    }

    public function updateAmount()
    {
        return $this->connection->updateAmount();
    }

}
