<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['createReservation'])){
            // Securely capture the input data
            $name = secureData($_POST['name']);
            $date = secureData($_POST['date']);
            $time = secureData($_POST['time']);
            $number_of_guests = secureData($_POST['guests']);
            $special_requests = secureData($_POST['requests']);
            $user_id = secureData($_POST['user_id']);

            // Check for available tables for the requested date, time, and number of guests
            $available_tables = checkTableAvailability($date, $time, $number_of_guests);

            if (empty($available_tables)) {
                $err = 'No tables available for the requested time and number of guests';
            } else {
                $table_id = $available_tables[0]['table_number'];

                if (isTableAvailableForSpecificTime($table_id, $date, $time)) {
                    if (createReservation($name, $user_id, $table_id, $date, $time, $number_of_guests, $special_requests)) {
                        $suc = "Reservation Created Successfully";  
                    } else {
                        $err = "An error occurred while trying to reserve a table, please try again ".createReservation($name, $user_id, $table_id, $date, $time, $number_of_guests, $special_requests);
                    }
                } else {
                    $err = 'Selected table is not available for the requested time';
                }
            }
            
        } else {
            $err = 'Invalid request method';
        }
    }