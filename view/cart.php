<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

?>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
</head>
<body>
    <h2>Shoping Cart</h2>
    <div class="row">
        <div class="col-xs-12">
            <div class="col-xs-2 text-left">
                <a href="/" class="glyphicon glyphicon-shopping-cart"> <h4>Back to products</h4></a>
            </div>
            <div class="col-xs-10 text-right">
            <button type="submit" name="removeAllProducts" id="removeAllProducts" class="removeAllProducts glyphicon glyphicon-trash btn btn-danger" > Empty Cart</button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <td>Remove</td>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $totalQuantity = 0; $totalPrice = 0; ?>
                            <?php foreach ($cartProducts as $key => $value): ?>
                                <tr class="products">
                                    <td class="product-name"><?= $value['product']; ?></td>
                                    <td style="text-align: center"> <a href="<?= $value['image']; ?>">
                                            <img style="width:100px; height:100px;" src="<?= $value['image']; ?>"/>
                                        </a>
                                    </td>
                                    <td style="text-align:center;">

                                        <a href="#">
                                            <span class="glyphicon glyphicon-minus"></span>
                                        </a>
                                        <span class="product-quantity"><?= $value["quantity"]; ?></span>
                                        <a href="#">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </a>
                                    </td>
                                    <td style="text-align:right;"><?= $value["price"]; ?></td>
                                    <td style="text-align:center;">
                                        <button type="submit" name="btnDeleteProduct" class="btnDeleteProduct glyphicon glyphicon-trash btn btn-danger"></button>
                                    </td>
                                </tr>
                                <?php $totalQuantity += $value["quantity"]; ?>
                                <?php $totalPrice += $value["price"] * $value["quantity"]; ?>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="1" align="left">Total:</td>
                                <td align="right" colspan="1">Quantity:</td>
                                <td align="center" class="totalQuantity"><?= $totalQuantity ?></td>
                                <td align="right" colspan="1">Price:</td>
                                <td><strong class="totalAmount"><?= $totalPrice?></strong></td>
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

        $('tbody').on('click', '.btnDeleteProduct', function () {
            var self = this;
            var product = $(this).closest('tr').find('.product-name').text();
            $.ajax({
                url: '../product.php',
                data: { product: product, removeProduct: 1 },
                type: "POST",
                success: function () {
                    $(self).closest('tr').remove();
                    updateAmount();
                }, error: function () {
                    cc('ERROR');
                }
            })
        });

        $('body').on('click', '#removeAllProducts', function () {
            $.ajax({
                url: '../product.php',
                data: { deleteAllProducts: 1 },
                type: "POST",
                success: function () {
                    $('table').find('.products').remove();
                    updateAmount();
                }
            });
        });

        $('body').on('click', '.glyphicon-plus', function () {
            var self = this;
            var product = $(this).closest('tr').find('.product-name').text();
            $.ajax({
                url: '../product.php',
                data: { increaseProductQuantity: 1 , product: product },
                type: "POST",
                success: function (res) {
                    $(self).closest('tr').find('.product-quantity').text(res);
                    updateAmount();
                }
            });
        });

        $('body').on('click', '.glyphicon-minus', function () {
            var self = this;
            var product = $(this).closest('tr').find('.product-name').text();
            $.ajax({
                url: '../product.php',
                data: { decreaseProductQuantity: 1 , product: product },
                type: "POST",
                success: function (res) {
                    $(self).closest('tr').find('.product-quantity').text(res);
                    updateAmount();
                    if ($(self).closest('tr').find('.product-quantity').text(res).text() == 0) {
                        $(self).closest('tr').remove();
                        updateAmount();
                    }
                }
            });
        });

    function updateAmount (){
            $.ajax({
                url: '../product.php',
                data: { updateAmount: 1 },
                type: "POST",
                dataType: "JSON",
                success: function (total) {
                    $('.totalAmount').text(total.total);
                    $('.totalQuantity').text(total.quantity);
                }, error: function () {
                    cc('ERROR');
                }

            })
        }
    });

    function cc(data){
        console.log('Dump:   ', data);
    }

</script>
</html>

