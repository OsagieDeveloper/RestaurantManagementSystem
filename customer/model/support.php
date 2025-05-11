<?php

require_once './session.php';
require_once '../config/database.php';
require_once './function.php';

// Create the support_queries table if it doesn't exist
function createSupportQueriesTable() {
    global $mysqli;
    
    $query = "CREATE TABLE IF NOT EXISTS support_queries (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        subject VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        status ENUM('Pending', 'Resolved') DEFAULT 'Pending',
        created_at DATETIME NOT NULL,
        resolved_at DATETIME NULL
    )";
    
    if (!$mysqli->query($query)) {
        die("Error creating support_queries table: " . $mysqli->error);
    }
}

// Call the function to create the table when this file is included
createSupportQueriesTable();

?>
