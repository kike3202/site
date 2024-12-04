<?php 

session_start();

if ( isset($_POST['cancel'] ) ) {
 
    header("Location: index.php");
    return;
}



$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  

if ( isset($_POST['who']) && isset($_POST['pass']) ) {
  unset($_SESSION["who"]);
  $who = htmlentities($_POST['who']); 
  $pass = htmlentities($_POST['pass']);
    if ( strlen($who) < 1 || strlen($pass) < 1 ) {
        $_SESSION['error'] = "User name and password are required";
    } 

    elseif (filter_var($who, FILTER_VALIDATE_EMAIL)) {

      $check = hash('md5', $salt.$pass);
      if ( $check == $stored_hash ) {
        $_SESSION["who"] = $_POST["who"];
        $_SESSION["success"] = "Logged in.";

        try {
          throw new Exception("Login success ".$who);
        }
        catch (Exception $ex) {
          error_log($ex->getMessage());
        }
        
    
        header("Location: view.php?name=".urlencode($who));
        return;
            
      } else {

          try {
            throw new Exception("Login fail ".$who." $check");
          }
          catch (Exception $e) {
            error_log($e->getMessage());
          }
          
          $_SESSION["error"] = "Incorrect password.";
          header("Location: autos.php");
          return;

      }
      
    }
    
    else {
        $_SESSION['error'] = "Email must have an at-sign (@)";
    }    
}


?>
<!DOCTYPE html>
<html>
<head>

<style>
   body{
        margin: 0px auto;
        background-color: grey;
    }
  .container{
  

    border: solid black 2px;
    background-color: white;
        padding: 10px;
        margin: 100px auto;
        width: 400px;
        position: relative;
        text-align: center;
  }
  form{
    
        position: relative;
       
    }
    input{
        padding: 10px;
        width: 380px;
    }
    input[type="submit"]{
        border: 0px;
        background-color: #ed8824;
        padding: 10px 20px;
        width: 120px;
      position: relative;
      left: 0%;
      top: 10px;
    }
</style>

<title>Aplicacion PHP Johan</title>


</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php

if ( isset($_SESSION["error"]) ) {
      echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
      unset($_SESSION["error"]);
  }

if ( isset($_SESSION["success"]) ) {
    echo('<p style="color:green">'.$_SESSION["success"]."</p>\n");
    unset($_SESSION["success"]);
}
?>
<form method="POST">
<label for="nam">Email</label>
<input type="text" name="who" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="pass" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
PHP Login Johan.

</p>
</div>
</body>



