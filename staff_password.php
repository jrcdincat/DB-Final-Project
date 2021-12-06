<!DOCTYPE html>
<html>
    <!-- Add header to webpage -->
    <?php include ('templates/header.php'); ?>
        <section class="container" style="text-align: center;">
            <h1>
                <?php echo "Forgot Password"; ?>
            </h1>
            <form class="white" action="PHPMailer/staffRecovery.php" method="post" style="text-align: center;" >
                <label>Email:</label>
                <input type="text" name="email">
                <div class="center" style="margin:15px; text-align:center; padding-left:140px">
                    <input type="submit" name="submit" value=Submit>
                </div>
            </form>
        </section>
    <?php include ('templates/footer.php'); ?>
</html>