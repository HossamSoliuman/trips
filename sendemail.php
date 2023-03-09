<?php
include "mail.php";
$mail->setfrom('hossam0soliuman@gmail.com',"hossam site");
$mail->addAddress($to);
$mail->Subject=$subject;
$mail->Body=$body;
$mail->send();
?>
