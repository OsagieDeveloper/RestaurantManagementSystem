<?php
    require_once './model/session.php';
    require_once './config/database.php';
    require_once './model/function.php';
    if (empty($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(random_bytes(32)); // Generates a unique token for each session
    }
    require_once './model/contact.php';
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
            <div style="max-width: 700px; width: 100%;">
                <!-- Contact Form -->
                <h2 class="text-center mt-5 mb-3">Contact the Restaurant</h2>
                <?php 
                    if(isset($err)){?>
                        <p class="text-danger"><?php echo $err; ?></p>
                    <?php }else if(isset($suc)){ ?>
                        <p class="text-success"><?php echo $suc; ?></p>
                    <?php }
                ?>
                <form method="POST" class="needs-validation" novalidate>
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
                    <div class="mb-3">
                        <label for="contact_name" class="form-label">Your Name</label>
                        <input
                            type="text"
                            id="contact_name"
                            name="contact_name"
                            class="form-control"
                            placeholder="Your Full Name"
                            required
                        />
                        <div class="invalid-feedback">Please enter your name.</div>
                    </div>
                    <div class="mb-3">
                        <label for="contact_email" class="form-label">Email Address</label>
                        <input
                            type="email"
                            id="contact_email"
                            name="contact_email"
                            class="form-control"
                            placeholder="Your Email Address"
                            required
                        />
                        <div class="invalid-feedback">Please enter a valid email address.</div>
                    </div>
                    <div class="mb-3">
                        <label for="inquiry_type" class="form-label">Inquiry Type</label>
                        <select id="inquiry_type" name="inquiry_type" class="form-control" required>
                            <option value="">Select Inquiry Type</option>
                            <option value="private_event">Private Event</option>
                            <option value="custom_dining">Custom Dining Arrangement</option>
                            <option value="other">Other</option>
                        </select>
                        <div class="invalid-feedback">Please select the inquiry type.</div>
                    </div>
                    <div class="mb-3">
                        <label for="contact_message" class="form-label">Your Message</label>
                        <textarea
                            id="contact_message"
                            name="contact_message"
                            rows="4"
                            class="form-control"
                            placeholder="Tell us about your inquiry or special request."
                            required
                        ></textarea>
                        <div class="invalid-feedback">Please provide a message.</div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" name="contactForm">Send Inquiry</button>
                </form>
            </div>
        </section>

        <?php
        require_once './public/includes/footer.php';
        require_once './public/includes/script.php';
        ?>
        <script>
            // Bootstrap form validation
            (() => {
                'use strict';
                const forms = document.querySelectorAll('.needs-validation');
                Array.from(forms).forEach(form => {
                    form.addEventListener(
                        'submit',
                        event => {
                            if (!form.checkValidity()) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        },
                        false
                    );
                });
            })();
        </script>
    </body>
</html>