<?php

namespace app\adapter;

interface IMain
{
    public function connect();

    public function addProduct($productName, $productImage, $productQuantity, $productPrice);

    public function getProducts();

    public function checkProduct($productName);

    public function removeProduct($productName);

    public function removeAllProducts();

    public function getTotalAmount();

    public function updateAmount();

    public function increaseProductQuantity($productName);

    public function decreaseProductQuantity($productName);
}