<?php
include("./genral/config.php");
include("./genral/functions.php");

session_start();
$id = $_SESSION['userid'];

// ----- select
$select = mysqli_query($conn, "SELECT * FROM `user` WHERE id = '$id'");
$numRows = mysqli_num_rows($select);
$fetch = mysqli_fetch_assoc($select);

if (isset($_POST['update_profile'])) {
    $update_name =  $_POST['update_name'];
    $update_email =  $_POST['update_email'];

    mysqli_query($conn, "UPDATE `user` SET name = '$update_name', email = '$update_email' WHERE id = '$id' ");

    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];

    if (!empty($new_pass) || !empty($confirm_pass)) {
        if ($new_pass != $confirm_pass) {
            $message[] = 'confirm password not matched!';
        } else {
            mysqli_query($conn, "UPDATE `user` SET password = '$confirm_pass' WHERE id = '$id' ");
            $message[] = 'password updated successfully!';
        }
    }
    // img
    $update_image = time() . $_FILES['update_image']['name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_image_tmp= $_FILES['update_image']['tmp_name'];
    $location = "./upload/$update_image";

    if (!empty($update_image)) {
        if ($update_image_size > 2000000) {
            $message[] = 'image is too large';
        } else {
            $image_update_query = mysqli_query($conn, "UPDATE `user` SET image = '$update_image' WHERE id = '$id'");
            if ($image_update_query) {
                move_uploaded_file($update_image_tmp, $location);
            }
            $message[] = 'image updated succssfully!';
        }
    }
    go("home.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update profile</title>
    <!-- ----------   link css -------- -->
    <link rel="stylesheet" href="/Login/css/main.css">
</head>

<body>
    <div class="container">

        <form method="post" enctype="multipart/form-data">
            <?php
            if ($fetch['image'] == '') {
                echo '<img class="img" src="profile-image.jpg">';
            } else {
                echo '<img class="img" src="upload/' . $fetch['image'] . '">';
            }

            if (isset($message)) {
                foreach ($message as $message) {
                    echo '<div class="message">' . $message . '</div>';
                }
            }
            ?>
            <div class="flex">
                <div class="inputBox">
                    <span>username :</span>
                    <input type="text" name="update_name" value="<?php echo $fetch['name']; ?>" class="box">
                    <span>your email :</span>
                    <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box">
                </div>
                <div class="inputBox">
                    <span>new password :</span>
                    <input type="password" name="new_pass" placeholder="enter new password" class="box">
                    <span>confirm password :</span>
                    <input type="password" name="confirm_pass" placeholder="confirm new password" class="box">
                </div>
            </div>
            <div class="pic">
                <span>update your pic :</span>
                <input type="file" name="update_image" class="box">
            </div>
            <div class="btn_up">
                <input type="submit" value="update profile" name="update_profile">
                <button class="delete-btn"><a href="home.php">go back</a></button>
            </div>



        </form>


    </div>
</body>

</html>