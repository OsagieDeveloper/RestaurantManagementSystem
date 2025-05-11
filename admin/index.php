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
            
            <!-- Dashboard Image -->
            <div style="width: 100%; height: 30rem; overflow: hidden; margin-bottom: 1.25rem;">
                <img src="../public/assets/img/dashboard_image.jpg" alt="Restaurant Cover" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            
            <div class="container" style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                <div class="card" style="flex: 0 0 23%; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 8px; background-color: #b3e0ff;">
                    <div class="card-body" style="padding: 20px;">
                        <h3>Total Food</h3>
                        <p><?php
                            $food_query = "SELECT COUNT(*) as total FROM menus WHERE type = 'food'";
                            $food_result = mysqli_query($mysqli, $food_query);
                            $food_count = mysqli_fetch_assoc($food_result)['total'];
                            echo $food_count;
                        ?></p>
                    </div>
                </div>

                <div class="card" style="flex: 0 0 23%; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 8px; background-color: #ffe6cc;">
                    <div class="card-body" style="padding: 20px;">
                        <h3>Total Drinks</h3>
                        <p><?php
                            $drinks_query = "SELECT COUNT(*) as total FROM menus WHERE type = 'drink'";
                            $drinks_result = mysqli_query($mysqli, $drinks_query);
                            $drinks_count = mysqli_fetch_assoc($drinks_result)['total'];
                            echo $drinks_count;
                        ?></p>
                    </div>
                </div>

                <div class="card" style="flex: 0 0 23%; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 8px; background-color: #f0ccff;">
                    <div class="card-body" style="padding: 20px;">
                        <h3>Total Desserts</h3>
                        <p><?php
                            $desserts_query = "SELECT COUNT(*) as total FROM menus WHERE type = 'dessert'";
                            $desserts_result = mysqli_query($mysqli, $desserts_query);
                            $desserts_count = mysqli_fetch_assoc($desserts_result)['total'];
                            echo $desserts_count;
                        ?></p>
                    </div>
                </div>

                <div class="card" style="flex: 0 0 23%; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 8px; background-color: #ffe6cc;">
                    <div class="card-body" style="padding: 20px;">
                        <h3>Total Orders</h3>
                        <p><?php
                            $orders_query = "SELECT COUNT(*) as total FROM orders";
                            $orders_result = mysqli_query($mysqli, $orders_query);
                            $orders_count = mysqli_fetch_assoc($orders_result)['total'];
                            echo $orders_count;
                        ?></p>
                    </div>
                </div>

                <div class="card" style="flex: 0 0 23%; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 8px; background-color: #ccffcc;">
                    <div class="card-body" style="padding: 20px;">
                        <h3>Registered Users</h3>
                        <p><?php
                            $users_query = "SELECT COUNT(*) as total FROM users WHERE role = 'customer'";
                            $users_result = mysqli_query($mysqli, $users_query);
                            $users_count = mysqli_fetch_assoc($users_result)['total'];
                            echo $users_count;
                        ?></p>
                    </div>
                </div>

                <div class="card" style="flex: 0 0 23%; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 8px; background-color: #b3e0ff;">
                    <div class="card-body" style="padding: 20px;">
                        <h3>Total Transactions</h3>
                        <p><?php
                            $transactions_query = "SELECT COUNT(*) as total FROM orders";
                            $transactions_result = mysqli_query($mysqli, $transactions_query);
                            $transactions_count = mysqli_fetch_assoc($transactions_result)['total'];
                            echo $transactions_count;
                        ?></p>
                    </div>
                </div>

                <div class="card" style="flex: 0 0 23%; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 8px; background-color: #ffcccb;">
                    <div class="card-body" style="padding: 20px;">
                        <h3>Total Income</h3>
                        <p><?php
                            $income_query = "SELECT SUM(total) as total FROM orders WHERE status = 'delivered'";
                            $income_result = mysqli_query($mysqli, $income_query);
                            $income_total = mysqli_fetch_assoc($income_result)['total'];
                            echo '₦' . number_format($income_total, 2);
                        ?></p>
                    </div>
                </div>

                <div class="card" style="flex: 0 0 23%; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 8px; background-color: #ccffcc;;">
                    <div class="card-body" style="padding: 20px;">
                        <h3>Total Expenses</h3>
                        <p><?php
                            $expenses_query = "SELECT SUM(total) as total FROM orders WHERE status = 'delivered'";
                            $expenses_result = mysqli_query($mysqli, $expenses_query);
                            $expenses_total = mysqli_fetch_assoc($expenses_result)['total'];
                            echo '₦' . number_format($expenses_total, 2);
                        ?></p>
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