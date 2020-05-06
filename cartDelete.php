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
 if(isset($_POST['delete']))
 {
    $id = $_POST['delete'];
    $deleteQuery = "DELETE FROM user_cart WHERE cart_id = :id";
    $stmt = $db->prepare($deleteQuery);
    $stmt->bindValue(':id', $id);
 
    $stmt->execute();
    header("location: cart.php");
 }

?>
