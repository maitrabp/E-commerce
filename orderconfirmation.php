<?php 
session_start();
   //DB Connection
   $usernameErr = "";
   $passwordErr = "";
   $dsn = 'mysql:host=127.0.0.1:3360;dbname=e-commerce';
   $user = 'root';
   $password = '';
   try {
       $db = new PDO($dsn, $user, $password);
       $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   } catch (PDOException $e) {
       echo 'Connection failed: ' . $e->getMessage();
   }
function getOrders($db) {
    $username = $_SESSION['username'];
    $confirmation = $_SESSION['confirmationNum'];
    $items = "SELECT orders.user_conf, products.brand, products.item_name, orders.quantity, orders.price FROM orders, products where products.id = orders.productid and orders.user = '$username' and orders.user_conf = '$confirmation'";
    $orderItems = $db->query($items);
    return $orderItems;
}
function getOrderTotal($db)
{
    $username = $_SESSION['username'];
    $userconf = $_SESSION['confirmationNum'];
    $items = "SELECT SUM(price) as total_price FROM orders where orders.user = :username AND orders.user_conf = :userconf";
    $cartTotal = $db->prepare($items);
    $cartTotal->bindValue(':username', $username);
    $cartTotal->bindValue(':userconf', $userconf);
    $cartTotal->execute();
    $row = $cartTotal->fetch(PDO::FETCH_ASSOC);
    return $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vog - Cart</title>
    <link rel = "stylesheet" href = "css/bootstrap.min.css"/>
    <link rel = "stylesheet" href = "css/main.css"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1, user-scaleable=no">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Lobster" />
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
    </script>
    <script src = "js/bootstrap.min.js"></script>
</head>
    <body>
    <nav class = "navbar navbar-default navbar-fixed-top" id = "navbar">
            <div class = "container">
                <a href = "/E-commerce/index.php" class = "navbar-brand" id = "text">Vog Shop </a>
                <ul class = "nav navbar-nav">
                <!--Drop Down Menu-->
                    <li class  = "dropdown">
                        <a href = "index.php" class = "dropdown-toggle" data-toggle="dropdown" id="text"> Products <span class = "caret"></span></a>
                        <ul class = "dropdown-menu" role="menu">
                            <li><a href="clothes.php" id = "text2"> Clothes </a></li>
                            <li><a href="shoes.php" id = "text2"> Shoes </a></li>
                            <li><a href="accessories.php" id = "text2"> Accessories </a></li>
                            <li><a href="sportsequipments.php" id = "text2"> Sport Equipments </a></li>
                        </ul>
                    </li>
                    <li class = "dropdown" style="margin-left: 400px">
                        <a href = "#" class = "dropdown-toggle" data-toggle="dropdown" id="text"> Welcome <?=$_SESSION['name']?> <span class = "caret"></span></a>
                        <ul class = "dropdown-menu" role="menu">
                            <?php if($_SESSION['username'] == 'admin')
                            { ?>
                            <li><a href="addProducts.php" id = "text2">Add Products</a></li>
                            <li><a href="removeProducts.php" id = "text2">Remove Products</a></li>
                            <?php } ?>
                            <li><a href="login.php" id = "text2"> Logout </a></li>
                            <li><a href="passwordChange.php" id = "text2"> Change Password </a></li>
                        </ul>
                    </li>
                    <li><a href = "cart.php" class = "navbar-brand" id = "text" style="margin-left:10px"><span class = "glyphicon glyphicon-shopping-cart"></span>Cart</a></li>
                </ul>
            </div>
        </nav>
    <h1 id = "text4"><?=$_SESSION['name']?>, your order has been placed! THANK YOU FOR SHOPPING WITH US!</h1>
    <h1 id = "text4"><b>Order Confirmation Number: <?=$_SESSION['confirmationNum']?></b></h1>
    <p id = "text3">Your purchase receipt: </p>
    <?php
        $orders = getOrders($db);
        foreach($orders as $order) { ?>
            <p style="text-align:center"><?=$order['brand'] . "   |   " . $order['item_name']. "   |   " . $order['quantity']. "   |   $ " . $order['price']?></p>
   <?php } 
        $total = 0.0;
        $total = getOrderTotal($db)['total_price'];
        $total = number_format($total, 2, '.', ',')?>
            <p style="text-align:center">Total:  $  <?=$total?></p>
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <button id = "shopmore" class="btn btn-success">Continue Shopping?</button>
                </div>
            </div>
        </div>
    <script>
        var btn = document.getElementById('shopmore');
        btn.addEventListener('click', function() {
            document.location.href = 'index.php';
        });
    </script>
</body>
</html>    