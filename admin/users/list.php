<!DOCTYPE html>
<?php
session_start();

if(isset($_SESSION['id'])){
    echo '<p>Welcome '.$_SESSION['email'].' <a href="/logout.php">Logout</a></p>';
}else{
    header("Location: /login.php");
    exit;
}

$password_db = "12345";
$conn = mysqli_connect("localhost","root",$password_db,"blog");
if(!$conn){
    echo mysqli_connect_error();
    exit;
}

$query = "SELECT * FROM users";

if(isset($_GET['search'])){
    $search = mysqli_escape_string($conn,$_GET['search']);
    $query.=" WHERE users.name LIKE '%".$search."%' OR users.email LIKE '%".$search."%'";
}

$result = mysqli_query($conn,$query);
?>
<html>
    <head>
        <title>
            Admin :: List Users
        </title>
    </head>
    <body>
        <h1>List Users</h1>
        <form method="GET">
            <input type="text" name="search" placeholder="Enter {Name} or {Email} to search">
            <input type="submit" value="search"> 
        </form>
        
        <br>
        <!-- Displaying all users -->
        <table>
            <thead>    
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Admin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while($row = mysqli_fetch_assoc($result)){ ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= ($row['admin']) ? 'Yes':'No' ?></td>
                        <td><a href="edit.php?id=<?=$row['id']?>">Edit</a> | <a href="delete.php?id=<?=$row['id']?>">Delete</a></td> 
                    </tr>
            <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="text-align: center;"><?= mysqli_num_rows($result) ?> users</td>
                    <td colspan="3" style="text-align: center;"><a href="add.php">Add User</a></td>
                </tr>
            </tfoot>
        </table>





    </body>
</html>
<?php 
mysqli_free_result($result);
mysqli_close($conn);
?>