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
