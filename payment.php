<?php
    require_once './model/session.php';
    require_once './config/database.php';
    require_once './model/function.php';

    // Check if amount and food type are passed in URL
    if (!isset($_GET['amount']) || !isset($_GET['food'])) {
        header('Location: ./menu');
        exit;
    }

    $totalAmount = floatval($_GET['amount']);
    $foodType = urldecode($_GET['food']);

    // Handle payment form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment_method'])) {
        $paymentMethod = secureData($_POST['payment_method']);
        $customerName = secureData($_POST['customer_name']);
        $customerEmail = secureData($_POST['customer_email']);
        

        // Save order to database (simplified example)
        $items = json_encode(array(array('name' => $foodType, 'price' => $totalAmount, 'quantity' => 1)));
        $quantities = json_encode(array(1));
        $specialRequests = secureData($_POST['special_requests']);
        $tableNumber = isset($_POST['table_number']) ? secureData($_POST['table_number']) : 0;
        
        if (createOrder($tableNumber, $items, $quantities, $specialRequests)) {
            // Redirect to confirmation page
            header('Location: order-confirmation.php');
            exit;
        } else {
            $errorMessage = "There was an error processing your order. Please try again.";
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
            <?php require_once './public/includes/nav.php'; ?>
        </header>

        <section class="d-flex align-items-center justify-content-center vh-100 bg-light">
            <div style="max-width: 500px; width: 100%;">
                <h2 class="text-center mb-4">Payment Details</h2>
                <?php 
                    if (isset($successMessage)) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $successMessage; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } else if (isset($errorMessage)) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $errorMessage; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php }
                ?>
                <p class="text-center mb-4 text-muted">
                    Complete your order for <?php echo htmlspecialchars($foodType); ?> totaling $<?php echo number_format($totalAmount, 2); ?>.
                </p>
                
                <form method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Full Name</label>
                        <input
                            type="text"
                            id="customer_name"
                            name="customer_name"
                            class="form-control"
                            placeholder="Your Full Name"
                            required
                        />
                        <div class="invalid-feedback">Please enter your name.</div>
                    </div>
                    <div class="mb-3">
                        <label for="customer_email" class="form-label">Email Address</label>
                        <input
                            type="email"
                            id="customer_email"
                            name="customer_email"
                            class="form-control"
                            placeholder="Your Email Address"
                            required
                        />
                        <div class="invalid-feedback">Please enter a valid email address.</div>
                    </div>
                    <div class="mb-3">
                        <label for="special_requests" class="form-label">Special Requests (Optional)</label>
                        <textarea
                            id="special_requests"
                            name="special_requests"
                            rows="3"
                            class="form-control"
                            placeholder="Any special requests for your order?"
                        ></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Payment Information</label>
                        <input type="hidden" name="payment_method" value="Card">
                        <div class="mb-3">
                            <label for="card_number" class="form-label">Card Number</label>
                            <input type="number" id="card_number" name="card_number" class="form-control" placeholder="1234 5678 9012 3456" maxlength="19" required>
                            <div class="invalid-feedback">Please enter a valid card number.</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="expiry_date" class="form-label">Expiry Date</label>
                                <input type="date" id="expiry_date" name="expiry_date" class="form-control" placeholder="MM/YY" maxlength="5" required>
                                <div class="invalid-feedback">Please enter a valid expiry date.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="text" id="cvv" name="cvv" class="form-control" placeholder="123" maxlength="3" required>
                                <div class="invalid-feedback">Please enter a valid CVV.</div>
                            </div>
                        </div>
                        <!-- In a real implementation, you would integrate with a payment gateway API -->
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Complete Payment</button>
                </form>
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
