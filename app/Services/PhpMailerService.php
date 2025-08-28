<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PhpMailerService
{
    public static function sendEmail($to, $subject, $body, $from = 'example@example.com')
    {
        $mail = new PHPMailer(true);

        try {
            // Cấu hình server
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Thay bằng SMTP server của bạn
            $mail->SMTPAuth   = true;
            $mail->Username   = env('MAIL_USERNAME'); // Email của bạn
            $mail->Password   = env('MAIL_PASSWORD'); // Mật khẩu email
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Cấu hình người gửi và người nhận
            $mail->setFrom($from, env('MAIL_FROM_NAME'));
            $mail->addAddress($to);

            // Nội dung email
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }
}