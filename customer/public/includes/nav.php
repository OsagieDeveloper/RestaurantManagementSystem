<nav>
    <div class="nav__header">
      <div class="nav__logo">
        <a href="./" class="logo">
          <img src="./public/assets/img/logo.png" alt="logo" />
          <span>Restaurant</span>
        </a>
      </div>
      <div class="nav__menu__btn" id="menu-btn">
        <i class="ri-menu-line"></i>
      </div>
    </div>
    
    <ul class="nav__links" id="nav-links">
      <li><a href="./reservation">Reservation</a></li>
      <li><a href="./menu">Menu</a></li>      
      <li><a href="./contact">Contact</a></li>
      <li><a href="./about">About</a></li>
      <li><a href="./cart">Cart <span>(<span id="cart-count">0</span>)<i class="ri-shopping-cart-line"></i></span></a></li>
      <li><a href="./order_history">Order History</a></li>

      <li>
        <?php
          if (isset($_SESSION['email'])) {
            $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $_SESSION['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $profileName = isset($user['full_name']) ? $user['full_name'] : 'User';
            echo '<a href="./profile.php" class="profile-link"><img src="https://i.postimg.cc/k5kz0TjQ/1381511-588644811197844-1671954779-n.jpg" alt="profile picture" class="profile-pic"><span class="profile-name">' . htmlspecialchars($profileName) . '</span></a>';
          } else {
            echo '<a href="../login.php" class="btn"><span><i class="ri-login-box-line"></i></span> Login</a>';
          }
        ?>
      </li>
    </ul>
    <div class="nav__btns">
      <?php
        if (isset($_SESSION['email'])) {
          $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
          $stmt->bind_param("s", $_SESSION['email']);
          $stmt->execute();
          $result = $stmt->get_result();
          $user = $result->fetch_assoc();
          $profileName = isset($user['full_name']) ? $user['full_name'] : 'User';
          echo '<a href="./profile.php" class="profile-link"><img src="https://i.postimg.cc/k5kz0TjQ/1381511-588644811197844-1671954779-n.jpg" alt="profile picture" class="profile-pic"><span class="profile-name">' . htmlspecialchars($profileName) . '</span></a>';
        } else {
          echo '<a href="../login.php" class="btn"><span><i class="ri-login-box-line"></i></span> Login</a>';
        }
      ?>
    </div>
</nav>
</header>

<style>
  .profile-link {
    display: flex;
    align-items: center;
    border-radius: 50px;
    overflow: hidden;
    padding: 5px;
    transition: background-color 0.3s;
    text-decoration: none;
    color: #333;
  }
  
  .profile-link:hover {
    background-color: rgba(0, 0, 0, 0.1);
  }
  
  .profile-pic {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 10px;
    border: 2px solid #fff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  }
  
  .profile-name {
    font-size: 16px;
    font-weight: 500;
    max-width: 100px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
</style>