<?php
    require_once './model/session.php';
    require_once './config/database.php';
    require_once './model/function.php';
    require_once './model/auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="./public/assets/css/login.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 15px;
            color: #fff;
            background-color: rgba(0, 0, 0, 0.8);
            border-radius: 5px;
            font-size: 14px;
            z-index: 9999;
            display: none;
        }
        .toast.success {
            background-color: #4caf50;
        }
        .toast.error {
            background-color: #f44336;
        }
    </style>
</head>
<body class="body">
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form id="signupForm" method="POST">
                <h1>Create Account</h1>
                <?php 
                    if(isset($err2)){?>
                        <p class="text-danger"><?php echo $err2; ?></p>
                    <?php }else if(isset($suc2)){ ?>
                        <p class="text-success"><?php echo $suc2; ?></p>
                    <?php }
                ?>
                <div class="infield">
                    <input type="text" placeholder="Full Name" id="signupName" name="name" required />
                </div>
                <div class="infield">
                    <input type="email" placeholder="Email" id="signupEmail" name="email" required />
                </div>
                <div class="infield">
                    <input type="text" placeholder="Mobile Number" id="signupMobile" name="mobile" required />
                </div>
                <div class="infield">
                    <input type="text" placeholder="Address" id="signupAddress" name="address" required />
                </div>
                <div class="infield">
                    <input type="password" placeholder="Password" id="signupPassword" name="password" required />
                </div>
                <button type="submit" name="signup">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form id="loginForm" method="POST">
                <h1>Sign in</h1>
                <?php 
                    if (isset($err)) { ?>
                        <p class="text-danger"><?php echo $err; ?></p>
                    <?php } else if (isset($suc)) { ?>
                        <p class="text-success"><?php echo $suc; ?></p>
                    <?php }
                ?>
                <div class="infield">
                    <input type="email" placeholder="Email" id="loginEmail" name="email" required />
                </div>
                <div class="infield">
                    <input type="password" placeholder="Password" id="loginPassword" name="password" required />
                </div>
                <div class="infield">
                    <select id="role" name="role" required>
                        <option value="">-- Select Role --</option>
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>
                <a href="#" class="forgot">Forgot your password?</a>
                <button type="submit" name="signin">Sign In</button>
            </form>
        </div>
        <div class="overlay-container" id="overlayCon">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Hello again!</h1>
                    <p>To keep in touch, please login with your credentials</p>
                    <button id="signInBtn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello again!</h1>
                    <p>Enter your credentials and start an account with us</p>
                    <button id="signUpBtn">Sign Up</button>
                </div>
            </div>
            <button id="overlayBtn"></button>
        </div>
    </div>

    <div class="toast" id="toast"></div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <script>
        const container = document.getElementById('container');
        const overlayBtn = document.getElementById('overlayBtn');
        const signUpBtn = document.getElementById('signUpBtn');
        const signInBtn = document.getElementById('signInBtn');

        // Load panel state from localStorage
        const activePanel = localStorage.getItem('activePanel');
        if (activePanel === 'signup') {
            container.classList.add('right-panel-active');
        }

        // Toggle the active panel and save the state
        overlayBtn.addEventListener('click', () => {
            container.classList.toggle('right-panel-active');
            saveActivePanel();
        });

        signUpBtn.addEventListener('click', () => {
            container.classList.add('right-panel-active');
            saveActivePanel();
        });

        signInBtn.addEventListener('click', () => {
            container.classList.remove('right-panel-active');
            saveActivePanel();
        });

        function saveActivePanel() {
            if (container.classList.contains('right-panel-active')) {
                localStorage.setItem('activePanel', 'signup');
            } else {
                localStorage.setItem('activePanel', 'signin');
            }
        }

        overlayBtn.addEventListener('click', () => {
            overlayBtn.classList.remove('btnScaled');
            window.requestAnimationFrame(() => {
                overlayBtn.classList.add('btnScaled');
            });
        });
    </script>

</body>
</html>