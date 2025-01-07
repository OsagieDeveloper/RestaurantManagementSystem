<?php
    if(isset($_SESSION['email'])){
        $email = $_SESSION['email'];

        $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_assoc();

        $staff_name = $rows['full_name'];
        $staff_id = $rows['id'];
    }