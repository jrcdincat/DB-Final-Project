<?php     
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
            echo "password empty <br />";
        }
        else
        {
            echo htmlspecialchars($_POST['password']);
        }
    }
?>

<!DOCTYPE html>
<html>
    <!-- Add header to webpage -->
    <?php include ('templates/header.php'); ?>
        <section class="container" style="text-align: center;">
            <h1>
                <?php echo "Welcome"; ?>
            </h1>
            <h4 class="center" style="margin-bottom: 5px; padding-right: 370px;">Sign In</h4>
            <form class="white" action="index.php" method="POST" style="text-align: center;" >
                <label>Email:</label>
                <input type="text" name="email">
                <div class="red-text"><?php echo $errors['email']; ?></div>
                <label>Password:</label>
                <input type="password" name="password">
                <div class="center" style="margin:15px; text-align:center; padding-left:110px">
                    <a href="create_account.php" style="margin-right: 20px;">Create Account</a>
                    <a href="forgot_password.php" style="margin-right: 20px;">Forgot Password</a>
                    <input type="submit" name="submit" value=Login>
                </div>
            </form>
        </section>
    <?php include ('templates/footer.php'); ?>
</html>