<!DOCTYPE html>
<html>
    <!-- Add header to webpage -->
    <?php include ('../templates/header.php'); ?>
<head>
    <title>Send an Email</title>
</head>
<body>

	<center>
		<h4 class="sent-notification"></h4>

        <!-- UI -->
		<form id="myForm">
			<h2>Send an Email</h2>

            <?php
                // Get all the email address on the url
                $email = $_GET['emails'];
                // Split the email address into an array
                echo "<label>Recipients </label>";
                echo "<input type='text' name='emails' value='$email' disabled><br>";
            ?>
            <!-- Create an input for the id that doesn't allow the user to change the value -->

			<label>Subject</label>
			<input id="subject" size="30" type="text" placeholder=" Enter Subject">
			<br><br>

			<p>Message</p>
			<textarea id="body" rows="15" cols="80" placeholder="Type Message"></textarea>
			<br><br>

			<button type="button" onclick="sendEmail()" value="Send An Email">Submit</button>
		</form>
	</center>

    <!-- Javascript to go to sendEmail.php -->
	<script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script type="text/javascript">
        function sendEmail() {
            var subject = $("#subject");
            var body = $("#body");
            // get the value of emails input
            var emails = $("input[name='emails']").val();
            // transform the string into an array
            var emailsArray = emails.split(",");

            //If subject and the text area are not empty, it will send email
            if (isNotEmpty(subject) && isNotEmpty(body)) {
                $.ajax({
                   url: 'sendEmail.php',
                   method: 'POST',
                   dataType: 'json',
                   data: {
                       subject: subject.val(),
                       body: body.val(),
                       emails: emailsArray
                   }, success: function (response) {
                        $('#myForm')[0].reset();
                        $('.sent-notification').text("Message Sent Successfully.");
                   }
                });
            }
        }

        //isNotempty function
        function isNotEmpty(caller) {
            if (caller.val() == "") {
                caller.css('border', '1px solid red');
                return false;
            } else
                caller.css('border', '');

            return true;
        }
    </script>

</body>
<?php include ('../templates/footer.php'); ?>
</html>