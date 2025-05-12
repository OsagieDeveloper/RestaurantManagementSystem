<aside>
    <div class="top">
        <div class="logo">
            <h2>Admin <span class="primary">Dashboard</span></h2>
        </div>
        <div class="close" id="close-btn">
            <span class="material-symbols-outlined"> close </span>
        </div>
    </div>

    <div class="sidebar">
        <a href="./">
            <span class="material-symbols-outlined" class="active"> grid_view </span>
            <h3>Dashboard</h3>
        </a>

        <a href="./reservation">
            <span class="material-symbols-outlined"> restaurant </span>
            <h3>Reservations</h3>            
        </a>

        <a href="./add_orders_only">
            <span class="material-symbols-outlined"> receipt </span>
            <h3>Add Orders</h3>
        </a>

        <a href="./orders">
            <span class="material-symbols-outlined"> receipt </span>
            <h3>orders</h3>
        </a>

        <a href="./menus">
            <span class="material-symbols-outlined"> menu </span>
            <h3>Menus</h3>
        </a>

        <a href="./table">
            <span class="material-symbols-outlined"> insights </span>
            <h3>Table</h3>
        </a>

        <a href="./staffs">
            <span class="material-symbols-outlined"> person_outline </span>
            <h3>Staffs</h3>
        </a>

        <a href="./inventory">
            <span class="material-symbols-outlined"> inventory </span>
            <h3>Inventory</h3>
        </a>

        <a href="./scheduling">
            <span class="material-symbols-outlined"> schedule </span>
            <h3>Staff Scheduling</h3>
        </a>

        <a href="./manage-request">
            <span class="material-symbols-outlined"> work_history </span>
            <h3>Time Off Requests</h3>
        </a>

        
        </a>

        <a href="./contact">
            <span class="material-symbols-outlined"> mail_outline </span>
            <h3>Support</h3>
            <?php
                // Query to count unread support messages
                $support_count_query = "SELECT COUNT(*) AS unread_messages FROM contact_inquiries WHERE status = ?";
                $stmt = $mysqli->prepare($support_count_query);
                $status = 'unread'; 
                $stmt->bind_param("s", $status);  
                $stmt->execute();
                $stmt->bind_result($support_count);  
                $stmt->fetch();
                $stmt->close(); 
            ?>
            <span class="msg-count"><?php echo $support_count; ?></span>
        </a>

        <a href="./feedbacks">
            <span class="material-symbols-outlined"> report_gmailerrorred </span>
            <h3>Feedbacks</h3>
            <?php
                // Query to count unread feedback
                $feedback_count_query = "SELECT COUNT(*) AS unread_feedbacks FROM feedbacks WHERE status = ?";
                $stmt = $mysqli->prepare($feedback_count_query);
                $stmt->bind_param("s", $status); 
                $stmt->execute();
                $stmt->bind_result($feedback_count); 
                $stmt->fetch();
                $stmt->close(); 
            ?>
            <span class="msg-count"><?php echo $feedback_count; ?></span>
        </a>

        <a href="./support-queries">
            <span class="material-symbols-outlined"> help </span>
            <h3>Queries</h3>
            <?php
                // Query to count unread feedback
                $status = "Pending";
                $support_count_query = "SELECT COUNT(*) AS support_queries FROM support_queries WHERE status = ?";
                $stmt = $mysqli->prepare($support_count_query);
                $stmt->bind_param("s", $status); 
                $stmt->execute();
                $stmt->bind_result($support_count); 
                $stmt->fetch();
                $stmt->close(); 
            ?>
            <span class="msg-count"><?php echo $support_count; ?></span>
        </a>

        <a href="./logout">
            <span class="material-symbols-outlined"> logout </span>
            <h3>Logout</h3>
        </a>
    </div>
</aside>