<?php
session_start();
require_once './library/config.php';
require_once './library/functions.php';
$connection = new createConnection();
$connection->connectToDatabase();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>timo - Attendance</title>

    <!-- Bootstrap -->
    <link href="./template/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="./template/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="./template/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="./template/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="./template/build/css/custom.min.css" rel="stylesheet">
</head>

<body class="login">
    <div>
        <a class="hiddenanchor" id="signin"></a>

        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <div style="border: 1px solid #D8D8D8;padding:15px;border-radius: 5px">
                    <form action="login.php" method="POST">
                        <h2>Login</h2>
                        <div>
                            <input type="text" name="user_name" class="form-control" placeholder="Username" required="" />
                        </div>
                        <div>
                            <input type="password" name="password" class="form-control" placeholder="Password" required="" />
                        </div>
                        <div class="form-group has-feedback">
                            <?php if (isset($_SESSION['log_error_mes'])) { ?>
                                <div class="alert alert-warning">
                                    <strong>Warning!</strong><?php echo $_SESSION['log_error_mes']; ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div>
                            <button type="submit" class="form-control btn btn-success">LOGIN</button>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                    </div>
                    <div class="separator">
                        <div class="clearfix"></div>
                        <br />

                        <div>
                            <p>© <?php echo date('Y'); ?>. <a href="https://github.com/dmcchanaka" target="_blank">CC CREATION HOUSE</a></p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</body>

</html>
<?php
$connection->close();
unset($_SESSION['log_error_mes']);
?>