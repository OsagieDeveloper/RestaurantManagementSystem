<?php
    require_once './model/session.php';
    require_once './config/database.php';
    require_once './model/function.php';

    $order = null;
    $errorMessage = '';
    $successMessage = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['trackOrder'])) {
        $orderId = secureData($_POST['order_id']);
        
        // Fetch order details (simplified example - in a real system, you would query by order ID)
        $query = "SELECT * FROM orders WHERE id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $order = $result->fetch_assoc();
            $successMessage = "Order found! Here are the details.";
        } else {
            $errorMessage = "No order found with the provided ID. Please check and try again.";
        }
        $stmt->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <?php 
        require_once './public/includes/header.php';
    ?>
    <body>
        <header>
            <?php require_once './public/includes/nav.php'; ?>
        </header>

        <section class="d-flex align-items-center justify-content-center vh-100 bg-light">
            <div style="max-width: 700px; width: 100%;">
                <h2 class="text-center mb-4">Track Your Order</h2>
                <?php 
                    if (!empty($successMessage)) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $successMessage; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } else if (!empty($errorMessage)) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $errorMessage; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php }
                ?>
                <p class="text-center mb-4 text-muted">
                    Enter your order ID to track the status of your order.
                </p>
                <form method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="order_id" class="form-label">Order ID</label>
                        <input
                            type="text"
                            id="order_id"
                            name="order_id"
                            class="form-control"
                            placeholder="Your Order ID"
                            required
                        />
                        <div class="invalid-feedback">Please enter your order ID.</div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" name="trackOrder">Track Order</button>
                </form>
                
                <?php if ($order): ?>
                    <div class="card mt-4">
                        <div class="card-header">Order Details</div>
                        <div class="card-body">
                            <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order['id']); ?></p>
                            <p><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
                            <p><strong>Items:</strong> <?php echo htmlspecialchars($order['items']); ?></p>
                            <p><strong>Special Requests:</strong> <?php echo htmlspecialchars($order['special_requests']); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php
        require_once './public/includes/footer.php';
        require_once './public/includes/script.php';
        ?>
        <script>
            // Bootstrap form validation
            (() => {
                'use strict';
                const forms = document.querySelectorAll('.needs-validation');
                Array.from(forms).forEach(form => {
                    form.addEventListener(
                        'submit',
                        event => {
                            if (!form.checkValidity()) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        },
                        false
                    );
                });
            })();
        </script>
    </body>
</html>
