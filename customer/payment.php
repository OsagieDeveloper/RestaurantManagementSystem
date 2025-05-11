<?php
  require_once './model/session.php';
  require_once './config/database.php';
  require_once './model/function.php';

  $page_title = 'Payment';


 
  // Fallback: If user_id is not in session but email is, fetch user_id from database
  if (!isset($_SESSION['user_id']) && isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();
      $_SESSION['user_id'] = $user['id'];
    }
  }

  // Process order if form is submitted
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
      $user_id = $_SESSION['user_id'];
      $total = isset($_POST['total']) ? floatval($_POST['total']) : 0;
      $order_items = json_decode($_POST['cart_items'], true);

      if ($total > 0 && !empty($order_items)) {
        // Create order
        $order_query = "INSERT INTO orders (user_id, total, status, created_at) VALUES (?, ?, 'pending', NOW())";
        $stmt = $mysqli->prepare($order_query);
        if ($stmt === false) {
          $error_message = "Prepare failed: " . $mysqli->error;
        } else {
          $stmt->bind_param("id", $user_id, $total);
          
          if ($stmt->execute()) {
            $order_id = $stmt->insert_id;
            
            // Insert order items
            $item_query = "INSERT INTO order_items (order_id, menu_item_id_n, quantity, price) VALUES (?, ?, ?, ?)";
            $stmt_item = $mysqli->prepare($item_query);
            if ($stmt_item === false) {
              $error_message = "Prepare failed for order items: " . $mysqli->error;
            } else {
              foreach ($order_items as $item) {
                $menu_item_id_n = $item['id'];
                $quantity = $item['quantity'];
                $price = $item['price'];
                $stmt_item->bind_param("isdd", $order_id, $menu_item_id_n, $quantity, $price);
                if (!$stmt_item->execute()) {
                  $error_message = "Failed to insert order item: " . $stmt_item->error;
                  break;
                }
              }
              
              if (!isset($error_message)) {
                // Clear the cart
                echo "<script>localStorage.removeItem('cart');</script>";
                
                $success_message = "Order placed successfully! Your order ID is #$order_id.";
                header("Location: order-confirmation.php?id=$order_id&success=1");
                exit();
              }
            }
          } else {
            $error_message = "Failed to place order: " . $stmt->error;
          }
        }
      } else {
        $error_message = "Invalid order data.";
      }
    } else {
      $error_message = "User not logged in. Please log in to place an order.";
      header('Location: login');
      exit();
    }
  }
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
          <h1>Complete Your Order</h1>
          <p class="section__description">
            Finalize your purchase by reviewing your items and providing payment information.
          </p>
        </div>
      </div>
    </header>
    
    <!-- Promotion Banner -->
    <section class="promotion-banner text-center py-4 bg-warning">
      <p class="h4 text-white mb-0">🍔 Special Promotion: 10% Off on Your First Order! 🍕</p>
      <a href="menu.php" class="btn btn-dark mt-2">Browse Menu</a>
    </section>
    
    <section class="section__container menu__container" id="payment">
      <p class="section__subheader">PAYMENT</p>
      <h1 class="mb-4">Payment Details</h1>
      
      <?php if (isset($success_message)): ?>
        <div class="alert alert-success" role="alert">
          <?php echo htmlspecialchars($success_message); ?>
          <br>
          <a href="order_history.php" class="btn btn-primary mt-2">View Order History</a>
        </div>
      <?php elseif (isset($error_message)): ?>
        <div class="alert alert-danger" role="alert">
          <?php echo htmlspecialchars($error_message); ?>
        </div>
      <?php else: ?>
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h5 class="mb-0">Order Summary</h5>
              </div>
              <div class="card-body">
                <div id="order-summary">
                  <p>Items will be listed here...</p>
                </div>
                <div class="d-flex justify-content-between mb-2">
                  <span>Subtotal</span>
                  <span id="subtotal">$0.00</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                  <span>Tax (5%)</span>
                  <span id="tax">$0.00</span>
                </div>
                <div class="d-flex justify-content-between total-price mt-2 pt-2 border-top">
                  <span>Total</span>
                  <span id="total">$0.00</span>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h5 class="mb-0">Payment Information</h5>
              </div>
              <div class="card-body">
                <p class="text-muted">Please enter your payment details below.</p>
                <form id="payment-form" method="POST">
                  <input type="hidden" name="total" id="hidden-total" value="0">
                  <input type="hidden" name="cart_items" id="hidden-cart-items" value="">
                  <div class="mb-3">
                    <label for="card-number" class="form-label">Card Number</label>
                    <input type="text" class="form-control" id="card-number" placeholder="1234 5678 9012 3456">
                  </div>
                  <div class="row mb-3">
                    <div class="col">
                      <label for="expiry-date" class="form-label">Expiry Date</label>
                      <input type="text" class="form-control" id="expiry-date" placeholder="MM/YY">
                    </div>
                    <div class="col">
                      <label for="cvv" class="form-label">CVV</label>
                      <input type="text" class="form-control" id="cvv" placeholder="123">
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="name-on-card" class="form-label">Name on Card</label>
                    <input type="text" class="form-control" id="name-on-card" placeholder="John Doe">
                  </div>
                  <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">Place Order </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </section>

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
            
          
          let subtotal = 0;
          cart.forEach(item => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;
            const itemDiv = document.createElement('div');
            itemDiv.className = 'd-flex justify-content-between mb-2';
            itemDiv.innerHTML = `<span>${item.name} x ${item.quantity}</span><span>$${itemTotal.toFixed(2)}</span>`;
            orderSummary.appendChild(itemDiv);
          });
          
          let tax = subtotal * 0.05;
          let total = subtotal + tax;
          
          document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
          document.getElementById('tax').textContent = `$${tax.toFixed(2)}`;
          document.getElementById('total').textContent = `$${total.toFixed(2)}`;
          
          // Set hidden form fields
          document.getElementById('hidden-total').value = total;
          document.getElementById('hidden-cart-items').value = JSON.stringify(cart);
        }
        
        updateOrderSummary();
      });
    </script>
    
    <?php
      require_once './public/includes/footer.php';
    ?>
  </body>
</html>
