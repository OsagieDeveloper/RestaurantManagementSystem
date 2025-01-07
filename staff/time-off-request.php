<?php
require_once '../model/session.php';
require_once '../config/database.php';
require_once '../model/function.php';

if (!isLoggedIn()) {
    header("location: ../login");
    die();
}

// Fetch logged-in staff ID from session
require_once './includes/details.php';

// Fetch staff schedules
$scheduleResults = [];
$query = "SELECT id, shift_start, shift_end, created_at FROM staff_schedule WHERE staff_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $staff_id);
$stmt->execute();
$result = $stmt->get_result();
$scheduleResults = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Handle time-off request submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_time_off'])) {
    $name = $_POST['name'] ?? '';
    $position = $_POST['position'] ?? '';
    $requestDate = $_POST['request_date'] ?? '';
    $startDate = $_POST['start_date'] ?? '';
    $endDate = $_POST['end_date'] ?? '';
    $reason = $_POST['reason'] ?? '';

    if (!empty($name) && !empty($requestDate) && !empty($startDate) && !empty($endDate) && !empty($reason)) {
        $insertQuery = $mysqli->prepare(
            "INSERT INTO time_off_requests (staff_id, name, position, request_date, start_date, end_date, reason, status) 
             VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')"
        );
        $insertQuery->bind_param("issssss", $staff_id, $name, $position, $requestDate, $startDate, $endDate, $reason);
        if ($insertQuery->execute()) {
            $successMessage = "Time-off request submitted successfully.";
        } else {
            $errorMessage = "Failed to submit the request. Please try again.";
        }
        $insertQuery->close();
    } else {
        $errorMessage = "Please fill out all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once './includes/header.php'; ?>
<body>
    <div class="container">
        <?php require_once './includes/sidenav.php'; ?>

        <main>
            <?php if (isset($successMessage)): ?>
                <div style="color: green;"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <?php if (isset($errorMessage)): ?>
                <div style="color: red;"><?php echo $errorMessage; ?></div>
            <?php endif; ?>

            <!-- Time-Off Request Form -->
            <div class="add-table-form" style="margin-top: 2rem; margin-bottom: 2rem;">
                <h2>Submit Time-Off Request</h2>
                <form method="POST" class="inventoryForm" style="display: flex; flex-direction: column; gap: 15px;">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required value="<?php echo $staff_name; ?>" readonly>

                    <label for="request_date">Request Date:</label>
                    <input type="date" id="request_date" name="request_date" required>

                    <label for="start_date">Start Date:</label>
                    <input type="date" id="start_date" name="start_date" required>

                    <label for="end_date">End Date:</label>
                    <input type="date" id="end_date" name="end_date" required>

                    <label for="reason">Reason:</label>
                    <textarea id="reason" name="reason" required></textarea>

                    <button type="submit" name="submit_time_off" style="background-color: #007bff; color: white;">Submit Request</button>
                </form>
            </div>
        </main>

        <?php require_once './includes/right-sidenav.php'; ?>
    </div>
    <?php require_once './includes/script.php'; ?>
</body>
</html>
