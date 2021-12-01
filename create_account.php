<!DOCTYPE html>
<html>
    <!-- Add header to webpage -->
    <?php include ('templates/header.php'); ?>
    <section class="container" style="text-align: center;">
            <h1>
                <?php echo "Create Account"; ?>
            </h1>
            <form class="white" action="" method="" style="text-align: center;" >
                <label>First Name:</label>
                <input type="text" name="firstName"style="margin-bottom: 10px">
                <br>
                <label>Last Name:</label>
                <input type="text" name="lastName"style="margin-bottom: 10px">
                <br>
                <label style="padding-left: 32px;">Email:</label>
                <input type="text" name="email" style="margin-bottom: 10px">
                <br>
                <label style="padding-left: 9px;">Password:</label>
                <input type="password" name="password">
                <div class="center" style="margin:15px; text-align:right; padding-right:100px">
                    <input type="submit" name="submit" value=Submit>
                </div>
            </form>
        </section>
    <?php include ('templates/footer.php'); ?>
</html>