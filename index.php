<?php
require('common.php');

/*

		reallysmol.link
		
		Made with <3 by Atticus Zambrana

*/

?>

<html>
  <head>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZJVWJB3YVN"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-ZJVWJB3YVN');
    </script>
    <title>Home · ReallySmol.Link</title>

    <style>
      .message-box {
        border-style: double;
      }
      h1 {
        font-family: 'Open Sans', sans-serif;
        font-size: 70px;
        text-align: center;
      }
      p, form {
        text-align: center;
		font-size: 20px;
		font-family: 'Open Sans', sans-serif;
      }
      .big {
        border: 3px solid purple;
        border-radius: 25px;
        padding: 20px; 
        width: 50%;
        height: 60%;
        margin: auto;
      }
      .bottom-text {
        font-size: 20px;
      }
	  .button {
	  text-align: center;
	  font: bold 11px Arial;
	  text-decoration: none;
	  background-color: #EEEEEE;
	  color: #333333;
	  padding: 2px 6px 2px 6px;
	  border-top: 1px solid #CCCCCC;
	  border-right: 1px solid #333333;
	  border-bottom: 1px solid #333333;
	  border-left: 1px solid #CCCCCC;
	}
    </style>
  </head>

  <body>
    <div class="big">
    <h1>ReallySmol.Link!</h1>
    <hr>
    <p>A super easy to use link shortener that anyone can use</p>
    <br>
	
	<?php
	$ip = $_SERVER['REMOTE_ADDR'];
	$banned = false;
	$ban_reason = "";
	$check = $db->execute_query("SELECT * FROM `banned_ips` WHERE `ip` = ?", [$ip]);
	foreach($check as $row) {
		$banned = true;
		$ban_reason = $row['reason'];
	}
	
	
	/*
		adding a "ban system"
		i'm aware this is incredibly easy to evade if you know how to make basic HTTP POST requests manually, and will
		patch that out later. but i dont feel like it right now.
		
		...unless you want to o_O
	*/
	
	if($banned) {
		echo '<div class="message-box"><p><strong>You are banned from this service! </strong> ' . $ban_reason . '</p></div><br><br>';
	} else {
		echo '<form action="/action/shorten.php" method="POST">
      <input type="text" name="url" placeholder="Link to Shorten!">
      <input type="submit" value="Shorten!">
    </form><br>';
	}
	?>

    

    <?php
    if(isset($_GET['go'])) {
      // Search this link and goto it, also up the click counter by one
      $result = $db->execute_query("SELECT * FROM `shorter` WHERE `link_id` = ?", [$_GET['go']]);
      foreach ($result as $row) {
        $clicks = $row['clicks'];

        $db->query("UPDATE `shorter` SET `clicks` = " . $clicks + 1 . " WHERE `link_id` = '" . $_GET['go'] . "';");
        header("Location: " . $row["location"]);
      }
      // The user should have been sent over already if we had something in our system
      // Otherwise it should be assumed that no link exists there anymore
      // Send them an error message
      echo '<div class="message-box"><p>I\'m sorry, there was no link found with that ID. Did you mis-spell it?</p></div>';
    }

    //echo '<div class="message-box"><p><strong>This is a test</strong> This is an announcement</p></div><br><br>';

    if(isset($_GET['message'])) {
      $id = $_GET['id'];
      if($_GET['message'] == "done") { echo '<div class="message-box"><p>Successfully Added Link!<br>Shortened Link: <strong>http://reallysmol.link?go=' . $id . '</strong></p></div>';}
    }
    ?>

    <br><br><br><br><br><br><br>
    <i><p class="bottom-text">Made with ❤️ by Atticus Zambrana</p></i>
	<!-- I can't fucking figure out how to center these, someone else please deal with it -->
	<a href="https://twitter.com/Aduhkiss" class="button">Twitter / X</a>
	<a href="https://bsky.app/profile/thecloudyco.com" class="button">Blue Sky</a>
	<a href="https://github.com/Aduhkiss" class="button">GitHub</a>
	<a href="https://www.youtube.com/channel/UCbFbmh83WSgOtz7sV9bVSwg" class="button">YouTube</a>
  </div>
  </body>

</html>