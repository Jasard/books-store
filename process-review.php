<?php
    include_once("config.php");

    session_start();

    if (empty($_POST)){
        header("location:index.php");
        exit();
    }

    $b_id           = mysql_real_escape_string($_POST['b_Id']);

    if(isset($_SESSION['email'])) {
      $u_id = $_SESSION['U_Id'];

      $result = mysql_query("SELECT * FROM reviews WHERE U_Id=".$u_id." and B_Id=".$b_id);
      $row = mysql_fetch_assoc($result);
      if (!empty($row)) {
        header("location:index.php");
        exit();
      }
    }

    $review            = stripslashes(mysql_real_escape_string($_POST['review']));
    $rating           = stripslashes(mysql_real_escape_string($_POST['rating']));
    $u_id           = stripslashes(mysql_real_escape_string($_POST['u_Id']));
    $name           = stripslashes(mysql_real_escape_string($_POST['name']));

    if (isset($review) && strlen($review)>0 &&
        isset($rating) && strlen($rating)>0 &&
        isset($u_id) && strlen($u_id)>0 &&
        isset($b_id) && strlen($b_id)>0 &&
        isset($name) && strlen($name)>0
    ) {
        $review = filter_var($review,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $rating = filter_var($rating,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $u_id = filter_var($u_id,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $b_id = filter_var($b_id,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $name = filter_var($name,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        mysql_query("INSERT INTO reviews (Review, Rating, U_Id, B_Id, Name) VALUES('".$review."', '".$rating."', '".$u_id."', '".$b_id."', '".$name."')");
        echo "success";
    }
    mysql_close($con);
?>