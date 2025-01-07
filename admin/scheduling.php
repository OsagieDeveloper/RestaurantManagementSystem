<?php
require_once '../model/session.php';
require_once '../config/database.php';
require_once '../model/function.php';

if (!isLoggedIn()) {
    header("location: ../login");
    die();
}

// Fetch staff from the `users` table for the dropdown
$staffListQuery = "SELECT id, full_name, position FROM users";
$staffListResult = $mysqli->query($staffListQuery);

// Handle form submission to add a staff schedule
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addSchedule'])) {
        $staffId = $_POST['staff_id'] ?? '';
        $shiftStart = $_POST['shift_start'] ?? '';
        $shiftEnd = $_POST['shift_end'] ?? '';
        $date = $_POST['date'] ?? '';
        $hoursWorked = $_POST['hours_worked'] ?? 0;

        if (!empty($staffId) && !empty($shiftStart) && !empty($shiftEnd) && !empty($date)) {
            // Fetch the name and position from the users table using the staff_id
            $nameQuery = $mysqli->prepare("SELECT full_name, position FROM users WHERE id = ?");
            $nameQuery->bind_param("s", $staffId);
            $nameQuery->execute();
            $nameQuery->bind_result($name, $position);
            $nameQuery->fetch();
            $nameQuery->close();

            if (!empty($name)) {
                // Check if the staff member is already scheduled for the same shift and date
                $checkQuery = $mysqli->prepare(
                    "SELECT COUNT(*) FROM staff_schedule WHERE staff_id = ? AND created_at = ?"
                );
                $checkQuery->bind_param("ss", $staffId, $date);
                $checkQuery->execute();
                $checkQuery->bind_result($count);
                $checkQuery->fetch();
                $checkQuery->close();

                if ($count > 0) {
                    $errorMessage = "This staff member is already scheduled for this date.";
                } else {
                    // Insert the new schedule
                    $stmt = $mysqli->prepare(
                        "INSERT INTO staff_schedule (staff_id, name, position, shift_start, shift_end, hours_worked, created_at) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)"
                    );
                    $stmt->bind_param("sssssss", $staffId, $name, $position, $shiftStart, $shiftEnd, $hoursWorked, $date);

                    if ($stmt->execute()) {
                        $successMessage = "Schedule added successfully!";
                    } else {
                        $errorMessage = "Failed to add schedule. Please try again.";
                    }
                    $stmt->close();
                }
            } else {
                $errorMessage = "Invalid staff ID. Please select a valid staff member.";
            }
        } else {
            $errorMessage = "Please fill out all fields correctly.";
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
            <h1>Staff Scheduling</h1>

            <?php if (isset($successMessage)): ?>
                <div style="color: green;"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <?php if (isset($errorMessage)): ?>
                <div style="color: red;"><?php echo $errorMessage; ?></div>
            <?php endif; ?>

            <div class="add-table-form">
                <h2>Add Schedule</h2>
                <form method="POST" class="inventoryForm" style="display: flex; flex-direction: column; gap: 15px;">
                    <label for="staff_id">Staff Name:</label>
                    <select id="staff_id" name="staff_id" required>
                        <option value="" disabled selected>Select Staff</option>
                        <?php
                        if ($staffListResult->num_rows > 0) {
                            while ($staff = $staffListResult->fetch_assoc()) {
                                echo "<option value='" . htmlspecialchars($staff['id']) . "'>" . htmlspecialchars($staff['full_name']) . " - " . htmlspecialchars($staff['position']) . "</option>";
                            }
                        }
                        ?>
                    </select>

                    <label for="shift_start">Shift Start Time:</label>
                    <input type="time" id="shift_start" name="shift_start" required>

                    <label for="shift_end">Shift End Time:</label>
                    <input type="time" id="shift_end" name="shift_end" required>

                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" required>

                    <label for="hours_worked">Hours Worked:</label>
                    <input type="number" id="hours_worked" name="hours_worked" min="0" required>

                    <button type="submit" name="addSchedule" style="background-color: #007bff; color: white;">Add Schedule</button>
                </form>
            </div>

            <div class="recent-order">
                <h2>Existing Schedules</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Staff Name</th>
                            <th>Shift Start</th>
                            <th>Shift End</th>
                            <th>Hours Worked</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT staff_id, name, shift_start, shift_end, hours_worked, created_at FROM staff_schedule";
                        $result = $mysqli->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['staff_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['shift_start']); ?></td>
                                    <td><?php echo htmlspecialchars($row['shift_end']); ?></td>
                                    <td><?php echo htmlspecialchars($row['hours_worked']); ?></td>
                                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                </tr>
                            <?php }
                        } else {
                            echo "<tr><td colspan='7'>No schedules found.</td></tr>";
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
