<?php 
session_start();
//DB Connection
$usernameErr = "";
$passwordErr = "";
$dsn = 'mysql:host=us-cdbr-east-02.cleardb.com;dbname=heroku_28271986dd16416';
$user = 'b79f790f3ee1bd';
$password = '24f9e469';
try {
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
if(empty($_SESSION)) {
        header('Location: login.php');
    }
function getCartItems($db) {
    $username = $_SESSION['username'];
    $items = "SELECT * FROM user_cart, products where products.id = user_cart.id_lookup and user_cart.username = '$username'";
    $cartItems = $db->query($items);
    return $cartItems;
}
function getCartTotal($db)
{
    $username = $_SESSION['username'];
    $items = "SELECT SUM(total_price) as total_price FROM user_cart where user_cart.username = :username";
    $cartTotal = $db->prepare($items);
    $cartTotal->bindValue(':username', $username);
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
            <a href = "index.php" class = "navbar-brand" id = "text">Vog Shop </a>
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
    <h1 id = "text2"><?=$_SESSION['name']?>'s <span class = "glyphicon glyphicon-shopping-cart"></span>Shopping Cart</h1>
    <?php 
        $cart = getCartItems($db);
        if($cart->rowCount() > 0){ ?>
            <div class = "container">
            <table class = "table table-hover">
                <thead id = "tableHead">
                    <tr>
                        <th><b>Item</b></th>
                        <th>Quantity</th>
                        <th>Size</th>
                        <th>Qty-Price</th>
                        <th>Don't want?</th>
                    </tr>
                </thead>
                <tbody>
                <!--PHP here-->
                <?php 
                        foreach($cart as $cartItem)
                        {
                            $itemName = $cartItem['brand'] . $cartItem['item_name'];
                            $price = number_format($cartItem['total_price'], 2, '.', ',');
               
                            echo "<tr>
                                    <th>". $itemName . " <br/><img src = '" . $cartItem['image'] . "' id = 'cartImages'/></th>
                                    <th>". $cartItem['quantity'] . "</th>
                                    <th>". $cartItem['size']. " </th>
                                    <th> $ " . $price. "</th>
                                    <th><form action = 'cartDelete.php' method = 'POST'><button type='submit' name = 'delete' value = '" .$cartItem['cart_id']. "' class='btn btn-danger'>Remove</button></form></th>
                                  </tr>";
                        }
                        $total_price = getCartTotal($db);
                        $total = number_format($total_price['total_price'], 2, '.', ',')
                ?>
                        </tbody>
                        </table>
                        <h3 class = "alert alert-success text-center"><b>Total:</b> $ <?php echo($total);?></h2>
                        <form action = "purchase.php" method = "post">
                            <div class = "container text-center">
                                <button type='submit' name = 'purchase' value = "<?=$_SESSION['username'];?>" class='btn btn-warning'>Buy All Items</button></form>
                            </div>
                        </form>
                    </div> <?php }
                    else{ ?>
                        <div class = "container">
                            <div class = "alert alert-danger text-center">
                                <p>There are no items in your cart!</p>
                            </div>
                        </div>
                    <?php }?>
</body>
</html>