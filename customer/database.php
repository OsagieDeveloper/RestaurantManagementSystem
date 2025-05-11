<?php


    // require_once 'Environment.php';

    // $env = Environment::getEnvVariables();
    // $host = $env['DB_HOST'];
    // $dbname = $env['DB_NAME'];
    // $user = $env['DB_USER'];
    // $password = $env['DB_PASSWORD'];

    $host = "localhost";
    $dbname = "restaurant";
    $user = "root";
    $password = "";

    // Database connection
    $mysqli = new mysqli($host, $user, $password, $dbname);
    
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

