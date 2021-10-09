<?php

// Create connection
$password_db = "12345";
$conn = mysqli_connect("localhost","root",$password_db,"blog");
if(!$conn){
    echo mysqli_connect_error();
    exit;
}

$query = "SELECT * FROM users";
$result = mysqli_query($conn,$query);
while($row = mysqli_fetch_assoc($result)){
    echo "ID: ".$row['id']."<br>";
    echo "Name: ".$row['name']."<br>";
    echo "Email: ".$row['email']."<br>";
    if($row['admin']==1){
        echo "Admin<br>";    
    }
    echo str_repeat("-",50)."<br>";
}

mysqli_free_result($result);
mysqli_close($conn);
?>