<?php
    include("db_connection.php");
    $errors = array('email'=>'','password'=>'', 'confirm'=>'','firstName'=>'','lastName'=>'');

    if(isset($_POST['submit']))
    {
        // Form Validation
        if(empty($_POST['firstName']))
        {
            $errors['firstName'] = "Please enter first name <br />";
        }
        else
        {
            $firstName = htmlspecialchars($_POST['firstName']);
        }

        if(empty($_POST['lastName']))
        {
            $errors['lastName'] = "Please enter last name <br />";
        }
        else
        {
            $lastName = htmlspecialchars($_POST['lastName']);
        }

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

        if(empty($_POST['confirm']))
        {
            $errors['confirm'] = "Please confirm password <br />";
        }
        else if ($password != $_POST['confirm'])
        {
            $errors['confirm'] = "Passwords do not match <br />";

        }

        // No errors present can proceed to next page
        if(!array_filter($errors))
        {
            // Make query and get results
            $sql = "INSERT INTO Professors (f_name, l_name, email, pword) VALUES('".$firstName."',
            '".$lastName."','".$email."','".$password."')";

            if(mysqli_query($conn, $sql))
            {
                header('Location: index.php');
            }
        }
    }
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
    <!-- Add header to webpage -->
    <?php include ('templates/header.php'); ?>
    <?php include ('templates/prof_navbar.php'); ?>
    <section class="container" style="text-align: center;">
            <h1>
                <?php echo "Create Account"; ?>
            </h1>
            <form class="white" action="create_account.php" method="POST" style="text-align: center;" >
                <label><b>First Name:</b></label>
                <input type="text" name="firstName"style="margin-bottom: 10px">
                <div class="red-text"><?php echo $errors['firstName']; ?></div>
                <label><b>Last Name:</b></label>
                <input type="text" name="lastName"style="margin-bottom: 10px">
                <div class="red-text"><?php echo $errors['lastName']; ?></div>
                <label style="padding-left: 32px;"><b>Email</b>:</label>
                <input type="text" name="email" style="margin-bottom: 10px">
                <div class="red-text"><?php echo $errors['email']; ?></div>
                <label style="padding-left: 9px;"><b>Password:</b></label>
                <input type="password" name="password" style="margin-bottom: 10px">
                <div class="red-text"><?php echo $errors['password']; ?></div>
                <label style="padding-right:60px" ><b>Confirm Password:<b></label>
                <input style="right:55px; position:relative" type="password" name="confirm">
                <div class="red-text"><?php echo $errors['confirm']; ?></div>
                <div class="center" style="margin:15px; text-align:right; padding-right:100px">
                    <input type="submit" name="submit" value=Submit>
                </div>
            </form>
        </section>
    <?php include ('templates/footer.php'); ?>
</html>