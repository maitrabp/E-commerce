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
    //Get featured products
    function getFeaturedProducts($db)
    {
        $featured = "SELECT * FROM products where featured = 1;";
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
        <br/><br/>
        <div class = container>
            <form action = "addProducts.php" method = "POST" enctype = "multipart/form-data">
                <div class="form-group">
                    <label for="brand">Brand: </label>
                    <input type="text" class="form-control" name = "brand" id="brand" placeholder="What brand is your product?">
                </div>
                <div class="form-group">
                    <label for="itemType"> Item-Type:</label>
                    <select name = "itemType" class="form-control" id="itemType">
                      <option value = "Clothing">Clothes</option>
                      <option value = "Shoes">Shoes</option>
                      <option value = "Sport Equipments">Sport Equipments</option>
                      <option value = "Accessories">Accessories</option>
                    </select>
                </div>
                <div class="form-group">
                    <div class="form-group">
                        <label for="productname">Product-name: </label>
                        <input type="text" class="form-control" name = "item_name" id="item_name" placeholder="What is the name of your item? [Without the brand]">
                    </div>
                </div>
                <div class="form-group">
                    <label for="featured"> Featured on home-page:</label>
                    <select name = "featured" class="form-control" id="featured">
                      <option value =  '1'>Yes</option>
                      <option value =  '0' selected>No</option>
                    </select>
                </div>
                <div class="form-group" id="anotherField">
                    <div class = "form-group">
                        <label for="list-price">List-Price</label>
                        <input type="number" class="form-control" name = "list_price" step="0.01" id="list-price" placeholder = "What is the actual price of the product on market?">
                    </div>
                </div>
                <script type = "text/javascript">
                    $("#featured").change(function() {
                     if ($(this).val() == "1") {
                        $('#anotherField').show();
                    } else {
                        $('#anotherField').hide();
                    }
                    });
                    $("#featured").trigger("change");
                </script>
                <div class="form-group">
                    <label for="price">Price: </label>
                    <input type="number" class="form-control" name = "price" step="0.01" id="price" placeholder="What is the price of the item on website?">
                </div>
                <div class="form-group">
                    <label for="image">Insert product image here:</label>
                    <input type="file" name = "itemimage" class="form-control-file" id="itemimage">
                </div>
                <div class="form-group">
                    <label for="description">Item-Description:</label>
                    <textarea name = "description" class="form-control" id="description" rows="3"></textarea>
                </div>
                <button type="submit" name = "submit" class="btn btn-primary">Add Product</button>
            </form>
        </div>
    </body>
</html>
<?php 
    if(isset($_POST['submit']))
    {
        $brand = $_POST['brand'];
        $itemType = $_POST['itemType'];
        $itemname = $_POST['item_name'];
        $featured = $_POST['featured'];
        if($featured == '1')
        {
            $list_price = $_POST['list_price'];
        }
        else{
            $list_price = '0';
        }
        $price = $_POST['price'];
        $desc = $_POST['description'];
        //Image Upload
        $img = "img/" . $_FILES['itemimage']['name'];
        //put img in the query then upload actual image through code below

        $products = "INSERT INTO products (brand, itemType, item_name, list_price, price, description, image, featured) VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $db->prepare($products);
        $stmt->execute([$brand, $itemType, $itemname, $list_price, $price, $desc, $img, $featured]);
        move_uploaded_file($_FILES['itemimage']['tmp_name'], "$img");
        echo("<script type = 'text/javascript'>alert('New product has been added!')</script>");
    }
?>

