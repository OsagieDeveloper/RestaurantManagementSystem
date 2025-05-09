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

        <main style="margin-bottom: 6.25rem;">
            <h2 style="margin-bottom: 1.25rem; text-align: center; margin-top: 1.25rem; color: #333; font-size: 2rem;">Admin Dashboard</h2>
            
            <!-- Dashboard Image
            <div style="width: 100%; height: 30rem; overflow: hidden; margin-bottom: 1.25rem;">
                <img src="../public/assets/img/dashboard_image.jpg" alt="Restaurant Cover" style="width: 100%; height: 100%; object-fit: cover;">
            </div> -->
            
            <!-- Chart Container -->
            <div style="width: 80%; margin: 0 auto;">
                <canvas id="adminDataChart" style="width: 100%; height: 25rem;"></canvas>
            </div>
            
            <div style="display: flex; flex-wrap: wrap; gap: 1.25rem; padding: 1.25rem;">
                <div style="background-color: #ffcccb; border-radius: 0.5rem; padding: 1.25rem; width: 23%; box-shadow: 0 0.125rem 0.3125rem rgba(0,0,0,0.2); min-width: 18.75rem;">
                    <h5 style="text-align: center; margin-top: 0; color: #d32f2f; font-size: 1.5rem;">Reservations</h5>
                    <p style="color: #333; font-size: 1.2rem;">Check reservations made by customers.</p>
                    <div style="text-align: center;">
                        <a href="reservation.php" style="display: inline-block; padding: 0.5rem 0.9375rem; background-color: #d32f2f; color: white; text-decoration: none; border-radius: 0.3125rem; font-size: 0.9rem; width: 80%;">Go to Reservations</a>
                    </div>
                </div>
                <div style="background-color: #b3e0ff; border-radius: 0.5rem; padding: 1.25rem; width: 23%; box-shadow: 0 0.125rem 0.3125rem rgba(0,0,0,0.2); min-width: 18.75rem;">
                    <h5 style="text-align: center; margin-top: 0; color: #1976d2; font-size: 1.5rem;">Tables</h5>
                    <p style="color: #333; font-size: 1.2rem;">Manage tables and their availability.</p>
                    <div style="text-align: center;">
                        <a href="tables.php" style="display: inline-block; padding: 0.5rem 0.9375rem; background-color: #1976d2; color: white; text-decoration: none; border-radius: 0.3125rem; font-size: 0.9rem; width: 80%;">Go to Tables</a>
                    </div>
                </div>
                <div style="background-color: #ccffcc; border-radius: 0.5rem; padding: 1.25rem; width: 23%; box-shadow: 0 0.125rem 0.3125rem rgba(0,0,0,0.2); min-width: 18.75rem;">
                    <h5 style="text-align: center; margin-top: 0; color: #388e3c; font-size: 1.5rem;">Staff</h5>
                    <p style="color: #333; font-size: 1.2rem;">Manage staff accounts and their roles.</p>
                    <div style="text-align: center;">
                        <a href="staff.php" style="display: inline-block; padding: 0.5rem 0.9375rem; background-color: #388e3c; color: white; text-decoration: none; border-radius: 0.3125rem; font-size: 0.9rem; width: 80%;">Go to Staff</a>
                    </div>
                </div>
                <div style="background-color: #ffe6cc; border-radius: 0.5rem; padding: 1.25rem; width: 23%; box-shadow: 0 0.125rem 0.3125rem rgba(0,0,0,0.2); min-width: 18.75rem;">
                    <h5 style="text-align: center; margin-top: 0; color: #f57c00; font-size: 1.5rem;">Inventory</h5>
                    <p style="color: #333; font-size: 1.2rem;">Manage inventory items and their quantities.</p>
                    <div style="text-align: center;">
                        <a href="inventory.php" style="display: inline-block; padding: 0.5rem 0.9375rem; background-color: #f57c00; color: white; text-decoration: none; border-radius: 0.3125rem; font-size: 0.9rem; width: 80%;">Go to Inventory</a>
                    </div>
                </div>
                <div style="background-color: #f0ccff; border-radius: 0.5rem; padding: 1.25rem; width: 23%; box-shadow: 0 0.125rem 0.3125rem rgba(0,0,0,0.2); min-width: 18.75rem;">
                    <h5 style="text-align: center; margin-top: 0; color: #7c4dff; font-size: 1.5rem;">Staff Scheduling</h5>
                    <p style="color: #333; font-size: 1.2rem;">Manage staff schedules and availability.</p>
                    <div style="text-align: center;">
                        <a href="scheduling.php" style="display: inline-block; padding: 0.5rem 0.9375rem; background-color: #7c4dff; color: white; text-decoration: none; border-radius: 0.3125rem; font-size: 0.9rem; width: 80%;">Go to Staff Scheduling</a>
                    </div>
                </div>
                <div style="background-color: #fff0cc; border-radius: 0.5rem; padding: 1.25rem; width: 23%; box-shadow: 0 0.125rem 0.3125rem rgba(0,0,0,0.2); min-width: 18.75rem;">
                    <h5 style="text-align: center; margin-top: 0; color: #fbc02d; font-size: 1.5rem;">Time Off Request</h5>
                    <p style="color: #333; font-size: 1.2rem;">Manage time off requests from staff members.</p>
                    <div style="text-align: center;">
                        <a href="reports_analytics.php" style="display: inline-block; padding: 0.5rem 0.9375rem; background-color: #fbc02d; color: black; text-decoration: none; border-radius: 0.3125rem; font-size: 0.9rem; width: 80%;">Go to Time Off Request</a>
                    </div>
                </div>
                <div style="background-color: #cce6ff; border-radius: 0.5rem; padding: 1.25rem; width: 23%; box-shadow: 0 0.125rem 0.3125rem rgba(0,0,0,0.2); min-width: 18.75rem;">
                    <h5 style="text-align: center; margin-top: 0; color: #1976d2; font-size: 1.5rem;">Support</h5>
                    <p style="color: #333; font-size: 1.2rem;">Support requests and inquiries.</p>
                    <div style="text-align: center;">
                        <a href="contact.php" style="display: inline-block; padding: 0.5rem 0.9375rem; background-color: #1976d2; color: white; text-decoration: none; border-radius: 0.3125rem; font-size: 0.9rem; width: 80%;">Go to Support</a>
                    </div>
                </div>
                <div style="background-color: #ffccf0; border-radius: 0.5rem; padding: 1.25rem; width: 23%; box-shadow: 0 0.125rem 0.3125rem rgba(0,0,0,0.2); min-width: 18.75rem;">
                    <h5 style="text-align: center; margin-top: 0; color: #d81b60; font-size: 1.5rem;">Customer Feedback</h5>
                    <p style="color: #333; font-size: 1.2rem;">Read feedback submitted by customers.</p>
                    <div style="text-align: center;">
                        <a href="feedback.php" style="display: inline-block; padding: 0.5rem 0.9375rem; background-color: #d81b60; color: white; text-decoration: none; border-radius: 0.3125rem; font-size: 0.9rem; width: 80%;">Go to Feedback</a>
                    </div>
                </div>
                <div style="background-color: #ccffe6; border-radius: 0.5rem; padding: 1.25rem; width: 23%; box-shadow: 0 0.125rem 0.3125rem rgba(0,0,0,0.2); min-width: 18.75rem;">
                    <h5 style="text-align: center; margin-top: 0; color: #388e3c; font-size: 1.5rem;">Queries</h5>
                    <p style="color: #333; font-size: 1.2rem;">Read and respond to queries submitted by customers.</p>
                    <div style="text-align: center;">
                        <a href="queries.php" style="display: inline-block; padding: 0.5rem 0.9375rem; background-color: #388e3c; color: white; text-decoration: none; border-radius: 0.3125rem; font-size: 0.9rem; width: 80%;">Go to Queries</a>
                    </div>
                </div>
            </div>
        </main>

        <?php
            require_once './includes/right-sidenav.php';
        ?>
    </div>
    <?php require_once './includes/script.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
</body>
</html>