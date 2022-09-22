<?php
include("./genral/config.php");
include("./genral/functions.php");

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    // img
    $image_name = time() . $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $location = "./upload/$image_name";
    

    $select = mysqli_query($conn, "SELECT * FROM  `user`  WHERE  name = '$name' AND  password = '$password'");

    if (mysqli_num_rows($select) > 0) {
        $message[] = 'user already exist';
    } else {

        if ($password != $cpassword) {
            $message[] = 'confirm password not matched!';
        } elseif ($image_size > 2000000) {
            $message[] = 'image size is too large!';
        } else {
            $insert = mysqli_query($conn, "INSERT INTO `user` VALUES(NULL , '$name' , '$email' , '$password' ,'$image_name' )");
            if ($insert) {
                move_uploaded_file($image_tmp, "$location");
                $message[] = 'registered successfully!';
                go("");
            }
            else{
                $message[] = 'registeration failed!';
            }
        }
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="/Login/css/main.css">
</head>

<body>
    <div class="container">
        <form action="" method="POST" enctype="multipart/form-data">
            <h3>Register Now</h3>
            <?php
            if (isset($message)) {
                foreach ($message as $message) {
                    echo '<div class="message">' . $message . '</div>';
                }
            }
            ?>
            <input type="text" name="name" placeholder="Entre UserName" class="box" required>
            <input type="email" name="email" placeholder="Entre email" class="box" required>
            <input type="password" name="password" placeholder="Entre password" class="box" required>
            <input type="password" name="cpassword" placeholder="confirm password" class="box" required>
            <input type="file" name="image" class="box">
            <input type="submit" name="submit" value="Register Now" class="btn">
            <p>already have an account? <a href="login.php">login now</a></p>
        </form>

    </div>
</body>

</html>