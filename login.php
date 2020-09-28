<?php 
    if(!isset($_SESSION))
    {
        session_start();
    }
    else{
        clearstatcache();
        $this->cache->clean();
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

    //Authentication
    if(isset($_POST['submit']))
    {
        //Add validations later
        $username = $_POST['username'];
        $password = $_POST['password'];
        $loginSQL = "SELECT * FROM user where username = '$username'";
        $result = $db->query($loginSQL)->fetch();
        if($result)
        {
            if($result['password'] == $password)
            {
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['name'] = $result['name'];
                header("location:index.php");
            }
            else{
                $passwordErr = "Incorrect Password, Try again or change password!";
            }
        }
        else{
            $usernameErr = "Username does not exist, you must create a new account first!";
        }
    }
?>
<!DOCTYPE html>
<!--CHECK NO SESSION IS OPEN--->
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Vogue - Login</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<style type="text/css">
	.login-form {
		width: 400px;
    	margin: 100px auto;
	}
    .login-form form {
    	margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
    .login-form h2 {
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
    #usernameError, #passwordError {
        color: red;
        font-family: Arial, Helvetica, sans-serif;
    }
</style>
</head>
<body>
<div class="login-form">
        <form action="login.php" method="post">
            <h2 class="text-center">Log in</h2>       
            <div class="form-group">
                <input type="text" name = "username" class="form-control" placeholder="Username" required="required" autocomplete = "off"><br/>
                <span id = "usernameError"><?=$usernameErr?></span>
            </div>
            <div class="form-group">
                <input type="password" name = "password" class="form-control" placeholder="Password" required="required"><br/>
                <span id = "passwordError"><?=$passwordErr?></span>
            </div>
            <div class="form-group">
                <button type="submit" name = "submit" class="btn btn-primary btn-block">Log in</button>
            </div>
            <div class="clearfix">
                <a href="passwordChange.php">Forgot Password?</a>
            </div>   
        </form>
        <p class="text-center"><a href="register.php">Create an Account</a></p>
    </div>
    </body>
</html>                              		                            