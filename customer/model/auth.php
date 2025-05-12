<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['signin'])){
            $email = secureData($_POST['email']);
            $password = $_POST['password'];
            $role = $_POST['role'];

            if(empty($email) || empty($password)){
                $err = "All fields are required";
            }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $err = "Invalid email address provided";
            }else if(!emailExists($email) && !adminEmailExists($email)){
                $err = "No profile found, please create an account to proceed";
            }else{
                if($role === 'Staff'){
                    if (loginStaff($email, $password)) {
                        $suc = "Login Successful";
                        header('Location: ./staff');
                        exit();
                    } else {
                        $err = "Invalid credentials.";
                    }
                }else if($role === 'Admin'){
                    if (loginUser($email, $password)) {
                        $suc = "Login Successful";
                        header('Location: ./admin');
                        exit();
                    } else {
                        $err = "Invalid credentials.";
                    }
                }else if($role === 'Customer'){
                    if (loginStaff($email, $password)) {
                        $suc = "Login Successful";
                        header('Location: ./');
                        exit();
                    } else {
                        $err = "Invalid credentials.";
                    }
                }                
            }            
        }else if (isset($_POST['signup'])) {
            $fullName = secureData($_POST['name']);
            $email = secureData($_POST['email']);
            $password = $_POST['password'];
            $phoneNumber = secureData($_POST['mobile']);
            $address = secureData($_POST['address']);
            $role = secureData($_POST['role']);
        
            // Check if all fields are filled
            if (empty($fullName) || empty($email) || empty($password) || empty($phoneNumber) || empty($address)) {
                $err2 = "All fields are required";
            } else {
                // Validate email format
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $err2 = "Invalid email format.";
                } else {
                    // Validate password strength (minimum 8 characters, at least one uppercase, one lowercase, one number, and one special character)
                    $passwordPattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
                    if (!preg_match($passwordPattern, $password)) {
                        $err2 = "Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.";
                    } else {
                        // Check if email already exists
                        if (emailExists($email)) {
                            $err2 = "Email already exists. Please use a different email.";
                        } else {
                            // Hash the password
                            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
                            // Register user
                            if (registerUser($fullName, $email, $hashedPassword, $phoneNumber, $address, $role)) {
                                $suc2 = "Registration successful, click on signin to continue";
                            } else {
                                $err2 = "Signup failed. Please try again.";
                            }
                        }
                    }
                }
            }
        }        
    }