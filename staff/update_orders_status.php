<?php
  require_once '../config/database.php';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    // Validate status value against allowed enum values
    $allowed_statuses = ['pending', 'confirmed', 'cooking', 'ready', 'delivered', 'cancelled'];
    if (!in_array($status, $allowed_statuses)) {
      echo json_encode(['success' => false, 'message' => 'Invalid status value']);
      exit();
    }

    // Update order status
    $query = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("si", $status, $order_id);
    
    if ($stmt->execute()) {
      echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
    } else {
      echo json_encode(['success' => false, 'message' => 'Failed to update status']);
    }
    $stmt->close();
  } else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
  }

  $mysqli->close();
?>
