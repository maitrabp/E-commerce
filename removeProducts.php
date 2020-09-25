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
    //Get featured products
    function getProducts($db)
    {
        $featured = "SELECT * FROM products";
        $products = $db->query($featured);
        return $products;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title> Shop - Vog </title>
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
                        <a href = "index.php" class = "dropdown-toggle" data-toggle="dropdown" style = "margin-left: 10px" id="text"> Products <span class = "caret"></span></a>
                        <ul class = "dropdown-menu" role="menu">
                            <li><a href="clothes.php" id = "text2"> Clothes </a></li>
                            <li><a href="shoes.php" id = "text2"> Shoes </a></li>
                            <li><a href="accessories.php" id = "text2"> Accessories </a></li>
                            <li><a href="sportsequipments.php" id = "text2"> Sport Equipments </a></li>
                        </ul>
                    </li>
                    <li><a href = "search.php" class = "navbar-brand" id = "text" style="margin-left:10px"><span class = "glyphicon glyphicon-search"></span> Search</a></li>
                    <li class = "dropdown" style="margin-left: 350px">
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
                    <li><a href = "cart.php" class = "navbar-brand" id = "text" style="margin-left:10px"><span class = "glyphicon glyphicon-shopping-cart"></span> Cart</a></li>
                </ul>
            </div>
        </nav>
        <h1 id = "text2">Remove Products From Website</h1>
    <?php 
        $products = getProducts($db);
        if($products->rowCount() > 0){ ?>
            <div class = "container">
            <table class = "table table-hover">
                <thead id = "tableHead">
                    <tr>
                        <th><b>Item</b></th>
                        <th>Item Type</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Don't want?</th>
                    </tr>
                </thead>
                <tbody>
                <!--PHP here-->
                <?php 
                        foreach($products as $product)
                        {
                            $itemName = $product['brand'] . $product['item_name'];
                            $price = number_format($product['price'], 2, '.', ',');
                            //WORK ON REMOVE BUTTON watch this video https://www.youtube.com/watch?v=KljAKbOAY6M
                            echo "<tr>
                                    <th>". $itemName . " <br/><img src = '" . $product['image'] . "' id = 'cartImages'/></th>
                                    <th>". $product['itemType'] . "</th>
                                    <th>". $product['description']. " </th>
                                    <th> $". $price. "</th>
                                    <th><form action = 'itemRemove.php' method = 'POST'><button type='submit' name = 'remove' value = '" .$product['id']. "' class='btn btn-danger'>Remove</button></form></th>
                                  </tr>";
                        }
                ?>
                        </tbody>
                        </table>
                    </div> <?php }
                    else{ ?>
                        <div class = "container">
                            <div class = "alert alert-danger text-center">
                                <p>There are no items on the website!</p>
                            </div>
                        </div>
                    <?php }?>
</body>
</html>
