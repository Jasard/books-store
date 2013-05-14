<?php
    include_once("config.php");

    if ($_GET['id']) {
        $id = $_GET['id'];
    }

    $result = mysql_query("SELECT * FROM reviews WHERE B_Id='".$id."' ORDER BY R_Id DESC");

    $array = array();

    while($row = mysql_fetch_assoc($result)) {
        $array[] = $row;
    }

    echo json_encode($array);

    mysql_close($con);
?>