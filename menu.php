<?php
  require_once './model/session.php';
  require_once './config/database.php';
  require_once './model/function.php';
?>
<!DOCTYPE html>
<html lang="en">
  <?php 
    require_once './public/includes/header.php';
  ?>
  <body>
    <header>
      <?php
        require_once './public/includes/nav.php';
      ?>
      <div class="section__container header__container" id="home">
        <div class="header__content text-center">
          <h1>Our Delicious Food Menu</h1>
          <p class="section__description">
            Browse through our menu and find your favorite dishes. We offer a variety of meals to satisfy every craving!
          </p>
        </div>
      </div>
    </header>

    <!-- Promotion Banner -->
    <section class="promotion-banner text-center py-4 bg-warning">
      <p class="h4 text-white mb-0">🍔 Special Promotion: 10% Off on Your First Order! 🍕</p>
      <a href="#" class="btn btn-dark mt-2">Order Now</a>
    </section>

    <section class="section__container menu__container" id="menu">
      <p class="section__subheader">OUR MENU</p>
      <h2 class="section__header text-center">Menu That Always Make You Fall In Love</h2>

      <!-- Menu Items List -->
      <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-4">
          <div class="col">
            <div class="card">
              <img src="./public/assets/img/menu-1.png" class="card-img-top" alt="menu" />
              <div class="card-body">
                <h5 class="card-title">Italian Pizza</h5>
                <p class="card-text"><span>$</span>7.49</p>
                <p class="card-text"><strong>Availability:</strong> In Stock</p>
                <a href="#" class="btn btn-primary">Order Now</a>
              </div>
            </div>
          </div>

          <div class="col">
            <div class="card">
              <img src="./public/assets/img/menu-2.png" class="card-img-top" alt="menu" />
              <div class="card-body">
                <h5 class="card-title">Burrito Wrap</h5>
                <p class="card-text"><span>$</span>4.49</p>
                <p class="card-text"><strong>Availability:</strong> Out of Stock</p>
                <a href="#" class="btn btn-primary" disabled>Order Now</a>
              </div>
            </div>
          </div>

          <div class="col">
            <div class="card">
              <img src="./public/assets/img/menu-3.webp" class="card-img-top" alt="menu" />
              <div class="card-body">
                <h5 class="card-title">Red Sauce Pasta</h5>
                <p class="card-text"><span>$</span>5.99</p>
                <p class="card-text"><strong>Availability:</strong> In Stock</p>
                <a href="#" class="btn btn-primary">Order Now</a>
              </div>
            </div>
          </div>

          <div class="col">
            <div class="card">
              <img src="./public/assets/img/menu-4.webp" class="card-img-top" alt="menu" />
              <div class="card-body">
                <h5 class="card-title">Fresh Pan Pizza</h5>
                <p class="card-text"><span>$</span>6.49</p>
                <p class="card-text"><strong>Availability:</strong> In Stock</p>
                <a href="#" class="btn btn-primary">Order Now</a>
              </div>
            </div>
          </div>

          <div class="col">
            <div class="card">
              <img src="./public/assets/img/menu-5.png" class="card-img-top" alt="menu" />
              <div class="card-body">
                <h5 class="card-title">Chicken Nuggets</h5>
                <p class="card-text"><span>$</span>4.99</p>
                <p class="card-text"><strong>Availability:</strong> In Stock</p>
                <a href="#" class="btn btn-primary">Order Now</a>
              </div>
            </div>
          </div>

          <div class="col">
            <div class="card">
              <img src="./public/assets/img/menu-2.png" class="card-img-top" alt="menu" />
              <div class="card-body">
                <h5 class="card-title">Dum Biryani</h5>
                <p class="card-text"><span>$</span>8.49</p>
                <p class="card-text"><strong>Availability:</strong> In Stock</p>
                <a href="#" class="btn btn-primary">Order Now</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <?php
      require_once './public/includes/footer.php';
      require_once './public/includes/script.php';
    ?>
  </body>
</html>
