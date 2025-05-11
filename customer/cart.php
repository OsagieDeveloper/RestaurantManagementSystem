<?php
  require_once './model/session.php';
  require_once './config/database.php';
  require_once './model/function.php';

$page_title = 'Your Cart';
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
          <h1>Your Shopping Cart</h1>
          <p class="section__description">
            Review the items in your cart before proceeding to payment.
          </p>
        </div>
      </div>
    </header>
    
    <!-- Promotion Banner -->
    <section class="promotion-banner text-center py-4 bg-warning">
      <p class="h4 text-white mb-0">🍔 Special Promotion: 10% Off on Your First Order! 🍕</p>
      <a href="menu.php" class="btn btn-dark mt-2">Browse Menu</a>
    </section>
    
    <section class="section__container menu__container" id="cart">
      <p class="section__subheader">SHOPPING CART</p>
      <h1 class="mb-4">Items in Your Cart</h1>
      
      <div class="row">
        <div class="col-lg-8">
          <div class="card">
            <div class="card-body">
              <table class="table" id="cart-table">
                <thead>
                  <tr>
                    <th scope="col">Item</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Cart items will be populated by JavaScript -->
                </tbody>
              </table>
              
              <div id="empty-cart-message" class="text-center d-none">
                <p class="text-muted">Your cart is empty. <a href="menu.php">Browse our menu</a> to add items.</p>
              </div>
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
              <div class="mt-3 d-grid gap-2">
                <a href="payment" class="btn btn-primary btn-lg" id="checkout-btn">Proceed to Payment</a>
              </div>
              <div class="mt-2 d-grid gap-2">
                <a href="menu" class="btn btn-outline-secondary">Continue Shopping</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Get cart from localStorage
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        
        // Update cart count in navigation
        const cartCount = document.querySelector('#cart-count');
        if (cartCount) {
          cartCount.textContent = cart.length;
        }
        
        // Function to update cart table
        function updateCartTable() {
          const cartTableBody = document.querySelector('#cart-table tbody');
          const subtotalElement = document.querySelector('#subtotal');
          const totalElement = document.querySelector('#total');
          cartTableBody.innerHTML = '';
          let subtotal = 0;
          if (cart.length === 0) {
            cartTableBody.innerHTML = '<tr><td colspan="5" class="text-center">Your cart is empty.</td></tr>';
          } else {
            cart.forEach((item, index) => {
              const price = item.price * item.quantity;
              subtotal += price;
              const imagePath = item.image ? `../public/assets/img/menu/${item.image.split('/').pop()}` : '../public/assets/img/placeholder-food.jpg';
              const row = document.createElement('tr');
              row.innerHTML = `
                <td>
                  <div class="d-flex align-items-center">
                    <span>${item.name}</span>
                  </div>
                </td>
                <td>$${item.price.toFixed(2)}</td>
                <td>
                  <div class="input-group input-group-sm" style="width: 120px;">
                    <button class="btn btn-outline-secondary decrease-quantity" type="button" data-index="${index}">-</button>
                    <input type="text" class="form-control text-center quantity-input" value="${item.quantity}" readonly>
                    <button class="btn btn-outline-secondary increase-quantity" type="button" data-index="${index}">+</button>
                  </div>
                </td>
                <td>$${price.toFixed(2)}</td>
                <td>
                  <button type="button" class="btn btn-sm btn-danger remove-item" data-index="${index}">Remove</button>
                </td>
              `;
              cartTableBody.appendChild(row);
            });
          }
          subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
          totalElement.textContent = `$${subtotal.toFixed(2)}`;
        }
        updateCartTable();
        // Event listeners for cart actions
        document.querySelector('#cart-table').addEventListener('click', function(event) {
          const target = event.target;
          if (target.classList.contains('decrease-quantity')) {
            const index = parseInt(target.getAttribute('data-index'));
            if (cart[index].quantity > 1) {
              cart[index].quantity--;
              localStorage.setItem('cart', JSON.stringify(cart));
              updateCartTable();
              if (cartCount) cartCount.textContent = cart.reduce((total, item) => total + item.quantity, 0);
            }
          } else if (target.classList.contains('increase-quantity')) {
            const index = parseInt(target.getAttribute('data-index'));
            cart[index].quantity++;
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartTable();
            if (cartCount) cartCount.textContent = cart.reduce((total, item) => total + item.quantity, 0);
          } else if (target.classList.contains('remove-item')) {
            const index = parseInt(target.getAttribute('data-index'));
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartTable();
            if (cartCount) cartCount.textContent = cart.reduce((total, item) => total + item.quantity, 0);
          }
        });
        // Checkout button
        document.querySelector('#checkout-btn').addEventListener('click', function() {
          if (cart.length > 0) {
            window.location.href = 'payment.php';
          } else {
            alert('Your cart is empty. Add items to proceed to checkout.');
          }
        });
      });
    </script>
    
    <?php
      require_once './public/includes/footer.php';
    ?>
  </body>
</html>
