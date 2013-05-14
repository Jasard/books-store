<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Book Store | <?php echo $pageTitle; ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <body>

        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="index.php">Book Store</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="books.php">Books</a></li>
                            <li><a href="about.php">About</a></li>

                        <?php
                            session_start();
                            if(!isset($_SESSION['email'])) {
                                echo'<li><a href="register.php">Register</a></li>
                                    </ul>
                                    <form class="navbar-form pull-right" id="login" method="post" action="check-login.php">
                                        <input class="span2" type="text" name="email" placeholder="Email">
                                        <input class="span2" type="password" name="password" placeholder="Password">
                                        <button type="submit" class="btn">Sign in</button>
                                    </form>';
                            } else {
                                echo '</ul><form class="navbar-form pull-right" method="" action="logout.php"><i>Hello, '.$_SESSION['name'].' </i>';
                                if(isset($_SESSION['admin'])) {
                                    echo '<a href="admin.php" class="btn">Admin Panel</a> ';
                                }
                                echo '<button type="submit" class="btn">Log Out</button></form>';
                            }
                        ?>

                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <div class="container">