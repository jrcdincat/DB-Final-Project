<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include('../db_connection.php');
//PHPMailer Files
require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/SMTP.php";
require_once "PHPMailer/Exception.php";

    $email = $_POST['email'];
    $rand = rand(100000,999999);
    // UPDATE the password and temporary password to match the random number on the admin table
    $sql = "UPDATE admin SET pword = '$rand', temp_pass = '$rand' WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    if($result){
        $body = "Here's your temporary password: '$rand'. Please login and change your password.";
        $mail = new PHPMailer(true);

        //smtp server settings
        $mail->isSMTP();                                //Send Using SMTP
        $mail->Host = "smtp.gmail.com";                 //SMTP server
        $mail->SMTPAuth = true;                         //Enables SMTP authentication
        $mail->Username = "mkimproject4710@gmail.com";  //Email address thats sending email
        $mail->Password = 'Gr456987!';                  //Stop looking at my password! lol its a temp account made recently
        $mail->Port = 465;                              //TCP port to connect to
        $mail->SMTPSecure = "ssl";                      //SSL encryption

        //email settings
        $mail->isHTML(true);                            //Sets email format to HTML
        $mail->setFrom("mkimproject4710@gmail.com", "Book Staff");    //Format of email
        $mail->Subject = ("Password Recovery");                  //Subject of email
        $mail->addAddress("$email");    //Sends to this email address
        $mail->Body = $body;                            //Text area of email


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

        exit(json_encode(array("status" => $status, "response" => $response)));
    }
    else{
        $status = "failed";
        $response = "Something is wrong: <br>" . $conn->error;
        exit(json_encode(array("status" => $status, "response" => $response)));
    }
    

?>
      