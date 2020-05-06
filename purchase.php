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
function getOrders($db)
{
        $featured = "SELECT COUNT(*) FROM user_orders;";
        $products = $db->query($featured);
        $num_rows = $products->fetchColumn();
        return $num_rows;
}
function getCartItems($db, $user)
{
    //test this
    $cartItems = "SELECT id_lookup, quantity, total_price FROM user_cart where user_cart.username = '$user';";
    $order = $db->query($cartItems);
    return $order;
}
 if(isset($_POST['purchase']))
 {
    $user = $_POST['purchase'];
    //store these item's into orders then delete
    $orderRows = getOrders($db);
    $confirmationNum = sprintf("%09d", $orderRows);
    $_SESSION['confirmationNum'] = $confirmationNum;
    $order = "INSERT INTO user_orders (username, order_conf) VALUES (?, ?)";
    $stmt = $db->prepare($order);
    $stmt->execute([$user, $confirmationNum]);

    //Now transfer all items from cart to the orders table!!!!
    $orders = getCartItems($db, $user);
    foreach($orders as $order )
    {
        $ordersQuery = "INSERT INTO orders (user, user_conf, productid, quantity, price) VALUES (?,?,?,?,?)";
        $orderStmt = $db->prepare($ordersQuery);
        $orderStmt->execute([$user, $confirmationNum, $order['id_lookup'], $order['quantity'], $order['total_price']]);

    }

    //Delete these items from cart
    $deleteQuery = "DELETE FROM user_cart WHERE  username = :user";
    $stmt = $db->prepare($deleteQuery);
    $stmt->bindValue(':user', $user);
    $stmt->execute();
    //Redirect to confirmation page!
    header("location: orderconfirmation.php");
 }

?>
