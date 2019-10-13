<?php
    include "config.php";
    if (sizeof($_POST) != 0) {
        $controller = new UserController();
        $redirect = $controller->login($_POST, $conn);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="template/login/images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="template/login/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="template/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="template/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="template/login/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="template/login/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="template/login/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="template/login/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="template/login/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="template/login/css/util.css">
    <link rel="stylesheet" type="text/css" href="template/login/css/main.css">
    <!--===============================================================================================-->
</head>

<body style="background-color: #666666;">
    <?php include "template/navbar.php"; ?>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" method="POST">
                    <span class="login100-form-title p-b-43">
                        Login
                    </span>
                    <!--
                        //flash message gagal login 
                        <div class="alert alert-danger" role="alert">
                        </div> 
                    -->
                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="email">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Email</span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="password">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Password</span>
                    </div>
                    <div class="container-login100-form-btn">
                        <button type="submit" name="button-login" class="login100-form-btn">
                            Login
                        </button>
                    </div>
                </form>
                <div class="login100-more" style="
						background-image: url('template/login/images/logo_kab_bandung.png');
						background-size: 40%;
						">
                </div>
            </div>
        </div>
    </div>




    <!--===============================================================================================-->
    <script src="template/login/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="template/login/vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="template/login/vendor/bootstrap/js/popper.js"></script>
    <script src="template/login/template/login/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="template/login/vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="template/login/vendor/daterangepicker/moment.min.js"></script>
    <script src="template/login/vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="template/login/vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="template/login/js/main.js"></script>
</body>

</html>