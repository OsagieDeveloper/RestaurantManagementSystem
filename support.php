<?php
    require_once './model/session.php';
    require_once './config/database.php';
    require_once './model/function.php';
    
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitSupportQuery'])) {
        $name = secureData($_POST['name']);
        $email = secureData($_POST['email']);
        $subject = secureData($_POST['subject']);
        $message = secureData($_POST['message']);
        $created_at = date('Y-m-d H:i:s');
        
        // Insert query into database
        $query = "INSERT INTO support_queries (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('sssss', $name, $email, $subject, $message, $created_at);
        
        if ($stmt->execute()) {
            $successMessage = "Your query has been submitted successfully!";
        } else {
            $errorMessage = "There was an error submitting your query. Please try again.";
        }
        $stmt->close();
    }
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
                <h2 class="text-center mb-4">Customer Support</h2>
                <?php 
                    if (isset($successMessage)) { ?>
                        <p style="color: green; text-align: center;"><?php echo $successMessage; ?></p>
                    <?php } else if (isset($errorMessage)) { ?>
                        <p style="color: red; text-align: center;"><?php echo $errorMessage; ?></p>
                    <?php }
                ?>
                <p class="text-center mb-4 text-muted">
                    Have a question or concern? Submit your query below and our team will get back to you as soon as possible.
                </p>
                <form method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control"
                            placeholder="Your Full Name"
                            required
                        />
                        <div class="invalid-feedback">Please enter your name.</div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            placeholder="Your Email Address"
                            required
                        />
                        <div class="invalid-feedback">Please enter a valid email address.</div>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input
                            type="text"
                            id="subject"
                            name="subject"
                            class="form-control"
                            placeholder="Subject of your query"
                            required
                        />
                        <div class="invalid-feedback">Please enter a subject.</div>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Your Message</label>
                        <textarea
                            id="message"
                            name="message"
                            rows="4"
                            class="form-control"
                            placeholder="Describe your query or issue in detail."
                            required
                        ></textarea>
                        <div class="invalid-feedback">Please provide a message.</div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" name="submitSupportQuery">Submit Query</button>
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
