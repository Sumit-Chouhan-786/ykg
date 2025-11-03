<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = "info@cpaykg.ca";
    $subject = "New Consultation Request from Website";

    $message = "
    Name: " . htmlspecialchars($_POST['name']) . "\n
    Email: " . htmlspecialchars($_POST['email']) . "\n
    Phone: " . htmlspecialchars($_POST['phone']) . "\n
    Service: " . htmlspecialchars($_POST['service']) . "\n
    Date: " . htmlspecialchars($_POST['date']) . "\n
    Message: " . htmlspecialchars($_POST['message']) . "\n
    ";

    $headers = "From: " . $_POST['email'] . "\r\n";

    // Handle file attachment if uploaded
    if (!empty($_FILES['attachment']['name'])) {
        $file_tmp = $_FILES['attachment']['tmp_name'];
        $file_name = $_FILES['attachment']['name'];
        $file_data = file_get_contents($file_tmp);
        $boundary = md5(time());

        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

        $body = "--$boundary\r\n";
        $body .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
        $body .= $message . "\r\n";

        $body .= "--$boundary\r\n";
        $body .= "Content-Type: application/octet-stream; name=\"$file_name\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n";
        $body .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n\r\n";
        $body .= chunk_split(base64_encode($file_data)) . "\r\n";
        $body .= "--$boundary--";

        mail($to, $subject, $body, $headers);
    } else {
        // No file uploaded
        mail($to, $subject, $message, $headers);
    }

    echo "OK";
}
?>
