<div class="right">
    <div class="top">
            <button id="menu-bar">
                <span class="material-symbols-outlined">menu</span>
            </button>
        
        <!-- <div class="theme-toggler">
            <span class="material-symbols-outlined active">light_mode</span>
            <span class="material-symbols-outlined">dark_mode</span>
        </div> -->

        <div class="profile">
            <a href="./staff/profile" class="info">
                <?php
                    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
                    $stmt->bind_param("s", $_SESSION['email']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $user = $result->fetch_assoc();
                    $staff_name = $user['full_name'];
                ?>
                <p><b><?php echo $staff_name; ?></b></p>
                <p>Staff</p>
                <small class="text-muted"></small>
            </a>

            <div class="profile-photo">
                <a href="./profile"><img src="https://i.postimg.cc/k5kz0TjQ/1381511-588644811197844-1671954779-n.jpg" alt="image"></a>
            </div>
        </div>
    </div>
</div>