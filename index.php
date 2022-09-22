<?php
include("./genral/config.php");
include("./genral/functions.php");
session_start();

if (isset($_POST['login'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];

    $select = mysqli_query($conn, "SELECT * FROM  `user`  WHERE  name = '$name' AND  password = '$password'");

    if (mysqli_num_rows($select) > 0) {
        $row = mysqli_fetch_assoc($select);
        $_SESSION['userid'] = $row['id'];
        go("home.php");
    } else {
        $message[] = 'name or password incorrect!';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- ----------   link css -------- -->
    <link rel="stylesheet" href="/Login/css/main.css">
</head>
<body>
    <div class="container">
        <form action="" method="POST" enctype="multipart/form-data">
            <h3>Login Now</h3>
            <?php
            if (isset($message)) {
                foreach ($message as $message) {
                    echo '<div class="message">' . $message . '</div>';
                }
            }
            ?>
            <input type="text" name="name" placeholder="Entre UserName" class="box" required>
            <input type="password" name="password" placeholder="Entre password" class="box" required>
            <input type="submit" name="login" value="Login Now" class="btn">
            <p>don't have an account? <a href="register.php">register now</a></p>
        </form>
    </div>
</body>
</html>