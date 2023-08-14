<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path_to_phpmailer/Exception.php';
require 'path_to_phpmailer/PHPMailer.php';
require 'path_to_phpmailer/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipient = $_POST['recipient'];
    $message = $_POST['message'];
    $mailType = $_POST['mail_type'];

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // Your SMTP server host
        $mail->SMTPAuth = true;
        $mail->Username = 'your_username'; // Your SMTP username
        $mail->Password = 'your_password'; // Your SMTP password
        $mail->SMTPSecure = 'tls'; // Use 'tls' or 'ssl'
        $mail->Port = 587; // SMTP port (465 for SSL, 587 for TLS)

        $mail->setFrom('sender@example.com', 'Sender Name');
        $mail->addAddress($recipient);

        $mail->isHTML(true);
        $mail->Subject = 'Test Email';
        $mail->Body = $message;

        if ($mailType === 'attach' && isset($_FILES['attachment'])) {
            $attachment = $_FILES['attachment']['tmp_name'];
            $mail->addAttachment($attachment, 'attachment.pdf');
        }

        if ($mailType === 'cc') {
            $mail->addCC('cc@example.com', 'CC Recipient');
        }

        if ($mailType === 'bcc') {
            $mail->addBCC('bcc@example.com', 'BCC Recipient');
        }

        $mail->send();
        echo 'Email sent successfully.';
    } catch (Exception $e) {
        echo 'Email sending failed: ' . $mail->ErrorInfo;
    }
} else {
    echo 'Invalid request.';
}
?>


