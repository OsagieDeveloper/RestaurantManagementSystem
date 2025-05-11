<?php
  require_once './model/session.php';
  require_once './config/database.php';
  require_once './model/function.php';

  $email = $_SESSION['email'];
  // Check if user is logged in
  $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  $page_title = 'Order History';
  $user_id = $user['id'];
  
  // Fetch order history
  $order_query = "SELECT o.id, o.total, o.status, o.created_at, COUNT(oi.menu_item_id_n) as item_count
                  FROM orders o
                  LEFT JOIN order_items oi ON o.id = oi.order_id
                  WHERE o.user_id = ?
                  GROUP BY o.id
                  ORDER BY o.created_at DESC";
  $stmt = $mysqli->prepare($order_query);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $orders_result = $stmt->get_result();
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
          <h1>Your Order History</h1>
          <p class="section__description">
            View and manage your past orders.
          </p>
        </div>
      </div>
    </header>
    
    <!-- Promotion Banner -->
    <section class="promotion-banner text-center py-4 bg-warning">
      <p class="h4 text-white mb-0"> Special Promotion: 10% Off on Your First Order! </p>
      <a href="menu.php" class="btn btn-dark mt-2">Browse Menu</a>
    </section>
    
    <section class="section__container menu__container" id="order-history">
      <p class="section__subheader">ORDER HISTORY</p>
      <h1 class="mb-4">Your Past Orders</h1>
      
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <?php if ($orders_result->num_rows > 0): ?>
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Order ID</th>
                      <th scope="col">Date</th>
                      <th scope="col">Items</th>
                      <th scope="col">Total</th>
                      <th scope="col">Status</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while ($order = $orders_result->fetch_assoc()): ?>
                      <tr>
                        <td>#<?php echo htmlspecialchars($order['id']); ?></td>
                        <td><?php echo htmlspecialchars(date('F j, Y, g:i a', strtotime($order['created_at']))); ?></td>
                        <td><?php echo htmlspecialchars($order['item_count']); ?> item<?php echo $order['item_count'] > 1 ? 's' : ''; ?></td>
                        <td>₦<?php echo number_format($order['total'], 2); ?></td>
                        <td>
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
                        </td>
                        <td>
                          <a href="order_details.php?id=<?php echo htmlspecialchars($order['id']); ?>" class="btn btn-sm btn-outline-primary">View Details</a>
                        </td>
                      </tr>
                    <?php endwhile; ?>
                  </tbody>
                </table>
              <?php else: ?>
                <tr>
                  <td colspan="6">No orders found.</td>
                </tr>
              <?php endif; ?>
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
