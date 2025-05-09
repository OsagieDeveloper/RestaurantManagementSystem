<?php

    $host = "localhost";
    $dbname = "res";
    $user = "roots";
    $password ="";

    // Database connection
    $mysqli = new mysqli($host, $user, $password, $dbname);
    
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }


