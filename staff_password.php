<!DOCTYPE html>
<html>
    <!-- Add header to webpage -->
    <?php include ('templates/header.php'); ?>
    <?php include ('templates/navbar.php'); ?>

        <h4 class="sent-notification"></h4>
        <section class="container" style="text-align: center;">
            <h1>
                <?php echo "Forgot Password"; ?>
            </h1>
                <label>Email:</label>
                <input type="text" id="email" name="email">
                <button type="button" onclick="sendEmail()" value="Send An Email">Request Temporary Password</button>

        </section>
    <?php include ('templates/footer.php'); ?>
    <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
        function sendEmail() {
            var email = $("#email").val();
            if (email != "") {
                $.ajax({
                   url: 'PHPMailer/staffRecovery.php',
                   method: 'POST',
                   dataType: 'json',
                   data: {
                        email: email
                   }, success: function (response) {
                       //check if the response status is equal to fail
                          if (response.status == "failed") {
                            //if it is, display the error message
                            $(".sent-notification").text(response.response);
                          } else {
                            //if it is not, display the success message
                            $(".sent-notification").text(response.response + "\nPlease check your email for your temporary password.\nRedirection you to login page in 5 seconds.");
                            // wait 5 seconds and redirect to login page
                            setTimeout(function(){
                                window.location.href = "staff.php";
                            }, 5000);

                          }
                        // Reset value of email input   field
                        $("#email").val("");
                   }
                });
            }
        }
    </script>

</html>