<?php
require_once '../model/session.php';
require_once '../config/database.php';
require_once '../model/function.php';
if(!isLoggedIn()){
    header("location: ../login");
    die();
}

if(isset($_POST['submit'])){  
    $total = $_POST['total'];
    $status = $_POST['status'];
    $quantity = $_POST['quantity'];
    $menu_item_id = isset($_POST['menu_item_id']) ? $_POST['menu_item_id'] : '';
    $menu_item_id_n = isset($_POST['menu_item_id_n']) ? $_POST['menu_item_id_n'] : '';
    $menu_item_id_d = isset($_POST['menu_item_id_d']) ? $_POST['menu_item_id_d'] : '';
    $menu_item_id_dr = isset($_POST['menu_item_id_dr']) ? $_POST['menu_item_id_dr'] : '';

    // Insert into orders table
    $stmt = $mysqli->prepare("INSERT INTO orders (total, status, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("sd", $total, $status);
       
    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;
        
        // Insert order items
        $stmt_items = $mysqli->prepare("INSERT INTO order_items (order_id, menu_item_id, menu_item_id_n, quantity, price) VALUES (?, ?, ?, ?, ?)");
        $error_message = '';
        
        // Function to insert item if selected
        $insertItem = function($menu_id, $menu_name, $order_id, $quantity, $stmt_items, &$error_message) use ($mysqli) {
            if (!empty($menu_id)) {
                // Fetch price from menu_items or menus table
                $price_query = $mysqli->query("SELECT price FROM menus WHERE id = '$menu_id'");
                if ($price_query && $price_query->num_rows > 0) {
                    $price_row = $price_query->fetch_assoc();
                    $price = $price_row['price'];
                } else {
                    $price = 0.00; // Default price if not found
                }
                
                $stmt_items->bind_param("iisid", $order_id, $menu_id, $menu_name, $quantity, $price);
                if (!$stmt_items->execute()) {
                    $error_message .= "Error inserting item " . $menu_name . ": " . $stmt_items->error . "<br>";
                }
            }
        };
        
        // Insert each selected item with the same quantity
        $insertItem($menu_item_id, $menu_item_id, $order_id, $quantity, $stmt_items, $error_message);
        $insertItem($menu_item_id_n, $menu_item_id_n, $order_id, $quantity, $stmt_items, $error_message);
        $insertItem($menu_item_id_d, $menu_item_id_d, $order_id, $quantity, $stmt_items, $error_message);
        $insertItem($menu_item_id_dr, $menu_item_id_dr, $order_id, $quantity, $stmt_items, $error_message);
        
        $stmt_items->close();
           
        if (empty($error_message)) {
            $success_message = "Order added successfully!";
            header("Location: orders.php?success=" . urlencode($success_message));
            exit();
        } else {
            $error_message = "Order added, but some items had issues:<br>" . $error_message;
        }
    } else {
        $error_message = "Error adding order: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch users for dropdown if needed
$users_result = $mysqli->query("SELECT id, full_name as name FROM users WHERE role = 'customer'");
$menu_items_result = $mysqli->query("SELECT id, name, price FROM menu_items");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        require_once './includes/header.php';
    ?>
    <style>
       
        
        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }
        
        h2 {
            color: #3498db;
            margin: 25px 0 15px 0;
        }
        
        .reservation-details {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 25px;
        }
        
        .detail-item {
            display: flex;
            margin-bottom: 10px;
        }
        
        .detail-label {
            font-weight: bold;
            min-width: 150px;
        }
        
        hr {
            border: 0;
            height: 1px;
            background-color: #ddd;
            margin: 30px 0;
        }
        
        .order-id {
            font-weight: bold;
            font-size: 1.1em;
            margin-bottom: 20px;
            display: block;
        }
        
        .food-selection {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin: 15px 0 25px 0;
        }
        
        .food-category {
            flex: 1;
            min-width: 200px;
        }
        
        .food-category label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }
        
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: white;
            font-size: 14px;
        }
        
        .input-group {
            margin-bottom: 20px;
        }
        
        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }
        
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .submit-btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s;
            display: block;
            margin: 30px auto 0 auto;
            margin-bottom: 5rem;
        }
        
        .submit-btn:hover {
            background-color: #2980b9;
        }
        
        @media (max-width: 768px) {
            .food-selection {
                flex-direction: column;
                gap: 15px;
            }
            
            .food-category {
                min-width: 100%;
            }
            
            .detail-item {
                flex-direction: column;
            }
            
            .detail-label {
                margin-bottom: 3px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <?php require_once './includes/sidenav.php'; ?>

        <main>
            <h1>Place an Order</h1>
            <hr>
            
            <h2>Enter Order</h2>
            
            <form method="POST">
                <div class="input-group">
                    <label for="total">Total Amount</label>
                    <input type="text" name="total" id="total" placeholder="Enter total amount..." required>
                </div>                
                <div class="input-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" required>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="cooking">Cooking</option>
                        <option value="ready">Ready</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>                
                <div class="input-group">
                    <label>Select Food</label>
                    <div class="food-selection">
                        <div class="food-category">
                            <label>Appetizers</label>
                            <select name="menu_item_id">
                                <option value="">Select Appetizer</option>
                                <?php
                                $stmt = $mysqli->prepare("SELECT * FROM menus WHERE type = 'appetizers'");
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value=" . $row['id'] . ">" . $row['name'] . " - $" . $row['price'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="food-category">
                            <label>Main Dishes</label>
                            <select name="menu_item_id_n">
                                <option value="">Select Main Dish</option>
                                <?php
                                $stmt = $mysqli->prepare("SELECT * FROM menus WHERE type = 'dishes'");
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value=" . $row['id'] . ">" . $row['name'] . " - $" . $row['price'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="food-category">
                            <label>Desserts</label>
                            <select name="menu_item_id_d">
                                <option value="">Select Dessert</option>
                                <?php
                                $stmt = $mysqli->prepare("SELECT * FROM menus WHERE type = 'dessert'");
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value=" . $row['id'] . ">" . $row['name'] . " - $" . $row['price'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="food-category">
                            <label>Drinks</label>
                            <select name="menu_item_id_dr">
                                <option value="">Select Drink</option>
                                <?php
                                $stmt = $mysqli->prepare("SELECT * FROM menus WHERE type = 'drinks'");
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value=" . $row['id'] . ">" . $row['name'] . " - $" . $row['price'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="input-group">
                    <label for="quantity">Quantity (applies to all selected items)</label>
                    <input type="number" name="quantity" id="quantity" min="1" value="1" required>
                </div>                
                
                <button class="submit-btn" type="submit" name="submit">Submit Order</button>
            </form>
        </main>
    </div>
    <?php require_once './includes/script.php'; ?>
</body>
</html>