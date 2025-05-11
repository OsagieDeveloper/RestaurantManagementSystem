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

      <!-- Menu Navigation Bar -->
      <ul class="nav nav-pills justify-content-center mb-5" id="menuTab" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active" id="food-tab" data-bs-toggle="tab" data-bs-target="#food" role="tab" aria-controls="food" aria-selected="true" href="#food">Food</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="drink-tab" data-bs-toggle="tab" data-bs-target="#drink" role="tab" aria-controls="drink" aria-selected="false" href="#drink">Drinks</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="dessert-tab" data-bs-toggle="tab" data-bs-target="#dessert" role="tab" aria-controls="dessert" aria-selected="false" href="#dessert">Desserts</a>
        </li>
      </ul>

      <!-- Menu Items Content -->
      <div class="tab-content" id="menuTabContent">
        <!-- Food Tab -->
        <div class="tab-pane fade show active" id="food" role="tabpanel" aria-labelledby="food-tab">
          <div class="container">
            <h3 class="mt-4 mb-4">Food Menu</h3>
            <div class="row row-cols-1 row-cols-md-3 g-4">
          <?php
            $menu_items = fetchMenuItems();
            $food_items = array_filter($menu_items, function($item) {
                return $item['type'] === 'food';
            });
            foreach ($food_items as $item) {
          ?>
              <div class="col">
                <div class="card">
                  <?php if (!empty($item['image'])): ?>
                    <img src="./public/assets/img/menu/<?php echo htmlspecialchars(basename($item['image'])); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($item['name']); ?>" style="width: 100%; height: auto; object-fit: cover;">
                  <?php else: ?>
                    <img src="./public/assets/img/placeholder-food.jpg" class="card-img-top" alt="Placeholder Image" style="width: 100%; height: auto; object-fit: cover;">
                  <?php endif; ?>
                  <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($item['name']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($item['description'] ?? 'No description available'); ?></p>
                    <p class="card-text"><span>$</span><?php echo htmlspecialchars($item['price']); ?></p>
                    <p class="card-text"><strong>Availability:</strong> In Stock</p>
                    <a href="payment.php?amount=<?php echo htmlspecialchars($item['price']); ?>&food=<?php echo htmlspecialchars($item['name']); ?>" class="btn btn-primary">Order Now</a>
                  </div>
                </div>
              </div>
          <?php
            }
          ?>          
            </div>
          </div>
        </div>
        
        <!-- Drink Tab -->
        <div class="tab-pane fade" id="drink" role="tabpanel" aria-labelledby="drink-tab">
          <div class="container">
            <h3 class="mt-4 mb-4">Drink Menu</h3>
            <div class="row row-cols-1 row-cols-md-3 g-4">
          <?php
            $drink_items = array_filter($menu_items, function($item) {
                return $item['type'] === 'drink';
            });
            foreach ($drink_items as $item) {
          ?>
              <div class="col">
                <div class="card">
                  <?php if (!empty($item['image'])): ?>
                    <img src="./public/assets/img/menu/<?php echo htmlspecialchars(basename($item['image'])); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($item['name']); ?>" style="width: 100%; height: auto; object-fit: cover;">
                  <?php else: ?>
                    <img src="../public/assets/img/placeholder-drink.jpg" class="card-img-top" alt="Placeholder Image" style="width: 100%; height: auto; object-fit: cover;">
                  <?php endif; ?>
                  <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($item['name']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($item['description'] ?? 'No description available'); ?></p>
                    <p class="card-text"><span>$</span><?php echo htmlspecialchars($item['price']); ?></p>
                    <p class="card-text"><strong>Availability:</strong> In Stock</p>
                    <a href="payment.php?amount=<?php echo htmlspecialchars($item['price']); ?>&food=<?php echo htmlspecialchars($item['name']); ?>" class="btn btn-primary">Order Now</a>
                  </div>
                </div>
              </div>
          <?php
            }
          ?>          
            </div>
          </div>
        </div>
        
        <!-- Dessert Tab -->
        <div class="tab-pane fade" id="dessert" role="tabpanel" aria-labelledby="dessert-tab">
          <div class="container">
            <h3 class="mt-4 mb-4">Dessert Menu</h3>
            <div class="row row-cols-1 row-cols-md-3 g-4">
          <?php
            $dessert_items = array_filter($menu_items, function($item) {
                return $item['type'] === 'dessert';
            });
            foreach ($dessert_items as $item) {
          ?>
              <div class="col">
                <div class="card">
                  <?php if (!empty($item['image']) && file_exists('public/assets/img/' . basename($item['image']))): ?>
                    <img src="./public/assets/img/<?php echo htmlspecialchars(basename($item['image'])); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($item['name']); ?>" style="width: 100%; height: auto; object-fit: cover;">
                  <?php else: ?>
                    <img src="./public/assets/img/placeholder-food.jpg" class="card-img-top" alt="Placeholder Image" style="width: 100%; height: auto; object-fit: cover;">
                  <?php endif; ?>
                  <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($item['name']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($item['description'] ?? 'No description available'); ?></p>
                    <p class="card-text"><span>$</span><?php echo htmlspecialchars($item['price']); ?></p>
                    <p class="card-text"><strong>Availability:</strong> In Stock</p>
                    <a href="payment.php?amount=<?php echo htmlspecialchars($item['price']); ?>&food=<?php echo htmlspecialchars($item['name']); ?>" class="btn btn-primary">Order Now</a>
                  </div>
                </div>
              </div>
          <?php
            }
          ?>          
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
