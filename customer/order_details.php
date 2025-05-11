<?php
  require_once './model/session.php';
  require_once './config/database.php';
  require_once './model/function.php';

  $email = $_SESSION['email'];
  $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  // Check if order ID is provided
  if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: order_history.php');
    exit();
  }

  $page_title = 'Order Details';
  $user_id = $user['id'];
  $order_id = intval($_GET['id']);
  
  // Fetch order details
  $order_query = "SELECT o.id, o.total, o.status, o.created_at
                  FROM orders o
                  WHERE o.id = ? AND o.user_id = ?";
  $stmt = $mysqli->prepare($order_query);
  $stmt->bind_param("ii", $order_id, $user_id);
  $stmt->execute();
  $order_result = $stmt->get_result();
  
  if ($order_result->num_rows === 0) {
    header('Location: order_history');
    exit();
  }
  
  $order = $order_result->fetch_assoc();
  
  // Fetch order items
  $items_query = "SELECT oi.menu_item_id_n, oi.quantity, oi.price, m.name, m.image
                  FROM order_items oi
                  JOIN menus m ON oi.menu_item_id_n = m.id
                  WHERE oi.order_id = ?";
  $stmt_items = $mysqli->prepare($items_query);
  $stmt_items->bind_param("i", $order_id);
  $stmt_items->execute();
  $items_result = $stmt_items->get_result();
?>

<!DOCTYPE html>
<html lang="en">
  <?php 
    require_once './public/includes/header.php';
  ?>
  <body>
    <header>
      <?php
        require_once './public/includes/nav.php';
      ?>
      <div class="section__container header__container" id="home">
        <div class="header__content text-center">
          <h1>Order Details</h1>
          <p class="section__description">
            View the details of your past order.
          </p>
        </div>
      </div>
    </header>
    
    <!-- Promotion Banner -->
    <section class="promotion-banner text-center py-4 bg-warning">
      <p class="h4 text-white mb-0">🍔 Special Promotion: 10% Off on Your First Order! 🍕</p>
      <a href="menu.php" class="btn btn-dark mt-2">Browse Menu</a>
    </section>
    
    <section class="section__container menu__container" id="order-details">
      <p class="section__subheader">ORDER DETAILS</p>
      <div class="accordion" id="accordionExample">
        <div class="card mb-3">
          <div class="card-header" id="headingOne">
            <h2 class="mb-0">
              <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Order #<?php echo htmlspecialchars($order['id']); ?> - <?php echo htmlspecialchars(date('F j, Y, g:i a', strtotime($order['created_at']))); ?>
              </button>
            </h2>
          </div>
          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="card-body">
              <div class="row mb-3">
                <div class="col-md-6">
                  <p class="mb-2"><strong>Total:</strong> ₦<?php echo number_format($order['total'], 2); ?></p>
                  <p class="mb-2"><strong>Status:</strong> 
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
                  </p>
                </div>
                <div class="col-md-6 text-md-end">
                  <a href="order_history.php" class="btn btn-outline-primary btn-sm">Back to Order History</a>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-8">
                  <div class="card mb-3">
                    <div class="card-header">
                      <h5 class="mb-0">Order Items</h5>
                    </div>
                    <div class="card-body">
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Item</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php while ($item = $items_result->fetch_assoc()): ?>
                            <tr>
                              <td>
                                <div class="d-flex align-items-center">
                                  <span><?php echo htmlspecialchars($item['name']); ?></span>
                                </div>
                              </td>
                              <td>$<?php echo htmlspecialchars(number_format($item['price'], 2)); ?></td>
                              <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                              <td>$<?php echo htmlspecialchars(number_format($item['price'] * $item['quantity'], 2)); ?></td>
                            </tr>
                          <?php endwhile; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                
                <div class="col-lg-4">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                      <div class="d-flex justify-content-between mb-2">
                        <span>Order Date</span>
                        <span><?php echo htmlspecialchars(date('Y-m-d H:i', strtotime($order['created_at']))); ?></span>
                      </div>
                      <div class="d-flex justify-content-between mb-2">
                        <span>Status</span>
                        <span>
                          <span class="badge bg-<?php 
                            switch ($order['status']) {
                              case 'pending': echo 'warning'; break;
                              case 'confirmed': echo 'info'; break;
                              case 'cooking': echo 'primary'; break;
                              case 'ready': echo 'secondary'; break;
                              case 'delivered': echo 'success'; break;
                              case 'cancelled': echo 'danger'; break;
                              default: echo 'light';
                            }
                          ?>">
                            <?php echo htmlspecialchars(ucfirst($order['status'])); ?>
                          </span>
                        </span>
                      </div>
                      <hr>
                      <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>$<?php echo htmlspecialchars(number_format($order['total'] / 1.05, 2)); ?></span>
                      </div>
                      <div class="d-flex justify-content-between mb-2">
                        <span>Tax (5%)</span>
                        <span>$<?php echo htmlspecialchars(number_format($order['total'] - ($order['total'] / 1.05), 2)); ?></span>
                      </div>
                      <div class="d-flex justify-content-between total-price mt-2 pt-2 border-top">
                        <span>Total</span>
                        <span>$<?php echo htmlspecialchars(number_format($order['total'], 2)); ?></span>
                      </div>
                      <div class="mt-3 d-grid gap-2">
                        <a href="order_history.php" class="btn btn-outline-secondary">Back to Order History</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <?php
      require_once './public/includes/footer.php';
    ?>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Get cart from localStorage
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const orderSummary = document.getElementById('order-summary');
        
        // Function to update order summary
        function updateOrderSummary() {
          orderSummary.innerHTML = '';
          if (cart.length === 0) {
            orderSummary.innerHTML = '<p class="text-muted">Your cart is empty.</p>';
            return;
          }else{
            document.getElementById('cart-count').textContent = cart.length;    
          }
        }                          
      })
    </script>
  </body>
</html>
