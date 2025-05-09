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
      <a href="#menu" class="btn btn-dark mt-2">Order Now</a>
    </section>

    <section class="section__container menu__container" id="menu">
      <p class="section__subheader">OUR MENU</p>
      <!-- <h2 class="section__header text-center">Menu That Always Make You Fall In Love</h2> -->

      <!-- Menu Items List -->
      <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-4">

      <?php
        $menu_items = fetchMenuItems();
        foreach ($menu_items as $item) {
      ?>
          <div class="col">
            <div class="card">
              <img src="<?php echo $item['image']; ?>" class="card-img-top" alt="menu" style="width: 100%; height: auto; object-fit: cover;" />
              <div class="card-body">
                <h5 class="card-title"><?php echo $item['name']; ?></h5>
                <p class="card-text"><span>$</span><?php echo $item['price']; ?></p>
                <p class="card-text"><strong>Availability:</strong> In Stock</p>
                <a href="payment.php?amount=<?php echo $item['price']; ?>&food=<?php echo $item['name']; ?>" class="btn btn-primary">Order Now</a>
              </div>
            </div>
          </div>
      <?php
        }
      ?>          
        </div>
      </div>
    </section>

    <?php
      require_once './public/includes/footer.php';
      require_once './public/includes/script.php';
    ?>
  </body>
</html>
