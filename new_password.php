<?php
    include("db_connection.php");
    if(!isset($_COOKIE['email']))
    {
        echo "cookie not set";
    }

    $email = $_COOKIE['email'];

    $errors = array('old'=>'','new'=>'', 'confirm'=>'', 'success'=>'');

    if(isset($_POST['submit']))
    {
        // Form Validation
        if(empty($_POST['old']))
        {
            $errors['old'] = "Please enter old password<br />";
        }
        else
        {
            // Check if it is either the old password or temporary password
            $sql = "SELECT pword, temp_pass FROM Professors WHERE email = '".$email."'";
            $sql_result = mysqli_query($conn, $sql);
            $pwords = mysqli_fetch_assoc($sql_result);
            mysqli_free_result($sql_result);
            $old = htmlspecialchars($_POST['old']);

            if ($pwords['pword'] != $old && $pwords['temp_pass'] != $old)
            {
                $errors['old'] = "Password not found. Please try again.";
            }
        }

        if(empty($_POST['new']))
        {
            $errors['new'] = "Please enter new password <br />";
        }
        else
        {
            $new = htmlspecialchars($_POST['new']);
        }

        if(empty($_POST['confirm']))
        {
            $errors['confirm'] = "Please confirm password <br />";
        }
        else if ($new != $_POST['confirm'])
        {
            $errors['confirm'] = "Passwords do not match <br />";
        }

        // No errors present
        if(!array_filter($errors))
        {
            $sql_update = "UPDATE Professors SET pword = '".$new."' WHERE email = '".$email."'";
            if(mysqli_query($conn, $sql_update))
            {
                $errors['success'] = 'Password Changed!';
            }
        }
    }
    mysqli_close($conn);
?>


<!DOCTYPE html>
<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Add header to webpage -->
    <?php include ('templates/header.php'); ?>
    <?php include ('templates/prof_navbar.php'); ?>
        <section class="container" style="text-align: center;">
            <h1>
                <?php echo "Change Password"; ?>
            </h1>
            <form class="white" action="new_password.php" method="POST" style="text-align: center;" >
                <label><b>Old Password</b>:</label>
                <input type="password" name="old">
                <div class="red-text"><?php echo $errors['old']; ?></div>
                <br>
                <label><b>New Password</b>:</label>
                <input type="password" name="new">
                <div class="red-text"><?php echo $errors['new']; ?></div>
                <br>
                <label style="padding-right:30px" ><b>Confirm Password:<b></label>
                <input style="right:29px; position:relative" type="password" name="confirm">
                <div class="red-text"><?php echo $errors['confirm']; ?></div>
                <div style="color: green;"><?php echo $errors['success']; ?></div>
                <div class="center" style="margin:15px; text-align:center; padding-left:200px">
                    <input type="submit" name="submit" value=Submit>
                </div>
            </form>
        </section>
    <?php include ('templates/footer.php'); ?>
</html>