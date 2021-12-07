<!DOCTYPE html>
<html>
    <!-- Add header to webpage -->
    <?php include ('../templates/header.php'); ?>
    <?php include ('../templates/navbar.php'); ?>
    <?php
        if(!isset($_COOKIE['email']) || $_COOKIE['email'] == "") {
            header("Location: staff.php");
        }
    ?>
<head>
    <title>Send an Email</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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

            <!-- Create an input that holds a date in the format mm/dd/yyyy -->
            <label>Automatic Reminder (Leave Blank for no reminder)</label>
            <input id="reminder" size="30" type="text" placeholder=" Enter Date in yyyy/mm/dd format">
            <br><br>

			<p>Message</p>
            <!-- Make a textarea with hello world inside the value of it: -->
			<textarea id="body" rows="15" cols="80" placeholder="Hello Professor, please make sure to upload your book request by mm/dd/yyyy by logging-in to your account on the following website: http://localhost/DB-Final-Project/"></textarea><br><br>

			<button type="button" onclick="sendEmail()" value="Send An Email">Submit</button>
		</form>
	</center>

    <!-- Javascript to go to sendEmail.php -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script
	<script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script type="text/javascript">
        function sendEmail() {
            var subject = $("#subject");
            var body = $("#body");
            // get the value of emails input
            var emails = $("input[name='emails']").val();
            // transform the string into an array
            var emailsArray = emails.split(",");

            // get the value of reminder input
            var reminder = $("#reminder");
            var reminderDate = reminder.val();
            // make a date object from reminderDate in the format yyyy/mm/dd
            var date = new Date(reminderDate);

            // Check if the reminderData already passed
            if (reminderDate != "") {
                var today = new Date();
                if (date <= today) {
                    alert("Reminder date has already passed");
                    return;
                }
            }
            //If subject and the text area are not empty, it will send email
            if (isNotEmpty(subject) && isNotEmpty(body)) {
                $.ajax({
                   url: 'sendEmail.php',
                   method: 'POST',
                   dataType: 'json',
                   data: {
                       subject: subject.val(),
                       body: body.val(),
                       emails: emailsArray,
                       //reminder: save the string value of $date in the format mm/dd/yyyy
                       reminder: reminderDate
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