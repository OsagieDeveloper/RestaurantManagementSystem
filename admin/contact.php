<?php
    require_once '../model/session.php';
    require_once '../config/database.php';
    require_once '../model/function.php';
?>

<!DOCTYPE html>
<html lang="en">
<?php 
    require_once './includes/header.php';
?>
<body>
    <div class="container">
        <?php 
            require_once './includes/sidenav.php';
        ?>

        <main>
            <h1>Contact Inquiries</h1>
            <div class="recent-order inquiry-list">
                <h2>Existing Inquiries</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Inquiry ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $query = "SELECT id, name, email, message, status FROM contact_inquiries";
                        $result = $mysqli->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['message']); ?></td>
                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                </tr>
                            <?php }
                        } else {
                            echo "<tr><td colspan='4'>No inquiries found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>

        <?php
            require_once './includes/right-sidenav.php';
        ?>
    </div>
    <?php require_once './includes/script.php'; ?>
</body>
</html>
