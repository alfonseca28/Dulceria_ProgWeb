<?php

// use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};

// require '../phpmailer/src/PHPMailer.php';
// require '../phpmailer/src/SMTP.php';
// require '../phpmailer/src/Exception.php';

// //Create an instance; passing `true` enables exceptions
// $mail = new PHPMailer(true);

// try {
//     //Server settings
//     $mail->SMTPDebug = SMTP::DEBUG_SERVER; //SMTP::DEBUG_OFF;
//     $mail->isSMTP();
//     $mail->Host       = 'smtp.gmail.com';
//     $mail->SMTPAuth   = true;
//     $mail->Username   = 'aronalfon@gmail.com';
//     $mail->Password   = 'A!fonseca_2801';
//     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//     $mail->Port       = 587;

//     //Recipients
//     $mail->setFrom('Ventas@Purrfections.com', 'Dulceria Purrfections');
//     $mail->addAddress('aronalfon@gmail.com', 'Aaron Alfonseca');     //Add a recipient

//     //Content
//     $mail->isHTML(true);                                  //Set email format to HTML
//     $mail->Subject = 'Detalles de su compra';
//     $cuerpo = '<h4>Gracias por su compra</h4>';
//     $cuerpo .= '<p>El id de su compra es <b>' . $id_Transaccion . '</b></p>';
//     $mail->Body    = utf8_decode($cuerpo);
//     $mail->AltBody = 'Le enviamos los detalles de su compra';

//     $mail->setLanguage('es', '../phpmailer/language/phpmailer.lang-es.php');

//     $mail->send();
// } catch (Exception $e) {
//     echo "Error al enviar el correo electronico de la compra: {$mail->ErrorInfo}";
//     exit();
// }
?>