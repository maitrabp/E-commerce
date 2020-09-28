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
    function getFeaturedProducts($db, $searchText)
    {
        $search = "SELECT * FROM products where brand LIKE '%$searchText%' OR itemType LIKE '%$searchText%' OR item_name LIKE '%$searchText%' OR price LIKE '%$searchText%' OR description LIKE '%$searchText%';";
        $products = $db->query($search);
        return $products;
    }
    if(empty($_SESSION)) {
        session_unset();
        header('Location: login.php');
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
    <br>
    <form action="search.php" method="post"> 
        <div class = "outsidecentered">
            <div class="row">
                <div class="col-xs-6 col-md-6">
                    <div class="input-group">
                        <input type="text" name = "searchtext" class="form-control" placeholder="Search" id="txtSearch"/>
                        <div class="input-group-btn">
                            <button class="btn btn-black" name = "search" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class = "col-md-2"></div>
        <div class = "col-md-8">
            <div class = "row">
                <!--Dynamically display featured products-->
                <?php 
                if(isset($_POST['search'])) {
                    $products = getFeaturedProducts($db, $_POST['searchtext']);
                    foreach($products as $product) {
                        $productName = $product['brand'] . ' ' . $product['item_name'];
                        $price = number_format($product['price'], 2, '.', ',');
                        if($product['list_price'] != '0') {
                            $listPrice = number_format($product['list_price'], 2, '.', ',');
                        }
                ?>
                <div class = "col-md-3">
                    <h4 id = "text3"><?=$productName?></h4>
                    <img src = "<?= $product['image'];?>" alt = "<?= $productName;?>" id="images"/>
                    <?php 
                    if($product['list_price'] != '0') { ?>
                        <p class = "list-price text-danger">List-Price: <s><?=" $" . $listPrice;?></s></p>
                    <?php } ?>
                    <p class = "price"><b>Price:<?= " $" . $price;?></b></p> 
                    <button type = "button" class = "btn homepageButton" data-toggle = "modal" data-target = '<?php echo("#" . $product['id']);?>'>Details</button>
                </div> <!--md3 close-->
            <div class = "modal fade <?php echo($product['id']);?>" id = "<?php echo($product['id']);?>" tableindex = "-1" role = "dialog" aria-labelledby = "<?php echo($product['id']);?>" aria-hidden="true">
                <div class = "modal-dialog modal-lg">
                    <div class = "modal-content">
                        <div class = "modal-header">
                            <button class = "close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title text-center" id="text3"><?=$productName;?></h4>
                        </div>
                        <div class = "modal-body">
                            <div class = "container-fluid">
                                <div class = "row">
                                    <div class = "col-sm-6">
                                        <div class = "center-block">
                                            <img src = "<?=$product['image'];?>" alt="<?=$productName;?>" class = "details img-responsive"/>
                                        </div>
                                    </div>
                                    <div class = "col-sm-6">
                                        <h4><b>Details</b></h4>
                                        <p><?=$product['description'];?></p>
                                        <hr/>
                                        <p style = "color:maroon">Price: <?=$product['price'];?></p>
                                        <p style = "color:maroon">Brand: <?=$product['brand'];?></p>
                                        <form action = "index.php" method = "post">
                                            <div class="form-group">
                                                <div class="col-xs-3">
                                                    <label for="quantity" id="quantity-label" style = "color:maroon; margin-left: -15px">Quantity: </label>
                                                    <input type="number" min = "1" style = "margin-left: -15px" class="form-control" id="quantity" name="quantity"/>
                                                </div> <br/><br/><br/>
                                                <?php if($product['itemType'] !== 'Sport Equipments') {?>
                                                <div class="form-group">
                                                    <label for="size" id = "size-label" style = "color:maroon">Size: </label>
                                                    <select name = "size" id = "size" class = "form-control">
                                                        <option value = ""></option>
                                                        <option value = "XS">XS</option>
                                                        <option value = "S">S</option>
                                                        <option value = "M">M</option>
                                                        <option value = "L">L</option>
                                                        <option value = "XL">XL</option>
                                                        <option value = "XXL">XXL</option>
                                                    </select>
                                                </div>
                                                <?php } ?>
                                                <button class = "btn btn-warning" value = "<?=$product['id']?>" name = "cart" type="submit"><span class = "glyphicon glyphicon-shopping-cart"></span>Add To Cart</button>
                                            </div>
                                        </form>
                                        <?php 
                                            if(isset($_POST['cart']) && ($_POST['cart'] == $product['id']))
                                            {
                                                if($product['itemType'] != 'Sport Equipments')
                                                {
                                                    $quantity = $_POST['quantity'];
                                                    $size = $_POST['size'];
                                                    $total_price = $_POST['quantity'] * $product['price'];
                                                    $cart = "INSERT INTO user_cart (username, id_lookup, quantity, total_price, size) VALUES (?,?,?,?,?)";
                                                    $stmt = $db->prepare($cart);
                                                    $stmt->execute([$_SESSION['username'], $product['id'], $_POST['quantity'], $total_price, $_POST['size']]);
                                                    echo ("<script type = 'text/javascript'>alert('$quantity $size $productName added to your cart!')</script>");
                                                }
                                                else{
                                                    $quantity = $_POST['quantity'];
                                                    $total_price = $_POST['quantity'] * $product['price'];
                                                    $cart = "INSERT INTO user_cart (username, id_lookup, quantity, total_price) VALUES (?,?,?,?)";
                                                    $stmt = $db->prepare($cart);
                                                    $stmt->execute([$_SESSION['username'], $product['id'], $_POST['quantity'], $total_price]);
                                                    echo ("<script type = 'text/javascript'>alert('$quantity $productName added to your cart!')</script>");
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "modal-footer">
                            <button class = "btn homepageButton" data-dismiss = "modal">Close</button>
                        </div>
                    </div>
                    </div>
                </div>  <!--row close-->
                <?php }
                } ?>
            </div>
        </div>
</body>
</html>