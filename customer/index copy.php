<?php
  require_once './model/session.php';
  require_once './config/database.php';
  require_once './model/function.php';
  require_once './model/auth.php';
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
        <div class="header__image">
          <img src="./public/assets/img/food.png" alt="header" />
        </div>
        <div class="header__content">
          <div class="header__tag">
            More than Faster
            <img src="./public/assets/img/d.png" alt="header tag" />
          </div>
          <h1>Be The Fastest In Delivering Your <span>Food</span></h1>
          <p class="section__description">
            Our job is to filling your tummy with delicious food and with fast
            and free delivery.
          </p>
          <div class="header__btns">
            <a href="./menu.php" class="btn" style="color: white">Order Now</a>
            <a href="./reservation.php">Make Reservation</a>
          </div>
        </div>
      </div>
    </header>

    <section class="section__container service__container" id="service">
      <p class="section__subheader">WHAT WE SERVE</p>
      <h2 class="section__header">Your Favourite Food Delivery Partner</h2>
      <div class="service__grid">
        <div class="service__card">
          <img src="./public/assets/img/service-1.webp" alt="service" />
          <h4>Easy To Order</h4>
          <p>You only need a few steps in ordering food</p>
        </div>
        <div class="service__card">
          <img src="./public/assets/img/service-1.webp" alt="service" />
          <h4>Fastest Delivery</h4>
          <p>Delivery that is always ontime even faster</p>
        </div>
        <div class="service__card">
          <img src="./public/assets/img/service-1.webp" alt="service" />
          <h4>Best Quality</h4>
          <p>Not only fast for us quality is also number one</p>
        </div>
      </div>
    </section>

    <section class="section__container menu__container" id="menu">
      <p class="section__subheader">OUR MENU</p>
      <h2 class="section__header">Menu That Always Make You Fall In Love</h2>
      <div class="swiper">
        <div class="swiper-wrapper">
          <!-- Slides -->
          <?php
            $menu_items = fetchMenuItems();
            foreach ($menu_items as $item) {
          ?>
            <div class="swiper-slide">
              <div class="menu__card">
                <img src="./public/assets/img/menu/<?php echo htmlspecialchars(basename($item['image'])); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" style="width: 100%; height: auto; object-fit: cover;">
                <div class="menu__card__details">
                  <h4><?php echo htmlspecialchars($item['name']); ?></h4>
                  <h5><span>$</span><?php echo htmlspecialchars($item['price']); ?></h5>
                  <a href="payment.php?amount=<?php echo htmlspecialchars($item['price']); ?>&food=<?php echo urlencode($item['name']); ?>">
                    Order Now
                    <span><i class="ri-arrow-right-line"></i></span>
                  </a>
                </div>
              </div>
            </div>
          <?php
            }
          ?>
        </div>
      </div>
    </section>

    <section class="section__container client__container" id="client">
      <div class="client__image">
        <img src="./public/assets/img/client.jpg" alt="client" />
      </div>
      <div class="client__content">
        <p class="section__subheader">WHAT THEY SAY</p>
        <h2 class="section__header">What Our Customer Say About Us</h2>
        <p class="section__description">
          "Restaurant is simply outstanding! The variety and deliciousness of their
          meals are unparalleled, offering something for every palate. What sets
          Restaurant apart is their exceptional service. The delivery is impressively
          fast, ensuring your food arrives hot and fresh."
        </p>
        <div class="client__details">
          <img src="./public/assets/img/client.jpg" alt="client" />
          <div>
            <h4>Theresa Jordan</h4>
            <h5>Food Enthusiast</h5>
          </div>
        </div>
        <div class="client__rating">
          <span><i class="ri-star-fill"></i></span>
          <span><i class="ri-star-fill"></i></span>
          <span><i class="ri-star-fill"></i></span>
          <span><i class="ri-star-fill"></i></span>
          <span><i class="ri-star-line"></i></span>
          <span>4.8</span>
        </div>
      </div>
    </section>

    <!-- <section class="download__container" id="contact">
      <div class="section__container">
        <div class="download__image">
          <img src="./public/assets/img/download.png" alt="download" />
        </div>
        <div class="download__content">
          <p class="section__subheader">DOWNLOAD APP</p>
          <h2 class="section__header">Get Started With Restaurant Today!</h2>
          <p class="section__description">
            Discover food wherever and whenever you want and get your food
            delivered on time, everytime.
          </p>
          <div class="download__btn">
            <button class="btn">Get The App</button>
          </div>
        </div>
      </div>
    </section> -->

    <?php
      require_once './public/includes/footer.php';
      require_once './public/includes/script.php';
    ?>
  </body>
</html>