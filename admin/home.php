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
            <h1>Dashboard</h1>

        </main>

        <?php
            require_once './includes/right-sidenav.php';
        ?>
    </div>
    <?php require_once './includes/script.php'; ?>
</body>
</html>