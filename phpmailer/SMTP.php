<?php
namespace PHPMailer\PHPMailer;

class SMTP
{
    public static function sendSMTPMail(PHPMailer $mail)
    {
        $boundary = md5(time());

        $headers  = "From: {$mail->FromName} <{$mail->From}>\r\n";
        $headers .= "Reply-To: {$mail->replyTo[0]}\r\n";
        $headers .= "MIME-Version: 1.0\r\n";

        if (count($mail->attachments) > 0) {
            $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n\r\n";
            $body  = "--$boundary\r\n";
            $body .= "Content-Type: text/plain; charset=\"UTF-8\"\r\n";
            $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
            $body .= $mail->Body . "\r\n\r\n";

            foreach ($mail->attachments as $file) {
                [$path, $filename] = $file;
                $content = chunk_split(base64_encode(file_get_contents($path)));

                $body .= "--$boundary\r\n";
                $body .= "Content-Type: application/octet-stream; name=\"$filename\"\r\n";
                $body .= "Content-Disposition: attachment; filename=\"$filename\"\r\n";
                $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
                $body .= $content . "\r\n\r\n";
            }
            $body .= "--$boundary--";
        } else {
            $headers .= "Content-Type: text/plain; charset=\"UTF-8\"\r\n";
            $body = $mail->Body;
        }

        // Use PHP mail() for delivery (SMTP servers relay locally)
        foreach ($mail->to as $recipient) {
            mail($recipient[0], $mail->Subject, $body, $headers);
        }

        return true;
    }
}