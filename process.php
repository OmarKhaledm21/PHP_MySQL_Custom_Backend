<?php
    //Validation
    $error_field = array();
    if(! (isset($_POST['name']) && !empty($_POST['name']))){
        $error_field[]="name";
    }
    if(! (isset($_POST['email']) && filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL))){
        $error_field[]="email";
    }
    if(! (isset($_POST['password']) && strlen($_POST['password'])>5)){
        $error_field[]="password";
    }

    if($error_field){
        header("Location: form.php?error_field=".implode(",", $error_field));
    }
    
// Create connection
$password_db = "12345";
$conn = mysqli_connect("localhost","root",$password_db,"blog");
if(!$conn){
    echo mysqli_connect_error();
    exit;
}

$name = mysqli_escape_string($conn,$_POST['name']);
$email = mysqli_escape_string($conn,$_POST['email']);
$password = sha1($_POST['password']);

$insert_query = "INSERT INTO users (name,email,password) VALUES ('".$name."','".$email."','".$password."')";
if(mysqli_query($conn,$insert_query)){
    echo "Thank you!, your information has been saved!<br>";
}else{
    echo $insert_query;
    echo mysqli_error($conn);
}

mysqli_close($conn);