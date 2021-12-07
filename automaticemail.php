<?php
use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;
    include('db_connection.php');

    if(!isset($_COOKIE['email']) || $_COOKIE['email'] == "") {
        header("Location: staff.php");
    }
    $email = $_COOKIE['email'];

    //get today's date to compare with the date stored in the database
    $today = date("Y-m-d");

    // Get all emails with emailsent = false in the reminders table
    $sql = "SELECT * FROM reminders WHERE emailsent = 0 AND reminder = '$today'";
    $result = $conn->query($sql);
    
    //PHPMailer Files
    require_once "PHPMailer/PHPMailer/PHPMailer.php";
    require_once "PHPMailer/PHPMailer/SMTP.php";
    require_once "PHPMailer/PHPMailer/Exception.php";

    $mail = new PHPMailer(true);

    //smtp server settings
    $mail->isSMTP();                                //Send Using SMTP
    $mail->Host = "smtp.gmail.com";                 //SMTP server
    $mail->SMTPAuth = true;                         //Enables SMTP authentication
    $mail->Username = "mkimproject4710@gmail.com";  //Email address thats sending email
    $mail->Password = 'Gr456987!';                  //Stop looking at my password! lol its a temp account made recently
    $mail->Port = 465;                              //TCP port to connect to
    $mail->SMTPSecure = "ssl";                      //SSL encryption

    $mail->isHTML(true);                            //Sets email format to HTML
    $mail->setFrom("mkimproject4710@gmail.com", "Book Staff");    //Format of email
    if ($result->num_rows > 0) {
        foreach($result as $row) {
            // get the emails, subject, and body from the database
            $emails = $row['emails'];
            $subject = $row['subject'];
            $body = $row['body'];
            $reminderid = $row['reminderid'];
            //email settings
            $mail->Subject = ("$subject");                  //Subject of email
            $mail->Body = $body;                            //Text area of email
            $mail->addAddress("vubblemeteos@gmail.com");    //Sends to this email address
        
            // convert the emails to an array
            $emails = explode(",", $emails);
            // for each email in the emails array add it as a bcc
            foreach ($emails as $email) {
                $mail->addBCC($email);
            }
            
        
            //Send the email
            if($mail->send()){
                $status = "success";
                $response = "Email is sent!";
            }
            else
            {   
                $status = "failed";
                $response = "Something is wrong: <br>" . $mail->ErrorInfo;
            }

            // Update the emailsent column in the reminders table to true
            $sql = "UPDATE reminders SET emailsent = 1 WHERE reminderid = '$reminderid'";
            $result = $conn->query($sql);
        }
    }


    //mysqli_close($conn);
?>


<html>
    <!-- Add Jquery Script-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Add header to webpage -->
    <?php include ('templates/header.php'); ?>
    <?php include ('templates/navbar.php'); ?>
        <section class="container" style="text-align: center;">
        <table style="width:100%">
                    <hr>
                    <h1>Email Reminder List</h1>
                    <thead>
                        <tr>
                            <th style="width:18%">Recipients</th>
                            <th style="width:18%">Subject</th>
                            <th style="width:18%">Automatic Delivery</th>
                            <th style="width:18%">STATUS</th>
                            <th style="width:18%">Days Until Delivery</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM reminders";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['emails'] . "</td>";
                                    echo "<td>" . $row['subject'] . "</td>";
                                    echo "<td>" . $row['reminder'] . "</td>";
                                    // If emailsent is 1, display sent, otherwise display not sent
                                    if ($row['emailsent'] == 1) {
                                        echo "<td>Sent</td>";
                                    } else {
                                        echo "<td>Not Sent</td>";
                                    }
                                    // If the reminder is today, display 0, otherwise display the number of days until the reminder
                                    if ($row['reminder'] == $today) {
                                        echo "<td>0</td>";
                                    } else {
                                        $date1 = new DateTime($today);
                                        $date2 = new DateTime($row['reminder']);
                                        $diff = $date2->diff($date1)->format("%a");
                                        echo "<td>" . $diff . "</td>";
                                    }
                                    echo "</tr>";
                                }
                            }
                        ?>
                    </tbody>
                    <?php                                     
                        mysqli_close($conn);
                    ?>
                </table>
        </section>
    <?php include ('templates/footer.php'); ?>
</html>