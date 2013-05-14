<?php
    include_once("config.php");

    if (empty($_POST)){
        header("location:index.php");
        exit();
    }

    $firstName            = stripslashes(mysql_real_escape_string($_POST['firstName']));
    $surname           = stripslashes(mysql_real_escape_string($_POST['surname']));
    $email            = stripslashes(mysql_real_escape_string($_POST['email']));
    $password      = stripslashes(mysql_real_escape_string($_POST['password']));

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "Error: E-mail is not valid.";
        exit();
    } else {
        if (isset($firstName) && strlen($firstName)>0 &&
            isset($surname) && strlen($surname)>0 &&
            isset($email) && strlen($email)>0 &&
            isset($password) && strlen($password)>0
        ) {
            $firstName = filter_var($firstName,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            $surname = filter_var($surname,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            $email = filter_var($email,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            $password = filter_var($password,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

            $salt = hash('sha256', uniqid(mt_rand(), true) . 'books for sale' . strtolower($surname));

            $hash = $salt . $password;

            for ($i = 0; $i < 100000; $i++) {
                $hash = hash('sha256', $hash);
            }

            $hash = $salt.$hash;

            $sql="SELECT * FROM users WHERE email='".$email."' LIMIT 1;";
            $result=mysql_fetch_assoc(mysql_query($sql));

            if (!empty($result)) {
                echo "Error: E-mail already signed up.";
                exit();
            } else {
                mysql_query("INSERT INTO users (Firstname, Surname, Email, Password) VALUES('".$firstName."', '".$surname."', '".$email."', '".$hash."')");
                echo "success";
            }
        }
    }
    mysql_close($con);
?>