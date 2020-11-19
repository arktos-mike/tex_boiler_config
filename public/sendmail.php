<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require './PHPMailer/Exception.php';
require './PHPMailer/PHPMailer.php';
require './PHPMailer/SMTP.php';
mb_internal_encoding("UTF-8");
  // ------------------------------------
  // Start
  // ------------------------------------
  // Only process POST reqeusts.
 // echo '<pre>'; print_r($_POST); echo '</pre>'; 
   if ($_SERVER["REQUEST_METHOD"] != "POST") {
    // Not a POST request, set a 403 (forbidden) response code.
    http_response_code(403);
    echo "403 forbidden";
    exit;
  }
  $name = $_POST["name"];
  $email = $_POST["email"];
  $multi_text = $_POST["multiText"];

  if (
    empty($name) OR
    empty($multi_text) OR
    !filter_var($email, FILTER_VALIDATE_EMAIL)
  ) {
    // Set a 400 (bad request) response code and exit.
    http_response_code(400);
    echo "400 bad request";
    exit;
  }
  
  $mail = new PHPMailer(true);
  // ------------------------------------
  // For Admin
  // ------------------------------------
  try {
    $mail->SMTPDebug = 1;         
    $mail->isSMTP(); // using SMTP protocol  
    $mail->CharSet = "utf-8";
    $mail->Host = 'smtp..ru'; // SMTP host as gmail 
    $mail->SMTPAuth = true;  // enable smtp authentication                             
    $mail->Username = 'config@.ru';  // sender gmail host              
    $mail->Password = ''; // sender gmail host password                          
    
    $mail->SMTPSecure = 'tls';  // for encrypted connection                           
    $mail->Port = 587;   // port for SMTP     
    $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
    $mail->setFrom($email, $name); // sender's email and name
    $mail->addAddress('config@.ru', "ТЭКС-Автоматик");  // receiver's email and name
    
    $mail->isHTML(true);
    $mail->Subject = 'Создана новая конфигурация котла на сайте';
    $mail->MsgHTML($multi_text);

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) { // handle error.
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
$mail = new PHPMailer(true);
  // ------------------------------------
  // For User
  // ------------------------------------
 try {
    $mail->SMTPDebug = 2;
    $mail->isSMTP(); // using SMTP protocol      
    $mail->CharSet = "utf-8";
    $mail->Host = 'smtp..ru'; // SMTP host as gmail 
    $mail->SMTPAuth = true;  // enable smtp authentication                             
    $mail->Username = 'config@.ru';  // sender gmail host              
    $mail->Password = ''; // sender gmail host password                          
    $mail->SMTPSecure = 'tls'; // for encrypted connection                           
    $mail->Port = 587;   // port for SMTP     
    $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
    $mail->setFrom('config@.ru', "ТЭКС-Автоматик"); // sender's email and name
    $mail->addAddress($email, $name);  // receiver's email and name
    
    $mail->isHTML(true);
    $mail->Subject = 'Ваша конфигурация ПТК автоматизации котла';
    $mail->MsgHTML (preg_replace('#<div id="adm"(.*?)</div>#', '', $multi_text));

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) { // handle error.
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}

?>