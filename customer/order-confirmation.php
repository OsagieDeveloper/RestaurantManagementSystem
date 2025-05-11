<?php
  require_once './model/session.php';
  require_once './config/database.php';
  require_once './model/function.php';

  $page_title = 'Order Confirmation';

  // Check if order_id is provided in URL
  $order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
  $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

  if ($order_id <= 0 || $user_id <= 0) {
    header('Location: order_history.php');
    exit();
  }

  // Fetch order details
  $order_query = "SELECT o.id, o.total, o.status, o.created_at FROM orders o WHERE o.id = ? AND o.user_id = ?";
  $stmt = $mysqli->prepare($order_query);
  $stmt->bind_param("ii", $order_id, $user_id);
  $stmt->execute();
  $order_result = $stmt->get_result();

  if ($order_result->num_rows === 0) {
    header('Location: order_history.php');
    exit();
  }

  $order = $order_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php 
       require_once './public/includes/header.php';
    ?>
  </head>
  <body>
    <?php 
     
      require_once './public/includes/nav.php';
    ?>
    
    <div class="container mt-5 mb-5">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card text-center">
            <div class="card-header bg-success text-white">
              <h2 class="mb-0">Order Confirmed!</h2>
            </div>
            <div class="card-body">
              <i class="ri-checkbox-circle-line" style="font-size: 5rem; color: green;"></i>
              <h5 class="card-title mt-3">Thank you for your order!</h5>
              <p class="card-text">Your order has been placed successfully. We'll notify you once it's on its way.</p>
              
              <div class="alert alert-info mt-4" role="alert">
                <strong>Order ID:</strong> #<?php echo htmlspecialchars($order['id']); ?><br>
                <strong>Order Date:</strong> <?php echo htmlspecialchars(date('F j, Y, g:i a', strtotime($order['created_at']))); ?><br>
                <strong>Total:</strong> ₦<?php echo number_format($order['total'], 2); ?><br>
                <strong>Status:</strong> 
                <span class="badge bg-<?php 
                  switch($order['status']) {
                    case 'pending': echo 'warning'; break;
                    case 'confirmed': echo 'info'; break;
                    case 'cooking': echo 'primary'; break;
                    case 'ready': echo 'secondary'; break;
                    case 'delivered': echo 'success'; break;
                    case 'cancelled': echo 'danger'; break;
                    default: echo 'light';
                  }
                ?>">
                  <?php echo ucfirst(htmlspecialchars($order['status'])); ?>
                </span>
              </div>
              
              <div class="mt-4">
                <a href="order_details.php?id=<?php echo htmlspecialchars($order['id']); ?>" class="btn btn-primary">View Order Details</a>
                <a href="menu.php" class="btn btn-outline-secondary">Continue Shopping</a>
              </div>
            </div>
            <div class="card-footer text-muted">
              If you have any questions, please contact our support team.
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php
      require_once './public/includes/footer.php';
      require_once './public/includes/script.php';
    ?>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Get cart from localStorage
        localStorage.removeItem('cart');
        // Update cart count
        const cartCount = document.querySelector('#cart-count');
        if (cartCount) {
          cartCount.textContent = 0;    
        }
      });
    </script>
  </body>
</html>
