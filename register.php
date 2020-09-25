<?php 
    if(!isset($_SESSION))
    {
        session_start();
    }
    else{
        session_unset();
        session_destroy();
        session_start();
    }
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
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Vogue - Register</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<style type="text/css">
	.registration-form {
		width: 400px;
    	margin: 100px auto;
	}
    .registration-form form {
    	margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
    .registration-form h2 {
        margin: 0 0 15px;
        color: black; 
        font-weight: bold;
    }
    .form-control, .btn {
        min-height: 38px;
        border-radius: 25px;
    }
    .btn {        
        font-size: 15px;
        font-weight: bold;
        background-color: black;
        color: white;
        border: none;
    }
    .btn:hover{
        background-color: skyblue;
    }
</style>
</head>
<body>
<div class="registration-form">
        <form action="register.php" method="POST">
            <h2 class="text-center">Register</h2>       
            <div class="form-group">
                <input type="text" class="form-control" name = "name" placeholder="Name" required/>
            </div>
            <div class="form-group">
            <input type="tel" class = "form-control" name="telephone" placeholder="Phone number"  maxlength="12"  title="Ten digits" required/>
            </div>
            <div class="form-group">
                <input type="email" class = "form-control" placeholder = "Email" name="email"  required/> 
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name = "username" placeholder="Choose Username" required/>
            </div>
            <div class="form-group">
                <input type="password" class="form-control"  name = "password" placeholder="Choose Password" required/>
            </div>
            <div class="form-group">
                <button type="submit" name = "submit" class="btn btn-primary btn-block">Create an Account</button>
            </div>
        </form>
        <p class="text-center"><a href="login.php">Back to Login</a></p>
    </div>
    </body>
</html>        
<?php
    if(isset($_POST['submit']))
    {
        //Add validations later..
        $name = $_POST['name'];
        $phone = $_POST['telephone'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $registerSQL = "INSERT INTO user (name, username, email, phone, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($registerSQL);
        $stmt->execute([$name, $username, $email, $phone, $password]);
        
        header("location: login.php");
    }
?>