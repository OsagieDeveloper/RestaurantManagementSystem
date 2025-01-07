<?php
    require_once '../model/session.php';
    require_once '../config/database.php';
    require_once '../model/function.php';
    
    if(!isLoggedIn()){
        header("location: ../login");
        die();
    }
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
            <h1>Customer Feedbacks</h1>
            <div class="recent-order feedback-list">
                <h2>Existing Feedbacks</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Feedback ID</th>
                            <th>Name</th>
                            <th>Rating</th>
                            <th>Dish Review</th>
                            <th>Feedback</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $query = "SELECT id, name, rating, dish_review, general_feedback, status FROM feedbacks";
                            $result = $mysqli->query($query);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['rating']); ?> stars</td>
                                        <td><?php echo htmlspecialchars($row['dish_review']); ?></td>
                                        <td><?php echo htmlspecialchars($row['general_feedback']); ?></td>
                                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                                    </tr>
                                <?php }
                            } else {
                                echo "<tr><td colspan='4'>No feedbacks found.</td></tr>";
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
