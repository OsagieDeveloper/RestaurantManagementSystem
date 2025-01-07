<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['submitFeedback'])){
            if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
                die("Bot submission detected!");
            }

            // Validate and sanitize the inputs
            $rating = isset($_POST['rating']) ? (int) $_POST['rating'] : 0;
            $dish_review = isset($_POST['dish_review']) ? htmlspecialchars($_POST['dish_review']) : '';
            $general_feedback = isset($_POST['general_feedback']) ? htmlspecialchars($_POST['general_feedback']) : '';

            if(empty($dish_review) || empty($general_feedback)){
                $err = "All fields are required";
            }else if ($rating < 1 || $rating > 5) {
                $err = "Invalid rating.";
            }else{
                // Insert feedback into the database
                $stmt = $mysqli->prepare("INSERT INTO feedbacks (rating, dish_review, general_feedback) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $rating, $dish_review, $general_feedback);

                if ($stmt->execute()) {
                    $suc = "Thank you for your feedback!";
                } else {
                    $err = "Error submitting feedback. Please try again later.";
                }

                $stmt->close();
            }
        }
    }