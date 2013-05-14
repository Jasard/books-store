<?php
    include_once("config.php");

    $result = mysql_query("SELECT * FROM books ORDER BY DateAdded DESC");

    $array = array();

    while($row = mysql_fetch_assoc($result)) {
        $array[] = $row;
    }

    echo json_encode($array);

    mysql_close($con);
?>