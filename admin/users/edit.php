<?php
$error_fields = array();

//Connection to db
$password_db = "12345";
$conn = mysqli_connect("localhost","root",$password_db,"blog");
if(!$conn){
    echo mysqli_connect_error();
    exit;
}

//Select user
//edit.php?id=1  => $_GET['id']
$id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$select = "SELECT * FROM users WHERE users.id =".$id." LIMIT 1";
$result = mysqli_query($conn,$select);
$row = mysqli_fetch_assoc($result);

if($_SERVER['REQUEST_METHOD']=='POST'){
    if(! (isset($_POST['name']) && !empty($_POST['name'])) ){
        $error_fields[]="name";
    }

    if(! (isset($_POST['email']) && filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL))){
        $error_fields[]="email";
    }    
    if(!$error_fields){
        $id = filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
        $name = mysqli_escape_string($conn,$_POST['name']);
        $email = mysqli_escape_string($conn,$_POST['email']);
        $password = (! empty($_POST['password']))? sha1($_POST['password']): $row['password'];
        $admin = (isset($_POST['admin']))?1:0;
        $query = "UPDATE users SET name = '".$name."', email ='".$email."', password = '".$password."', admin = ".$admin." WHERE users.id = ".$id;
        if(mysqli_query($conn,$query)){
            header("Location: list.php");
            exit;
        }else{
            echo mysqli_error($conn);
        }
    }
}
mysqli_free_result($result);
mysqli_close($conn);
?>
<html>
    <head>
        <title>Admin :: Edit User</title>
    </head>
    <body>
        <form method="POST">
            <label for="name">Name</label>
            <input type="hidden" name="id" id="id" value="<?= (isset($row['id'])) ? $row['id'] : '' ?>">
            
            <input type="text" name="name" id="name" value="<?= (isset($row['name']))?$row['name']:'' ?>"><?php
                if(in_array("name",$error_fields)) echo "**Please enter your name!";
            ?>
            <br>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= (isset($row['email']))?$row['email']:'' ?>"><?php
                if(in_array("email",$error_fields)) echo "**Please enter a valid email";
            ?>
            <br>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" value="<?= (isset($row['password']))?$row['password']:'' ?>"><?php
                if(in_array("password",$error_fields)) echo "**Please enter your password (Not less than 6 characters)!";
            ?>
            <br>
            <input type="checkbox" name="admin" id="admin" <?= ($row['admin']==1)?'checked':'' ?>/>Admin<br/>
            <input type="submit" name="submit" value="Edit User">
        </form>
    </body>
</html>