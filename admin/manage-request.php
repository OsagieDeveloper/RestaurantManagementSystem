<?php
require_once '../model/session.php';
require_once '../config/database.php';
require_once '../model/function.php';

if (!isLoggedIn()) {
    header("location: ../login");
    die();
}

// Fetch time-off requests
$timeOffQuery = "SELECT id, staff_id, name, position, request_date, start_date, end_date, reason, status FROM time_off_requests";
$timeOffResult = $mysqli->query($timeOffQuery);

// Handle form submission for updating time-off request status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['updateRequest'])) {
        $requestId = $_POST['request_id'] ?? '';
        $status = $_POST['status'] ?? '';

        if (!empty($requestId) && in_array($status, ['Approved', 'Rejected'])) {
            $stmt = $mysqli->prepare("UPDATE time_off_requests SET status = ? WHERE id = ?");
            $stmt->bind_param("ss", $status, $requestId);

            if ($stmt->execute()) {
                $successMessage = "Time-off request updated successfully!";
            } else {
                $errorMessage = "Failed to update the time-off request. Please try again.";
            }
            $stmt->close();
        } else {
            $errorMessage = "Invalid request ID or status.";
        }
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
            <h1>Manage Time-Off Requests</h1>

            <?php if (isset($successMessage)): ?>
                <div style="color: green;"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <?php if (isset($errorMessage)): ?>
                <div style="color: red;"><?php echo $errorMessage; ?></div>
            <?php endif; ?>

            <div class="recent-order">
                <h2>Time-Off Requests</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Staff Name</th>
                            <th>Position</th>
                            <th>Request Date</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($timeOffResult->num_rows > 0) {
                            while ($row = $timeOffResult->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['position']); ?></td>
                                    <td><?php echo htmlspecialchars($row['request_date']); ?></td>
                                    <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                                    <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                                    <td><?php echo htmlspecialchars($row['reason']); ?></td>
                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                    <td>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="request_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                            <select name="status" required style="border: 1px solid #ccc; padding: 10px;">
                                                <option value="" disabled selected>Update Status</option>
                                                <option value="Approved">Approve</option>
                                                <option value="Rejected">Reject</option>
                                            </select>
                                            <button type="submit" name="updateRequest">Update</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php }
                        } else {
                            echo "<tr><td colspan='9'>No time-off requests found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>

        <?php require_once './includes/right-sidenav.php'; ?>
    </div>
    <?php require_once './includes/script.php'; ?>
</body>
</html>
