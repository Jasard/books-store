<?php
    $pageTitle = "Register";
    include 'header.php';

    include_once("config.php");

    // username and password sent from form
    if (!isset($_POST['email']) && !isset($_POST['password'])) {
        echo "<p>Wrong Email or Password</p>";
        include 'footer.php';
        exit();
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    // To protect MySQL injection (more detail about MySQL injection)
    $email = stripslashes(mysql_real_escape_string($email));
    $password = stripslashes(mysql_real_escape_string($password));

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "<p>Error: E-mail is not valid.<p>";
        include 'footer.php';
        exit();
    } else {

        $sql="SELECT * FROM users WHERE email='".$email."' LIMIT 1;";
        $result=mysql_fetch_assoc(mysql_query($sql));

        $salt = substr($result['Password'], 0, 64);
        $hash = $salt.$password;

        for ($i=0; $i<100000; $i++) {
            $hash = hash('sha256', $hash);
        }

        $hash = $salt.$hash;

        if ($hash == $result['Password']) {
            $_SESSION['email']=$email;

            $admin = $result['Admin'];
            $name = $result['Firstname'];
            $u_id = $result['U_Id'];

            $_SESSION['name']=$name;
            $_SESSION['U_Id']=$u_id;

            if($admin==1) {
                $_SESSION['admin']=1;
                header("location:admin.php");
            } else {
                header("location:books.php");
            }
        }
        else {
            echo "<p>Wrong Email or Password</p>";
        }
    }

    mysql_close($con);

    include 'footer.php';
?>