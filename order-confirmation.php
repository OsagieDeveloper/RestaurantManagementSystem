<?php
    require_once './model/session.php';
    require_once './config/database.php';
    require_once './model/function.php';
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
                <h2 class="text-center mb-4">Order Confirmation</h2>
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Thank You for Your Order!</h4>
                    <p>Your order has been placed successfully. You will receive a confirmation email shortly with the details of your order.</p>
                    <hr>
                    <p class="mb-0">If you have any questions, please feel free to contact us.</p>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="menu.php" class="btn btn-primary">Back to Menu</a>
                    <a href="track-order.php" class="btn btn-outline-primary">Track Order</a>
                </div>
            </div>
        </section>

        <?php
        require_once './public/includes/footer.php';
        require_once './public/includes/script.php';
        ?>
    </body>
</html>
