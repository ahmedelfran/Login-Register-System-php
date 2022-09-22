<?php
include("./genral/config.php");
include("./genral/functions.php");

session_start();
$id = $_SESSION['userid'];

if (!isset($id)) {
    go("login.php");
};

// ----- select
$select = mysqli_query($conn, "SELECT * FROM `user` WHERE id = '$id'");
$numRows = mysqli_num_rows($select);
$fetch = mysqli_fetch_assoc($select);

// ----- logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    go("");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- ----------   link css -------- -->
    <link rel="stylesheet" href="/Login/css/main.css">
</head>

<body>
    <div class="container">
        <div class="profile">
            <?php
            if ($fetch['image'] == '') {
                echo '<img src="profile-image.jpg">';
            } else {
                echo '<img src="upload/' . $fetch['image'] . '">';
            }
            ?>
            <h3><?php echo $fetch['name']; ?></h3>
            <button class="btn"><a href="update_profile.php" >update profile</a></button>
            <button class="delete-btn"><a href="home.php?logout=<?php echo $id; ?>" >logout</a></button>
            <p>new <a href="login.php">login</a> or <a href="register.php">register</a></p>
            
        </div>
    </div>
</body>

</html>