<?php
    require_once './session.php';
    require_once '../config/database.php';
    require_once './function.php';

    $current_date = date('Y-m-d H:i:s');
    $reminder_time = date('Y-m-d H:i:s', strtotime('+1 day'));

    $sql = "
        SELECT r.name, r.date, r.time, r.number_of_guests, r.special_requests, r.table_id, r.email
        FROM reservations r
        WHERE CONCAT(r.date, ' ', r.time) = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $reminder_time);
    $stmt->execute();
    $result = $stmt->get_result();

    $reservations = [];
    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }

    foreach ($reservations as $reservation) {
        $subject = "Upcoming Reservation Reminder";
        $message = "
        Dear {$reservation['name']},\n\n
        This is a reminder for your upcoming reservation.\n
        Date: {$reservation['date']}\n
        Time: {$reservation['time']}\n
        Number of Guests: {$reservation['number_of_guests']}\n
        Special Requests: {$reservation['special_requests']}\n\n
        We look forward to serving you.\n\n
        Regards,\nRestaurant Team
        ";

        $to = $reservation['email']; 
        $headers = "From: restaurant@example.com";

        // Send the reminder email
        if (mail($to, $subject, $message, $headers)) {
            echo "Reminder sent to: {$reservation['email']}\n";
        } else {
            echo "Failed to send reminder to: {$reservation['email']}\n";
        }
    }

    $stmt->close();