<?php
require_once './model/session.php';
require_once './config/database.php';
require_once './model/function.php';
require_once './model/reservation.php';

// Check if the reservation ID is submitted
$reservationDetails = null;
if (isset($_POST['trackReservation'])) {
    $reservationId = secureData($_POST['reservation_id']);
    
    // Query to fetch reservation details
    $query = "SELECT reservation_id, customer_name, table_number, date_time, num_guests, status 
              FROM reservations WHERE reservation_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $reservationId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $reservationDetails = $result->fetch_assoc();
    } else {
        $errorMessage = "No reservation found with the provided ID.";
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
            <h2 class="text-center mb-4">Track Your Reservation</h2>
            <?php 
                if (isset($errorMessage)) { ?>
                    <p style="color: red;"><?php echo $errorMessage; ?></p>
                <?php }
            ?>
            <p class="text-center mb-4 text-muted">
                Enter your reservation ID below to track your reservation.
            </p>
            <form method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="reservation_id" class="form-label">Reservation ID</label>
                    <input
                        type="text"
                        id="reservation_id"
                        name="reservation_id"
                        class="form-control"
                        placeholder="Enter your Reservation ID"
                        required
                    />
                    <div class="invalid-feedback">Please enter your reservation ID.</div>
                </div>
                <button type="submit" class="btn btn-primary w-100" name="trackReservation">Track Reservation</button>
            </form>

            <?php if ($reservationDetails): ?>
                <div class="mt-4 p-3 border rounded bg-white">
                    <h4 class="text-center">Reservation Details</h4>
                    <p><strong>Reservation ID:</strong> <?php echo htmlspecialchars($reservationDetails['reservation_id']); ?></p>
                    <p><strong>Customer Name:</strong> <?php echo htmlspecialchars($reservationDetails['customer_name']); ?></p>
                    <p><strong>Table Number:</strong> <?php echo htmlspecialchars($reservationDetails['table_number']); ?></p>
                    <p><strong>Date and Time:</strong> <?php echo htmlspecialchars($reservationDetails['date_time']); ?></p>
                    <p><strong>Number of Guests:</strong> <?php echo htmlspecialchars($reservationDetails['num_guests']); ?></p>
                    <p><strong>Status:</strong> 
                        <span style="color: <?php echo ($reservationDetails['status'] === "Pending" || $reservationDetails['status'] === "Cancelled") ? 'red' : 'green'; ?>">
                            <?php echo htmlspecialchars($reservationDetails['status']); ?>
                        </span>
                    </p>
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
