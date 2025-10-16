<?php

  require(__DIR__."/src/PHPMailer.php");
  require(__DIR__."/src/SMTP.php");
  require(__DIR__."/src/OAuth.php");
  require(__DIR__."/src/POP3.php");
  require(__DIR__."/src/Exception.php");

    $mail = new PHPMailer\PHPMailer\PHPMailer();

    $mail->IsSMTP(); // enable SMTP

    $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.zoho.com";
    $mail->Port = 587; // or 587
    $mail->IsHTML(true);
    $mail->Username = "raseel@uniziontechnologies.com";
    $mail->Password = "raseel_123";
    $mail->SetFrom("raseel@uniziontechnologies.com");
    $mail->Subject = "Test";
    $mail->Body = "hello";
    $mail->AddAddress("athulyaek2014@gmail.com");

     if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
     } else {
        echo "Message has been sent";
     }
?>