<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'shristikharel321@gmail.com';                     //SMTP username
    $mail->Password   = 'mqyn hlal kpkb znko';                  //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('shristikharel321@gmail.com', 'Booking Message');
    $mail->addAddress('shristi.kharel@deerwalk.edu.np', 'Hotel Booking Website');     //Add a recipient
    

    
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Booking Confirmed';
    $mail->Body    = 'Dear [Your Name] <br>  Thank you for choosing HMS for your stay. 
    We are pleased to confirm your reservation for the following details: <br> Reservation Number: [Unique Reservation Number] <br>
    Check-in Date: [Date] <br>
    Check-out Date: [Date] <br>
    Room Type: [Type of Room] <br>
    Number of Guests: [Number of Guests] <br>
    Total Cost: [Total Amount] <br>
    Additional Information: <br>
    Contact Information: <br>
    Phone Number: 9869031332 <br>
    Email Address: shristi.kharel@deerwalk.edu.np <br>
    Please review the information above to ensure accuracy. 
    If you have any questions or need further assistance, feel free to contact us at [Hotel Contact Information] <br>
    We look forward to welcoming you to HMS Safe travels! <br>
    Best regards, <br>
    HMS Team <br>';
    

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
