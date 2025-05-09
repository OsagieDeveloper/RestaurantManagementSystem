<?php
require_once '../model/session.php';
require_once '../config/database.php';
require_once '../model/function.php';

if (!isLoggedIn()) {
    header("location: ../login");
    die();
}

require_once './includes/details.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once './includes/header.php'; ?>
<body>
    <div class="container">
        <?php require_once './includes/sidenav.php'; ?>

        <main>
            <h1>Dashboard</h1>

            <div class="recent-order reservation-table">
                <h2>Reservation List</h2>

                <?php if (isset($successMessage)): ?>
                    <div style="color: green;"><?php echo $successMessage; ?></div>
                <?php endif; ?>
                <?php if (isset($errorMessage)): ?>
                    <div style="color: red;"><?php echo $errorMessage; ?></div>
                <?php endif; ?>

                <table>
                    <thead>
                        <tr>
                            <th>Reservation ID</th>
                            <th>Customer Name</th>
                            <th>Table Number</th>
                            <th>Reservation Date</th>
                            <th>Seats</th>
                            <th>Special Requests</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        // Query to fetch all reservations from the database
                        $query = "SELECT reservation_id, customer_name, table_number, date_time, num_guests, special_request, status FROM reservations";
                        $result = $mysqli->query($query);

                        // Check if there are results
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['reservation_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['table_number']); ?></td>
                                    <td><?php echo htmlspecialchars($row['date_time']); ?></td>
                                    <td><?php echo htmlspecialchars($row['num_guests']); ?></td>
                                    <td><?php echo htmlspecialchars($row['special_request']); ?></td>
                                    <td>
                                        <span style="color: <?php echo (htmlspecialchars($row['status']) === "Pending" || htmlspecialchars($row['status']) === "Cancelled") ? 'red' : 'green'; ?>">
                                            <?php echo htmlspecialchars($row['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <select class="status-select" data-reservation-id="<?php echo htmlspecialchars($row['reservation_id']); ?>" style="border: 1px solid #ccc; padding: 5px;">
                                            <option value="Pending" <?php echo $row['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="Confirmed" <?php echo $row['status'] == 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                            <option value="Completed" <?php echo $row['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                            <option value="Cancelled" <?php echo $row['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                        </select>
                                    </td>
                                </tr>
                            <?php }
                        } else {
                            echo "<tr><td colspan='8'>No reservations found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>

        <?php require_once './includes/right-sidenav.php'; ?>
    </div>

    <?php require_once './includes/script.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle the status change
            $(".status-select").on("change", function(e) {
                e.preventDefault()
                var reservationId = $(this).data('reservation-id');
                var newStatus = $(this).val();

                console.log(reservationId);

                // Send the updated status using AJAX
                $.ajax({
                    url: '../model/update-reservation',
                    method: 'POST',
                    data: {
                        update_status: true,
                        reservation_id: reservationId,
                        status: newStatus
                    },
                    success: function(response) {
                        // Success response
                        alert(response);
                    },
                    error: function() {
                        alert("Failed to update the reservation status.");
                    }
                });
            });
        });
    </script>
</body>
</html>
