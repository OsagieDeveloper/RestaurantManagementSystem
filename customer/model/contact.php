<?php


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['contactForm'])){
            if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
                die("Bot submission detected!");
            }

            $contact_name = isset($_POST['contact_name']) ? htmlspecialchars(trim($_POST['contact_name'])) : '';
            $contact_email = isset($_POST['contact_email']) ? filter_var(trim($_POST['contact_email']), FILTER_SANITIZE_EMAIL) : '';
            $inquiry_type = isset($_POST['inquiry_type']) ? htmlspecialchars(trim($_POST['inquiry_type'])) : '';
            $contact_message = isset($_POST['contact_message']) ? htmlspecialchars(trim($_POST['contact_message'])) : '';

            if(empty($contact_name) || empty($contact_email) || empty($inquiry_type) || empty($contact_message)){
                $err = "All fields are required";
            }else if (!filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
                $err = "Invalid email address.";
            }else if (empty($contact_name) || empty($contact_email) || empty($inquiry_type) || empty($contact_message)) {
                $err = "Please fill in all fields.";
            }else{
                $stmt = $mysqli->prepare("INSERT INTO contact_inquiries (name, email, inquiry_type, message) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $contact_name, $contact_email, $inquiry_type, $contact_message);

                if ($stmt->execute()) {
                    $suc = "Your inquiry has been submitted. We will get back to you shortly.";
                } else {
                    $err = "Error submitting your inquiry. Please try again later.";
                }

                $stmt->close();
            }
        }
    }