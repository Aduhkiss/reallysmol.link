<?php

// Create connection
$db = mysqli_connect("127.0.0.1", "root", "", "testing_db");

// Check connection
if (!$db) {
  die("Connection failed: " . mysqli_connect_error());
}

function generateRandomString($length = 11) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[random_int(0, $charactersLength - 1)];
  }
  return $randomString;
}

?>