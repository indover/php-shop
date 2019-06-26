<?php

namespace app\connection;

use Predis\Client;
use app\adapter\IMain;

class MyRedis implements IMain
{
    private $connection;

    public function connect()
    {
        $redis = new Client();
        $this->connection = $redis;

        return $redis;
    }

    public function getTable($table)
    {
        $table = $this->connect()->get($table);
        $table = json_decode($table, true);

        return $table ?? [];
    }

    public function getTotalAmount() {}

    public function addProduct($productName, $productImage, $productQuantity, $productPrice)
    {
        $cart = $this->getTable('cart');

        if($this->checkProduct($productName)) {
            foreach ($cart as $index => $item) {
                if($item['product'] == $productName) {
                    $cart[$index]['quantity'] += $productQuantity;
                }
            }
        } else {
            array_push($cart, [
                'product'  => $productName,
                'image'    => $productImage,
                'quantity' => $productQuantity,
                'price'    => $productPrice
            ]);
        }

        $this->connect()->set('cart', json_encode($cart));
    }

    public function checkProduct($productName)
    {
        foreach ($this->getTable('cart') as $count) {
                if ($count['product'] == $productName) {
                return true;
            }
        }

        return false;
    }

    public function getProducts()
    {
        $redis = $this->getTable('cart');

        $products = [];
        $count = 0;

        foreach ($redis as $product) {
            if ($product['quantity'] < 1 ) {
                self::removeProduct($product['product']);
            }
                $products[$count]['product']  = $product['product'];
                $products[$count]['image']    = $product['image'];
                $products[$count]['quantity'] = $product['quantity'];
                $products[$count]['price']    = $product['price'];

                $count++;
        }

        return $products;
    }

    public function removeProduct($productName)
    {
        $cart = $this->getTable('cart');

        foreach ($cart as $key => $item) {
            if($item['product'] == $productName) {
                unset($cart[$key]);
            }
        }

        $this->connect()->set('cart', json_encode($cart, true));
    }

    public function removeAllProducts()
    {
        $this->connect()->del('cart');
    }
    
    public function updateAmount()
    {
        $products = $this->getProducts();

        $totalAmount = 0;
        $totalQuantity = 0;
        foreach ($products as $product) {
            $totalQuantity += $product['quantity'];
            $totalAmount += $product['price'] * $product['quantity'];
        }

        return ['quantity' => $totalQuantity ,'total' => $totalAmount];
    }

    public function increaseProductQuantity($productName)
    {
        $cart = $this->getTable('cart');
        $result = false;
        foreach ($cart as $key => $item) {
            if ($item['product'] == $productName) {
                $cart[$key]['quantity']++;
                $result = $cart[$key]['quantity'];
            }
        }

        $this->connect()->set('cart', json_encode($cart, true));
        
        return $result;
    }

    public function decreaseProductQuantity($productName)
    {
        $cart = $this->getTable('cart');
        $result = false;
        foreach ($cart as $key => $item) {
            if ($item['product'] == $productName) {
                $cart[$key]['quantity']--;
                $result = $cart[$key]['quantity'];
            }
        }

        $this->connect()->set('cart', json_encode($cart, true));

        return $result;
    }
}