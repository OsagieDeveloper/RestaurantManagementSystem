<?php
    // User Authentication
    function registerUser($fullName, $email, $hashedPassword, $phoneNumber, $address, $role) {
        global $mysqli;
        $stmt = $mysqli->prepare("INSERT INTO users (full_name, email, password, phone_number, address, role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssss', $fullName, $email, $hashedPassword, $phoneNumber, $address, $role);

        return $stmt->execute();
    }

    function loginUser($username, $password) {
        global $mysqli;
        $stmt = $mysqli->prepare("SELECT email, password FROM admin WHERE email = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['email'] = $user['email'];
                return true;
            }
        }
        return false;
    }

    function loginStaff($username, $password) {
        global $mysqli;
        $stmt = $mysqli->prepare("SELECT email, password FROM users WHERE email = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['email'] = $user['email'];
                return true;
            }
        }
        return false;
    }

    function emailExists($email) {
        global $mysqli;
        $stmt = $mysqli->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    function adminEmailExists($email) {
        global $mysqli;
        $stmt = $mysqli->prepare("SELECT email FROM admin WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    function logoutUser() {
        session_unset();
        session_destroy();
    }

    function isLoggedIn() {
        return isset($_SESSION['email']);
    }

    function createReservation($customerName, $tableNumber, $dateTime, $time, $numGuests, $specialRequests) {
        global $mysqli;
        $status = 'Pending';
        $reservation_id = "r".uniqid();
        $stmt = $mysqli->prepare("INSERT INTO reservations (reservation_id, customer_name, table_number, date_time, time_of_event, num_guests, special_request, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssisssss', $reservation_id, $customerName, $tableNumber, $dateTime, $time, $numGuests, $specialRequests, $status);
        return $stmt->execute();
    }

    function viewReservations() {
        global $mysqli;
        $result = $mysqli->query("SELECT * FROM reservations ORDER BY date_time");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Check if there are available tables for the given date, time, and number of guests.
     */
    function checkTableAvailability($date, $time, $number_of_guests) {
        global $mysqli;
        
        $sql = "SELECT * FROM tables WHERE seats >= ? AND table_number NOT IN (
                    SELECT table_number FROM reservations WHERE date_time = ? AND time_of_event = ?
                )";
        
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('iss', $number_of_guests, $date, $time);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $available_tables = [];
        while ($row = $result->fetch_assoc()) {
            $available_tables[] = $row;
        }
        
        return $available_tables;
    }

    /**
     * Check if a specific table is available at a specific date/time for the number of guests.
     */
    function isTableAvailableForSpecificTime($table_id, $date, $time) {
        global $mysqli;
        
        $sql = "SELECT * FROM reservations WHERE table_number = ? AND date_time = ? AND time_of_event = ?";
        
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('iss', $table_id, $date, $time);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->num_rows === 0;
    }

    function createOrder($tableNumber, $items, $quantities, $specialRequests) {
        global $mysqli;
        $stmt = $mysqli->prepare("INSERT INTO orders (table_number, items, quantities, special_requests, status) VALUES (?, ?, ?, ?, ?)");
        $status = 'Pending';
        $stmt->bind_param('issss', $tableNumber, $items, $quantities, $specialRequests, $status);
        return $stmt->execute();
    }

    function viewOrders() {
        global $mysqli;
        $result = $mysqli->query("SELECT * FROM orders WHERE status != 'Completed' ORDER BY id ASC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function updateInventory($itemId, $quantity) {
        global $mysqli;
        $stmt = $mysqli->prepare("UPDATE inventory SET quantity_on_hand = quantity_on_hand - ? WHERE item_id = ?");
        $stmt->bind_param('ii', $quantity, $itemId);
        return $stmt->execute();
    }

    function viewInventory() {
        global $mysqli;
        $result = $mysqli->query("SELECT * FROM inventory");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function alertLowStock() {
        global $mysqli;
        $result = $mysqli->query("SELECT * FROM inventory WHERE quantity_on_hand <= reorder_level");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function createSchedule($staffId, $position, $shiftTime, $hoursWorked) {
        global $mysqli;
        $stmt = $mysqli->prepare("INSERT INTO staff_schedule (staff_id, position, shift_time, hours_worked) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('isss', $staffId, $position, $shiftTime, $hoursWorked);
        return $stmt->execute();
    }

    function viewSchedule() {
        global $mysqli;
        $result = $mysqli->query("SELECT * FROM staff_schedule ORDER BY shift_time");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function integratePOS($orderId, $paymentAmount) {
        global $mysqli;
        $stmt = $mysqli->prepare("UPDATE orders SET status = 'Completed', payment_amount = ? WHERE id = ?");
        $stmt->bind_param('di', $paymentAmount, $orderId);
        return $stmt->execute();
    }

    function secureData($input) {
        global $mysqli;
        return htmlspecialchars($mysqli->real_escape_string($input));
    }