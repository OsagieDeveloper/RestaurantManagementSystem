<?php
    require_once './model/session.php';
    require_once './config/database.php';
    require_once './model/function.php';
    require_once './model/reservation.php';

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $_SESSION['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
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
                <h2 class="text-center mb-4">Make a Reservation</h2>
                <?php 
                    if (isset($err)) { ?>
                        <p style="color: red;"><?php echo $err; ?></p>
                    <?php } else if (isset($suc)) { ?>
                        <p style="color: green;"><?php echo $suc; ?></p>
                    <?php }
                ?>
                <p class="text-center mb-4 text-muted">
                    Reserve your table now and enjoy a delightful dining experience with us.
                </p>
                <form method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <label for="name" class="form-label">Name</label>
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
                        <label for="email" class="form-label">Email</label>
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
                        <label for="phone" class="form-label">Phone</label>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            class="form-control"
                            placeholder="Your Phone Number"
                            required
                        />
                        <div class="invalid-feedback">Please enter your phone number.</div>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input
                            type="date"
                            id="date"
                            name="date"
                            class="form-control"
                            required
                        />
                        <div class="invalid-feedback">Please select a date.</div>
                    </div>
                    <div class="mb-3">
                        <label for="time" class="form-label">Time</label>
                        <input
                            type="time"
                            id="time"
                            name="time"
                            class="form-control"
                            required
                        />
                        <div class="invalid-feedback">Please select a time.</div>
                    </div>
                    <div class="mb-3">
                        <label for="guests" class="form-label">Number of Guests</label>
                        <input
                            type="number"
                            id="guests"
                            name="guests"
                            class="form-control"
                            placeholder="Number of Guests"
                            min="1"
                            required
                        />
                        <div class="invalid-feedback">Please specify the number of guests.</div>
                    </div>
                    <div class="mb-3">
                        <label for="requests" class="form-label">Special Requests (Optional)</label>
                        <textarea
                            id="requests"
                            name="requests"
                            rows="3"
                            class="form-control"
                            placeholder="Any special requests?"
                        ></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" name="createReservation">Reserve Now</button>
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
