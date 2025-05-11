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
            <?php require_once './public/includes/nav.php'; ?>
        </header>

        <section class="d-flex align-items-center justify-content-center vh-100 bg-light">
            <div style="max-width: 800px; width: 100%;">
                <h2 class="text-center mt-5 mb-3">About Us</h2>
                <p class="lead text-center">Welcome to our restaurant, where we serve delicious and unforgettable meals in a warm and welcoming atmosphere. Our team is dedicated to providing excellent service and creating lasting memories for our guests.</p>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <h3>Our Story</h3>
                        <p>
                            Founded in 2024, our restaurant has become a beloved establishment known for its food. We strive to offer not just great food, but an exceptional experience for all our guests. 
                        </p>
                        <p>
                            Our chefs use only the freshest, locally sourced ingredients to create each dish with care and passion. Whether you're here for a casual meal or celebrating a special occasion, we promise a dining experience that is second to none.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h3>Our Mission</h3>
                        <p>
                            Our mission is to provide an exceptional dining experience with a focus on quality, innovation, and sustainability. We aim to be a place where guests can enjoy great food, excellent service, and a sense of belonging.
                        </p>
                        <p>
                            We are committed to offering a diverse menu that caters to different tastes and dietary needs. Our goal is to create a space where everyone feels welcome, valued, and satisfied.
                        </p>
                    </div>
                </div>

                <div class="mt-4">
                    <h3>Meet the Team</h3>
                    <p>Our team is the heart of our restaurant, and we are proud to have a passionate group of professionals who are dedicated to making your dining experience memorable.</p>
                    <div class="row">
                        <div class="col-md-4">
                            <h4>John Doe - Head Chef</h4>
                            <p>With over 20 years of experience, John brings a wealth of knowledge and culinary expertise to the kitchen, ensuring every dish is prepared to perfection.</p>
                        </div>
                        <div class="col-md-4">
                            <h4>Jane Smith - Restaurant Manager</h4>
                            <p>Jane oversees the operations of the restaurant, ensuring that everything runs smoothly and that guests receive top-notch service.</p>
                        </div>
                        <div class="col-md-4">
                            <h4>Michael Brown - Sous Chef</h4>
                            <p>Michael is responsible for supporting the kitchen team, ensuring that our dishes are consistently delicious and prepared with the utmost care.</p>
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