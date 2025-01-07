<?php
    require_once './session.php';
    require_once '../config/database.php';
    require_once './function.php';

    if (isset($_POST['update_status'])) {
        $reservationId = secureData($_POST['reservation_id']);
        $newStatus = secureData($_POST['status']);
        
        $updateQuery = "UPDATE reservations SET status = ? WHERE reservation_id = ?";
        $stmt = $mysqli->prepare($updateQuery);
        $stmt->bind_param('ss', $newStatus, $reservationId);
        if ($stmt->execute()) {
            echo "Reservation status updated successfully"; 
        } else {
            echo "Failed to update the reservation status";
        }
        $stmt->close();
    }

?>