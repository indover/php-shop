<?php

ini_set('display_errors',1);
error_reporting(E_ALL);
?>

<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>Wish List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>

</head>
    <body>
    <h2>Wish List</h2>
    <div class="row">
        <div class="col-xs-12">
            <div class="col-xs-2 text-left">
                <a href="/" class="glyphicon glyphicon-shopping-cart"> <h4>Back to products</h4></a>
            </div>
            <div class="col-xs-10 text-right">
                <button type="submit" name="removeAllProducts" id="removeAllProducts" class="removeAllProducts glyphicon glyphicon-trash btn btn-danger" > Empty WishList</button>
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
                            <th>Price</th>
                            <td>Remove</td>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($wishListProducts as $value): ?>
                                <tr class="products">
                                    <td class="product-name"><?= $value['name']; ?></td>
                                    <td class="" style="text-align: center"> <a href="<?php echo $value['image']; ?>">
                                            <img style="width:100px; height:100px;" src="<?php echo $value['image']; ?>"/>
                                        </a>
                                    </td>
                                    <td style="text-align:right;"><?= $value["price"]; ?></td>
                                    <td style="text-align:center;">
                                        <button type="submit" name="btnDeleteProduct" class="btnDeleteProduct glyphicon glyphicon-trash btn btn-danger"></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('tbody').on('click', '.btnDeleteProduct', function () {
                var self = this;
                var product = $(this).closest('tr').find('.product-name').text();
                $.ajax({
                    url: '../wishlist.php',
                    data: { product: product, removeProduct: 1 },
                    type: "POST",
                    success: function () {
                        $(self).closest('tr').remove();
                    }
                })
            });

            $('body').on('click', '#removeAllProducts', function () {
                $.ajax({
                    url: '../wishlist.php',
                    data: { deleteAllProducts: 1 },
                    type: "POST",
                    success: function () {
                        $('table').find('.products').remove();
                    }
                });
            });
        });
    </script>
    </body>
</html>

