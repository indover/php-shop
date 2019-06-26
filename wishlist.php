<?php

use app\modules\WishList;
use app\connection\MySQL;
use app\connection\Connection;

ini_set('display_errors',1);
error_reporting(E_ALL);

define('DIR', str_replace('\\','/', dirname(__FILE__)));

require_once(DIR . '/config.php');
require_once(DIR . '/vendor/autoload.php');

$sql = ROOT.DATABASE_PATH;
$connection = new Connection(new MySQL);

$wishList = new WishList($connection);
$wishListProducts = $wishList->getProducts();

if(isset($_POST['deleteAllProducts'])) {
    $wishList->removeAllProducts();

    return $wishListProducts;
}

if(isset($_POST['removeProduct'])) {
    $wishList->removeProduct($_POST['product']);
}

if(isset($_POST['product']) && isset($_POST['image']) && isset($_POST['price'])) {
    $wishList->addProduct($_POST['product'], $_POST['image'], 1, $_POST['price']);
    $wishListProducts = $wishList->getProducts();
    $wishQuantity = count($wishListProducts);
    return print($wishQuantity);
}

require_once 'view/wishlist.php';
