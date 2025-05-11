<?php

    $host = "localhost";
    $dbname = "restaurant";
    $user = "root";
    $password ="";

    // Database connection
    $mysqli = new mysqli($host, $user, $password, $dbname);
    
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }


