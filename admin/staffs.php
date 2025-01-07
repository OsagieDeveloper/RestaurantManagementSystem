<?php
require_once '../model/session.php';
require_once '../config/database.php';
require_once '../model/function.php';
if(!isLoggedIn()){
    header("location: ../login");
    die();
}

// Handle form submission to add a staff member
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addStaff'])) {
        $staffId = 'staff' . uniqid();
        $staffName = $_POST['staff_name'] ?? '';
        $position = $_POST['position'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';

        if (!empty($staffName) && !empty($position) && !empty($email) && !empty($phone)) {
            // Check for duplicate email, phone, or staff ID
            $checkQuery = $mysqli->prepare(
                "SELECT COUNT(*) FROM users WHERE email = ? OR phone_number = ? OR id = ?"
            );
            $checkQuery->bind_param("sss", $email, $phone, $staffId);
            $checkQuery->execute();
            $checkQuery->bind_result($count);
            $checkQuery->fetch();
            $checkQuery->close();
        
            if ($count > 0) {
                $errorMessage = "A staff member with the same email, phone, or ID already exists.";
            } else {
                // Insert the new staff member
                $stmt = $mysqli->prepare(
                    "INSERT INTO users (id, full_name, position, email, phone_number) VALUES (?, ?, ?, ?, ?)"
                );
                $stmt->bind_param("sssss", $staffId, $staffName, $position, $email, $phone);
        
                if ($stmt->execute()) {
                    $successMessage = "Staff member added successfully!";
                } else {
                    $errorMessage = "Failed to add staff member. Please try again.";
                }
                $stmt->close();
            }
        } else {
            $errorMessage = "Please fill out all fields correctly.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php 
    require_once './includes/header.php';
?>
<body>
    <div class="container">
        <?php require_once './includes/sidenav.php'; ?>

        <main>
            <h1>Manage Staff</h1>

            <?php if (isset($successMessage)): ?>
                <div style="color: green;"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <?php if (isset($errorMessage)): ?>
                <div style="color: red;"><?php echo $errorMessage; ?></div>
            <?php endif; ?>

            <div class="add-table-form" style="width: 100%;">
                <h2>Add Staff</h2>
                <form method="POST" style="display: flex; flex-direction: column; gap: 15px;">
                    <label for="staff_name">Name:</label>
                    <input 
                        type="text" 
                        id="staff_name" 
                        name="staff_name" 
                        required 
                        style="padding: 12px; border: 1px solid #ccc; border-radius: 4px;">

                    <label for="position">Position:</label>
                    <input 
                        type="text" 
                        id="position" 
                        name="position" 
                        required 
                        style="padding: 12px; border: 1px solid #ccc; border-radius: 4px;">

                    <label for="email">Email:</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required 
                        style="padding: 12px; border: 1px solid #ccc; border-radius: 4px;">

                    <label for="phone">Phone:</label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        required 
                        style="padding: 12px; border: 1px solid #ccc; border-radius: 4px;">

                    <button 
                        type="submit" 
                        name="addStaff" 
                        style="padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 4px;">
                        Add Staff
                    </button>
                </form>
            </div>

            <div class="recent-order">
                <h2>Existing Staff</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Email</th>
                            <th>Phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT id, full_name, position, email, phone_number FROM users";
                        $result = $mysqli->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['position']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
                                </tr>
                            <?php }
                        } else {
                            echo "<tr><td colspan='5'>No staff members found.</td></tr>";
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