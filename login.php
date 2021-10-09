<?php
session_start();
if($_SERVER['REQUEST_METHOD']=='POST'){
    $password_db = "12345";
    $conn = mysqli_connect("localhost","root",$password_db,"blog");
    if(!$conn){
        echo mysqli_connect_error();
        exit;
    }

    $email = mysqli_escape_string($conn,$_POST['email']);
    $password = sha1($_POST['password']);

    $query = "SELECT * FROM users WHERE email = '".$email."' and password = '".$password."' LIMIT 1";
    $result = mysqli_query($conn,$query);

    if($row = mysqli_fetch_assoc($result)){
        $_SESSION['id']=$row['id'];
        $_SESSION['email']=$row['email'];
        header("Location: admin/users/list.php");
        exit;
    }else{
        $error = "Invalid email or password!";
    }
    mysqli_free_result($result);
    mysqli_close($conn);
}

?>
<html>
    <head>
        <title>Login form</title>
    </head>
    <body>
        <?php if(isset($error)) echo $error; ?>
        <form method="POST">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= (isset($_POST['email']))?$_POST['email']:'' ?>"><br>
            <label for="password">Password</label>
            <input type="password" name="password" id="password"><br>
            <input type="submit">
        </form>
    </body>
</html>