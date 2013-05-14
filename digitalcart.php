<?php
/**
 * Copyright (C) 2007 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

 chdir("..");
// Include all the required files
require_once('library/googlecart.php');
require_once('library/googleitem.php');
require_once('library/googleshipping.php');
require_once('config.php');


Usecase();
function Usecase() {
  $merchant_id = "128073195227682";  // Your Merchant ID
  $merchant_key = "iZjWUufRaiuuj9ijcAtCxA";  // Your Merchant Key
  $server_type = "sandbox";
  $currency = "GBP";
  $cart = new GoogleCart($merchant_id, $merchant_key, $server_type,
  $currency);
  $total_count = 1;
  $certificate_path = "cacert.pem"; // set your SSL CA cert path

  session_start();

  if (isset($_GET['id']) && isset($_SESSION['email'])) {
    $id = $_GET['id'];
    $uid = $_SESSION['U_Id'];

    include_once("config.php");

    $result = mysql_query("SELECT * FROM books WHERE B_Id=".$id);
    $row = mysql_fetch_assoc($result);

    if (empty($row)) {
      echo 'Error: Book not found!';
      include 'footer.php';
      exit();
    }

    $title = $row['Title'];
    $id = $row['B_Id'];
    $description = $row['Description'];
    $price = $row['Price'];
  } else {
    header("location:index.php");
    exit();
  }

//  Check this URL for more info about the two types of digital Delivery
//  http://code.google.com/apis/checkout/developer/Google_Checkout_Digital_Delivery.html

//  Key/URL delivery
  $item_1 = new GoogleItem($title,      // Item name
                           $description, // Item description
                           $total_count, // Quantity
                           $price); // Unit price

  $key = mt_rand();

  $_SESSION['did']=$key;

  $key = $key.$uid;

  $item_1->SetURLDigitalContent('http://127.0.0.1/books/download.php?bid='.$id.'&key='.$key);
  $cart->AddItem($item_1);

  // Specify "Return to xyz" link
  $cart->SetContinueShoppingUrl("http://127.0.0.1/books/books.php");

  // Request buyer's phone number
  $cart->SetRequestBuyerPhone(true);

// Add analytics data to the cart if its setted
  if(isset($_POST['analyticsdata']) && !empty($_POST['analyticsdata'])){
    $cart->SetAnalyticsData($_POST['analyticsdata']);
  }
// This will do a server-2-server cart post and send an HTTP 302 redirect status
// This is the best way to do it if implementing digital delivery
// More info http://code.google.com/apis/checkout/developer/index.html#alternate_technique
  list($status, $error) = $cart->CheckoutServer2Server('', $certificate_path);
  // if i reach this point, something was wrong
  echo "An error had ocurred: <br />HTTP Status: " . $status. ":";
  echo "<br />Error message:<br />";
  echo $error;

  mysql_close($con);
//
}
?>