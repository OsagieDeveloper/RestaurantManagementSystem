<?php
    require_once '../model/session.php';
    require_once '../config/database.php';
    require_once '../model/function.php';
    if(!isLoggedIn()){
        header("location: ../login");
        die();
    }

    require_once './includes/details.php';
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
            <div style="width: 100%; height: 30rem; overflow: hidden; margin-bottom: 1.25rem;">
                <img src="../public/assets/img/dashboard_image.jpg" alt="Restaurant Cover" style="width: 100%; height: 100%; object-fit: cover;">
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
                    <h5 style="text-align: center; margin-top: 0; color: #1976d2; font-size: 1.5rem;">Add Inventory</h5>
                    <p style="color: #333; font-size: 1.2rem;">Add new inventory items to the system.</p>
                    <div style="text-align: center;">
                        <a href="add-inventory.php" style="display: inline-block; padding: 0.5rem 0.9375rem; background-color: #1976d2; color: white; text-decoration: none; border-radius: 0.3125rem; font-size: 0.9rem; width: 80%;">Go to Add Inventory</a>
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
                    <h5 style="text-align: center; margin-top: 0; color: #7c4dff; font-size: 1.5rem;">My Schedule</h5>
                    <p style="color: #333; font-size: 1.2rem;">Check your schedule and availability.</p>
                    <div style="text-align: center;">
                        <a href="scheduling.php" style="display: inline-block; padding: 0.5rem 0.9375rem; background-color: #7c4dff; color: white; text-decoration: none; border-radius: 0.3125rem; font-size: 0.9rem; width: 80%;">Go to My Schedule</a>
                    </div>
                </div>
                <div style="background-color: #ccffcc; border-radius: 0.5rem; padding: 1.25rem; width: 23%; box-shadow: 0 0.125rem 0.3125rem rgba(0,0,0,0.2); min-width: 18.75rem;">
                    <h5 style="text-align: center; margin-top: 0; color: #388e3c; font-size: 1.5rem;">Request Time Off</h5>
                    <p style="color: #333; font-size: 1.2rem;">Request time off from your manager.</p>
                    <div style="text-align: center;">
                        <a href="request-time-off.php" style="display: inline-block; padding: 0.5rem 0.9375rem; background-color: #388e3c; color: white; text-decoration: none; border-radius: 0.3125rem; font-size: 0.9rem; width: 80%;">Go to Request Time Off</a>
                    </div>
                </div>

            </div>
        </main>

        <?php
            require_once './includes/right-sidenav.php';
        ?>
    </div>
    <?php require_once './includes/script.php'; ?>
</body>
</html>