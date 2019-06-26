<?php

use app\modules\Cart;
use app\connection\Connection;
use app\connection\MyRedis;

ini_set('display_errors',1);
error_reporting(E_ALL);

define('DIR', str_replace('\\','/', dirname(__FILE__)));

require_once(DIR . '/config.php');
require_once(DIR . '/vendor/autoload.php');

$redis = new MyRedis();
$connection = new Connection($redis);

$cart = new Cart($connection);
$cartProducts = $cart->getProducts();

$totalAmount = $cart->updateAmount();

if(isset($_POST['removeProduct'])) {
    $cart->removeProduct($_POST['product']);
}

if (isset($_POST['increaseProductQuantity'])) {
    $quantity = $cart->increaseProductQuantity($_POST['product']);

    return print $quantity;
}

if (isset($_POST['decreaseProductQuantity'])) {
    $quantity = $cart->decreaseProductQuantity($_POST['product']);

    return print $quantity;
}

if(isset($_POST['deleteAllProducts'])) {
    $cart->removeAllProducts();

    return $cartProducts;
}

if (isset($_POST['updateAmount'])) {
    $totalAmount = $cart->updateAmount();

    return print(json_encode($totalAmount, true));
}

if(isset($_POST['product']) && isset($_POST['image']) && isset($_POST['quantity']) && isset($_POST['price'])) {
    $cart->addProduct($_POST['product'], $_POST['image'], 1, $_POST['price']);
    $quantityProducts = $cart->getTotalQuantity();

    return print(json_encode($quantityProducts, true));
}

require_once 'view/cart.php';

