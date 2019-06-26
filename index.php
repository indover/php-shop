<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

use app\modules\Cart;
use app\modules\WishList;

use app\connection\MySQL;
use app\connection\MyRedis;
use app\connection\Connection;

use app\Parser\ParseCSV;

define('DIR', str_replace('\\','/', dirname(__FILE__)));

require_once(DIR . '/config.php');

require_once(DIR . '/vendor/autoload.php');

$parse = new ParseCSV();
$array = $parse->parse();

$redis = new MyRedis();
$redisConn = new Connection($redis);

$cart = new Cart($redisConn);
$cartProducts = $cart->getTotalQuantity();

$sql = new MySQL();
$sqlConn = new Connection($sql);

$wishList = new WishList($sqlConn);
$wishListProducts = $wishList->getProducts();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>bla-bla-bla</title>
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="row">
        <div class="col-xs-12 text-center">
            <h4>
                <a href="product.php" class="glyphicon glyphicon-shopping-cart" style="padding-right: 200px"> Cart (<span id="cart-count"><?= $cartProducts; ?></span>)</a>
                <a href="wishlist.php" class="glyphicon glyphicon-heart">Wish List (<span id="wishlist-count"><?=count($wishListProducts); ?></span>)</a>
                <hr>
            </h4>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th><td>Action</td></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($array as $key => $value): ?>
                        <tr>
                            <td class="product-id" data-id="<?= $key; ?>"><?= $key; ?></td>
                            <td class="product-name" style="text-align: center; padding: 5px; font-size: large"><?= $value['name']; ?></td>
                            <td class="product-price" style="text-align: center; padding: 5px; font-size: large"><?= $value['price']; ?></td>
                            <td class="product-image" >
                                <a href="<?= $value['image']; ?>">
                                    <img style="width:100px; height:100px; text-align: center" src="<?= $value['image']; ?>"/>
                                </a>
                            </td>
                                <td><button class="add-to-cart btn btn-primary">Buy</button></td>
                                <td><button class="add-to-wish btn btn-info">Add to Wishlist</button></td>
                        <?php endforeach; ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

<script>

    $(document).ready(function() {

        $('tbody').on('click', '.add-to-cart', function () {
            var product = $(this).closest('tr').find('.product-name').text();
            var price   = $(this).closest('tr').find('.product-price').text();
            var image   = $(this).closest('tr').find('img').attr('src');
            $.ajax({
                url: 'product.php',
                data: { product: product, quantity: 1, price: price, image: image },
                type: "POST",
                dataType: "JSON",
                success: function (response) {
                    $("#cart-count").text(response);
                }
            })
        });

        $('tbody').on('click', '.add-to-wish', function () {
            var product = $(this).closest('tr').find('.product-name').text();
            var price   = $(this).closest('tr').find('.product-price').text();
            var image   = $(this).closest('tr').find('img').attr('src');
            $.ajax({
                url: 'wishlist.php',
                data: { product: product, quantity: 1, price: price, image: image },
                type: "POST",
                dataType: "JSON",
                success: function (response) {
                    $("#wishlist-count").text(response);
                }
            })
        });
    });

    function cc(data){
        console.log('Dump: ', data);
    }

</script>
</html>