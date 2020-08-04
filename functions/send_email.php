<?php

function sendEmailToUser($text_message, $mail_winner, $name_winner) {    
    $keksSmtpHost = 'phpdemo.ru';
    $keksSmtpPort = 25;
    $my_name_in_keks = 'keks@phpdemo.ru';
    $my_email_in_keks = 'keks@phpdemo.ru';
    $my_password_in_keks = 'htmlacademy';
    

    $transport = (new Swift_SmtpTransport($keksSmtpHost, $keksSmtpPort))
        ->setUsername($my_name_in_keks)
        ->setPassword($my_password_in_keks)
        ;
                
    $mailer = new Swift_Mailer($transport);

    $message = (new Swift_Message())
        ->setFrom(["keks@phpdemo.ru" => "YetiCave"])
        ->setTo([$mail_winner => $name_winner])
        ->setBody($text_message)    
        ;
    
    $result = $mailer->send($message);
}