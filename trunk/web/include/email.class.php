<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './vendors/PHPMailer/src/Exception.php';
require './vendors/PHPMailer/src/PHPMailer.php';
require './vendors/PHPMailer/src/SMTP.php';

function email($address, $mailtitle, $mailcontent){
    $debug = false;

    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();

        /********************* 配置信息 *********************/
        // TODO: 从配置文件中读取
        $mail->Host         = 'smtp-mail.outlook.com';
        $mail->SMTPAuth     = true;
        $mail->Username     = 'hautoj@outlook.com';
        $mail->Password     = '';
        $mail->SMTPSecure   = PHPMailer::ENCRYPTION_STARTTLS;  // 可选值: tls、ssl
        $mail->Port         = 587;

        $mail->CharSet      = 'UTF-8';
        $mail->Encoding     = 'base64';

        //Recipients
        $mail->setFrom($mail->Username, "HautOJ");
        $mail->addAddress($address);

        $mail->isHTML(false);
        $mail->Subject = $mailtitle;
        $mail->Body    = $mailcontent;
        $mail->send();
        if ($debug) {
            echo 'Message has been sent';
        }
    } catch (Exception $e) {
        if ($debug) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}