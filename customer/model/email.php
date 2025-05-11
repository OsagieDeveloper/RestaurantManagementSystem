<?php
require_once 'session.php';

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Load PHPMailer autoloader or classes directly
// Alternatively, if not using Composer:
require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

/**
 * Send an email using PHPMailer
 * @param string $to Recipient email address
 * @param string $toName Recipient name
 * @param string $subject Email subject
 * @param string $body Email body content
 * @param string $altBody Alternative plain text body (optional)
 * @param array $cc Array of CC email addresses (optional)
 * @param array $bcc Array of BCC email addresses (optional)
 * @param array $attachments Array of file paths for attachments (optional)
 * @return bool|string Returns true on success, error message on failure
 */
function sendEmail($to, $toName, $subject, $body, $altBody = '', $cc = [], $bcc = [], $attachments = []) {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Enable verbose debug output if needed
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = 'your_username'; // SMTP username
        $mail->Password = 'your_password'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port = 587; // TCP port to connect to
        
        // Recipients
        $mail->setFrom('from@example.com', 'Restaurant Support');
        $mail->addAddress($to, $toName);
        
        // Add CC recipients
        foreach ($cc as $ccEmail) {
            $mail->addCC($ccEmail);
        }
        
        // Add BCC recipients
        foreach ($bcc as $bccEmail) {
            $mail->addBCC($bccEmail);
        }
        
        // Add attachments
        foreach ($attachments as $attachment) {
            if (file_exists($attachment)) {
                $mail->addAttachment($attachment);
            }
        }
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        if (!empty($altBody)) {
            $mail->AltBody = $altBody;
        } else {
            $mail->AltBody = strip_tags($body);
        }
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

/**
 * Send a notification email to a customer about their support query status
 * @param string $to Recipient email address
 * @param string $toName Recipient name
 * @param string $queryId Support query ID
 * @param string $status New status of the query
 * @return bool|string Returns true on success, error message on failure
 */
function sendSupportStatusEmail($to, $toName, $queryId, $status) {
    $subject = "Update on Your Support Query #$queryId";
    $body = "<h3>Dear $toName,</h3>
             <p>We wanted to inform you that your support query (ID: #$queryId) status has been updated to: <strong>$status</strong>.</p>
             <p>If you have any further questions or concerns, please don't hesitate to contact us.</p>
             <p>Best regards,<br>Restaurant Support Team</p>";
    $altBody = "Dear $toName,\n\nWe wanted to inform you that your support query (ID: #$queryId) status has been updated to: $status.\n\nIf you have any further questions or concerns, please don't hesitate to contact us.\n\nBest regards,\nRestaurant Support Team";
    
    return sendEmail($to, $toName, $subject, $body, $altBody);
}

/**
 * Send a confirmation email to a customer about their reservation
 * @param string $to Recipient email address
 * @param string $toName Recipient name
 * @param string $date Reservation date
 * @param string $time Reservation time
 * @param int $guests Number of guests
 * @param string $specialRequests Any special requests
 * @return bool|string Returns true on success, error message on failure
 */
function sendReservationConfirmationEmail($to, $toName, $date, $time, $guests, $specialRequests = '') {
    $subject = "Reservation Confirmation";
    $body = "<h3>Dear $toName,</h3>
             <p>Your reservation has been successfully confirmed.</p>
             <ul>
                 <li><strong>Date:</strong> $date</li>
                 <li><strong>Time:</strong> $time</li>
                 <li><strong>Number of Guests:</strong> $guests</li>
                 <li><strong>Special Requests:</strong> $specialRequests</li>
             </ul>
             <p>Thank you for choosing us! We look forward to welcoming you.</p>
             <p>Best regards,<br>Restaurant Team</p>";
    $altBody = "Dear $toName,\n\nYour reservation has been successfully confirmed.\nDate: $date\nTime: $time\nNumber of Guests: $guests\nSpecial Requests: $specialRequests\n\nThank you for choosing us! We look forward to welcoming you.\n\nBest regards,\nRestaurant Team";
    
    return sendEmail($to, $toName, $subject, $body, $altBody);
}

?> 
