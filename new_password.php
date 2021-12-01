<!DOCTYPE html>
<html>
    <!-- Add header to webpage -->
    <?php include ('templates/header.php'); ?>
        <section class="container" style="text-align: center;">
            <h1>
                <?php echo "Reset Password"; ?>
            </h1>
            <form class="white" action="" method="" style="text-align: center;" >
                <label>New Password:</label>
                <input type="password" name="newPassword">
                <div class="center" style="margin:15px; text-align:center; padding-left:200px">
                    <input type="submit" name="submit" value=Submit>
                </div>
            </form>
        </section>
    <?php include ('templates/footer.php'); ?>
</html>