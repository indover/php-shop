<?php

namespace app\connection;

use PDO;
use app\adapter\IMain;

class MySQL implements IMain
{

    private $connection;

    /**
     * connect to the SQLite database
     */
    public function __construct() {
        $pdo = new PDO('sqlite:'. ROOT.DATABASE_PATH);
        $this->connection = $pdo;
    }

    public function getProducts() {

        $sql = "SELECT * FROM products";
        $products = $this->connection->prepare($sql);
        $products->execute();

        return $products->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function checkProduct($productName) {

        $sql = "SELECT * FROM products WHERE name = :name";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['name' => $productName]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addProduct($productName, $productImage, $productQuantity, $productPrice) {

        if ($this->checkProduct($productName)) {
            $this->getProducts();
        } else {
            $sql = "INSERT INTO products (name, image, price) VALUES (:name, :image, :price)";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([
                'name'  => $productName,
                'image' => $productImage,
                'price' => $productPrice
            ]);
        }

        return false;
    }

    public function removeProduct($productName) {

        $sql = "DELETE FROM products WHERE name = :name";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            'name' => $productName
        ]);
    }

    public function removeAllProducts() {

        $sql = "DELETE FROM products";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
    }
    public function connect() {}

    public function getTotalAmount() {}

    public function updateAmount() {}

    public function increaseProductQuantity($productName) {}

    public function decreaseProductQuantity($productName) {}


}