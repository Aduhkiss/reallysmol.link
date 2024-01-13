<?php
require('../common.php');
$id = generateRandomString();
$location = $_POST['url'];

//TODO: Make sure this ID doesn't already exist in the system before
$ip = $_SERVER['REMOTE_ADDR'];

// The system is now going to record which IP's are entering links into the system

$result = $db->execute_query("INSERT INTO `shorter` (`link_id`, `location`, `clicks`, `ip`) VALUES (?, ?, ?, ?);", [$id, $location, 0, $ip]);

header("Location: /?message=done&id=" . $id);
?>