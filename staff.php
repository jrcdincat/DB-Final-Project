<?php     
    include('db_connection.php');
    $errors = array('email'=>'','password'=>'');
    if(isset($_POST['submit']))
    {
        // Form Validation
        if(empty($_POST['email']))
        {
            $errors['email'] = "Please enter email address";
        }
        else
        {
            $email = $_POST['email'];
            
            // Check if email is valid
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $errors['email'] = 'Invalid email address';
            }
        }

        if(empty($_POST['password']))
        {
            $errors['password'] = "Please enter password <br />";
        }
        else
        {
            $password = htmlspecialchars($_POST['password']);
        }

        // No errors present can proceed to next page
        if(!array_filter($errors))
        {
                    // make query and get results

            $sql = "SELECT Email, pword FROM Admin WHERE Email = '".$email."' AND pword = '".$password."'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) > 0)
            {
                // Successfully logged in, save values in cookies
                echo 'success:';
                $user_data = mysqli_fetch_assoc($result);
                $cookie_name = 'email';
                setcookie($cookie_name, $email, time() + 86400, "/"); // 86400 = 1 day
                header('Location: staffhome.php');
            }
            else
            {
                $errors['password'] = "Invalid email or password <br />";
            }
            mysqli_free_result($result);
        }
    }
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
    <!-- Add header to webpage -->
    <?php include ('templates/header.php'); ?>
    <?php include ('templates/navbar.php'); ?>
        <section class="container" style="text-align: center;">
            <h1>
                <?php echo "Welcome to the Staff Login!"; ?>
            </h1>
            <h4 class="center" style="margin-bottom: 5px; padding-right: 370px;">Sign In</h4>
            <form class="white" action="staff.php" method="POST" style="text-align: center;" >
                <label>Email:</label>
                <input type="text" name="email">
                <div class="red-text"><?php echo $errors['email']; ?></div>
                <label>Password:</label>
                <input type="password" name="password" style="margin-right: 20px;">
                <div class="red-text"><?php echo $errors['password']; ?></div>
                <div class="center" style="margin:15px; text-align:center; padding-left:110px">
                    <a href="forgot_password.php" style="margin-right: 20px;">Forgot Password</a>
                    <input type="submit" name="submit" value=Login>
                </div>
            </form>
        </section>
    <?php include ('templates/footer.php'); ?>
</html>