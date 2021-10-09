<!DOCTYPE html>
<?php
$errors_arr = array();
if(isset($_GET['error_field'])){
    $errors_arr = explode(",", $_GET['error_field']);
}
?>
<html>
    <head>
        <title>Registeration Form</title>
    </head>
    <body>
        
    <?php
        echo "<p>Now, it's ";
        echo date('H:i, jS F Y');
        echo "</p>";
    ?>
    
    <br>
    
    <form action="process.php" method="post">
        <label for="name">Name: </label>
        <input type="text" name="name" id="name"/><?php if(in_array("name",$errors_arr)) echo "Please enter your name"?>
        <br> 
        <label for="email">Email: </label>
        <input type="email" name="email" id="email"/><?php if(in_array("email",$errors_arr)) echo "Please enter your email"?>
        <br>
        <label for="password">Password: </label>
        <input type="password" name="password" id="password"/><?php if(in_array("password",$errors_arr)) echo "Please enter your password"?>
        <br>
        
        <label for="gender">Gender: </label>
        <input type="radio" name="gender" id="gender" value="Male"/>Male
        <input type="radio" name="gender" id="gender" value="Female"/>Female
   
        <input type="submit" name="submit" value="Register"/>
        
    </form>

    </body>
</html>