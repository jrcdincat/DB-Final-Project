<!DOCTYPE html>
<html>
    <?php
    $error = "";
        include('db_connection.php');
        // Check if it's a POST request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $oldpass = $_POST['oldpass'];
            $newpass = $_POST['newpass'];
            $newpass2 = $_POST['newpass2'];

            // Check if the newpass and newpass2 match and are not empty
            if ($newpass == $newpass2 && $newpass != "" && $newpass2 != "") {
                // Check if the email exists in the admin database
                $sql = "SELECT * FROM admin WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                if ($row) {
                    // Check if the old password is correct
                    if($row['pword'] == $oldpass) {
                        // Update the password
                        $sql = "UPDATE admin SET pword = '$newpass' WHERE email = '$email'";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            $error = "Password updated successfully";
                            header('Location: staff.php');
                        } else {
                            $error = "Error updating password";
                            
                        }
                    } else {
                        $error = "Old password is incorrect";
                        
                    }
                }
                else{
                    $error = "Email does not exist";
                    
                }
        }else{
            $error = "New passwords do not match";
            
        }
    }
    ?>
    <!-- Add header to webpage -->
    <?php include ('templates/header.php'); ?>
            <p><?php
            if (isset($error)) {
                echo $error;
            }
            ?></p>
        <section class="container" style="text-align: center;">
            <h1>
                <?php echo "CHANGE PASSWORD"; ?>
            </h1>
            <form class="center" action="staff_changepassword.php" method="post">
                <label>Email:</label><br>
                <input type="text" id="email" name="email"><br>
                <label>Old Password/Temporary Password:</label><br>
                <input type="password" id="oldpass" name="oldpass"><br>
                <label>New Password:</label><br>
                <input type="password" id="newpass" name="newpass"><br>
                <label>Verify New Password</label><br>
                <input type="password" id="newpass2" name="newpass2"><br>
                <!-- Submit button  -->
                <input type="submit" value="Submit" id="submit">
            </form>
        </section>
    <?php include ('templates/footer.php'); ?>

    <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>

</html>