<?php
  $DB_USERNAME = "root";
  $DB_PASSWORD = "";
  $DB_HOST = "localhost";
  $DB_DATABASE = "book_store";
  $MERCHANT_ID = "128073195227682";
  $MERCHANT_KEY = "iZjWUufRaiuuj9ijcAtCxA";

  $con = mysql_connect($DB_HOST,$DB_USERNAME,$DB_PASSWORD) or die('Could not connect to database');
  mysql_select_db($DB_DATABASE, $con);
?>