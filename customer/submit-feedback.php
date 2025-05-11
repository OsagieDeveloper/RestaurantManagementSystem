<?php
    require_once './model/session.php';
    require_once './config/database.php';
    require_once './model/function.php';
    if (empty($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(random_bytes(32)); // Generates a unique token for each session
    }
    require_once './model/feedback.php';
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
                <h2 class="text-center mb-4">Feedback and Communication</h2>
                
                <!-- Feedback Form -->
                <h4 class="text-center mb-3">Provide Your Feedback</h4>
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
                        <label for="rating" class="form-label">Rating</label>
                        <select id="rating" name="rating" class="form-control" required>
                            <option value="">Select Rating</option>
                            <option value="1">1 - Poor</option>
                            <option value="2">2 - Fair</option>
                            <option value="3">3 - Good</option>
                            <option value="4">4 - Very Good</option>
                            <option value="5">5 - Excellent</option>
                        </select>
                        <div class="invalid-feedback">Please select a rating.</div>
                    </div>
                    <div class="mb-3">
                        <label for="dish_review" class="form-label">Review for Specific Dishes</label>
                        <textarea
                            id="dish_review"
                            name="dish_review"
                            rows="3"
                            class="form-control"
                            placeholder="What did you think of the dishes?"
                        ></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="general_feedback" class="form-label">General Feedback</label>
                        <textarea
                            id="general_feedback"
                            name="general_feedback"
                            rows="4"
                            class="form-control"
                            placeholder="Any additional comments or suggestions?"
                        ></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" name="submitFeedback">Submit Feedback</button>
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
