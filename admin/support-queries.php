<?php
    require_once '../model/session.php';
    require_once '../config/database.php';
    require_once '../model/function.php';
    require_once '../model/auth.php';
    require_once '../model/email.php';
    
    if(!isLoggedIn()){
        header("location: ../login");
        die();
    }
    
    // Fetch all support queries
    $query = "SELECT * FROM support_queries ORDER BY created_at DESC";
    $result = $mysqli->query($query);
    $supportQueries = $result->fetch_all(MYSQLI_ASSOC);
    
    // Handle marking query as resolved
    if (isset($_GET['mark_resolved'])) {
        $queryId = secureData($_GET['mark_resolved']);
        // First fetch the query details for email notification
        $fetchQuery = "SELECT name, email FROM support_queries WHERE id = ?";
        $fetchStmt = $mysqli->prepare($fetchQuery);
        $fetchStmt->bind_param('i', $queryId);
        $fetchStmt->execute();
        $fetchResult = $fetchStmt->get_result();
        $queryDetails = $fetchResult->fetch_assoc();
        $fetchStmt->close();
        
        // Update query status
        $updateQuery = "UPDATE support_queries SET status = 'Resolved', resolved_at = NOW() WHERE id = ?";
        $stmt = $mysqli->prepare($updateQuery);
        $stmt->bind_param('i', $queryId);
        $stmt->execute();
        $stmt->close();
        
        // Send email notification to customer
        if ($queryDetails) {
            $emailResult = sendSupportStatusEmail(
                $queryDetails['email'],
                $queryDetails['name'],
                $queryId,
                'Resolved'
            );
            
            if ($emailResult !== true) {
                $errorMessage = "Query marked as resolved, but failed to send notification email: " . $emailResult;
            } else {
                $successMessage = "Query marked as resolved and notification email sent to customer.";
            }
        }
        
        header('Location: support-queries.php');
        exit;
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
            <h1>Support Queries Management</h1>

            <?php if (isset($successMessage)): ?>
                <div style="color: green;"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <?php if (isset($errorMessage)): ?>
                <div style="color: red;"><?php echo $errorMessage; ?></div>
            <?php endif; ?>

            <!-- Table displaying all support queries -->
            <div class="recent-order query-list">
                <h2>Customer Support Queries</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message Preview</th>
                            <th>Created At</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($supportQueries as $query): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($query['id']); ?></td>
                                <td><?php echo htmlspecialchars($query['name']); ?></td>
                                <td><?php echo htmlspecialchars($query['email']); ?></td>
                                <td><?php echo htmlspecialchars($query['subject']); ?></td>
                                <td><?php echo htmlspecialchars(substr($query['message'], 0, 50)); ?>...</td>
                                <td><?php echo htmlspecialchars($query['created_at']); ?></td>
                                <td class="status-<?php echo strtolower($query['status']); ?>">
                                    <?php echo htmlspecialchars($query['status']); ?>
                                </td>
                                <td>
                                    <?php if ($query['status'] !== 'Resolved'): ?>
                                        <a href="?mark_resolved=<?php echo $query['id']; ?>" class="btn btn-sm btn-success">Mark as Resolved</a>
                                    <?php endif; ?>
                                    <button class="btn btn-sm btn-info view-query" 
                                            data-id="<?php echo $query['id']; ?>"
                                            data-name="<?php echo htmlspecialchars($query['name']); ?>"
                                            data-email="<?php echo htmlspecialchars($query['email']); ?>"
                                            data-subject="<?php echo htmlspecialchars($query['subject']); ?>"
                                            data-message="<?php echo htmlspecialchars($query['message']); ?>"
                                            data-created="<?php echo htmlspecialchars($query['created_at']); ?>"
                                            data-status="<?php echo htmlspecialchars($query['status']); ?>">View</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>

        <?php
            require_once './includes/right-sidenav.php';
        ?>
    </div>
    
    <!-- Modal for Viewing Query Details -->
    <div class="modal fade" id="viewQueryModal" tabindex="-1" role="dialog" aria-labelledby="viewQueryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewQueryModalLabel">Support Query Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>ID:</strong> <span id="modal-id"></span></p>
                    <p><strong>Name:</strong> <span id="modal-name"></span></p>
                    <p><strong>Email:</strong> <span id="modal-email"></span></p>
                    <p><strong>Subject:</strong> <span id="modal-subject"></span></p>
                    <p><strong>Message:</strong> <pre id="modal-message"></pre></p>
                    <p><strong>Created At:</strong> <span id="modal-created"></span></p>
                    <p><strong>Status:</strong> <span id="modal-status"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php require_once './includes/script.php'; ?>
</body>
</html>
