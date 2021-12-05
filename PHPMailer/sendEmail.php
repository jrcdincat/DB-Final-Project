<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


    $subject = $_POST['subject'];
    $body = $_POST['body'];

    //PHPMailer Files
    require_once "PHPMailer/PHPMailer.php";
    require_once "PHPMailer/SMTP.php";
    require_once "PHPMailer/Exception.php";

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
    $mail->Subject = ("$subject");                  //Subject of email
    $mail->Body = $body;                            //Text area of email
    $mail->addAddress("vubblemeteos@gmail.com");    //Sends to this email address

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

?>
      