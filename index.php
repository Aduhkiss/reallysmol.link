<?php
require('common.php');
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
        font-size: 50px;
        text-align: center;
      }
      p, form {
        text-align: center;
      }
      .big {
        border: 3px solid purple;
        border-radius: 25px;
        padding: 20px; 
        width: 50%;
        height: 55%;
        margin: auto;
      }
      .bottom-text {
        font-size: 20px;
      }
    </style>
  </head>

  <body>
    <div class="big">
    <h1>Welcome to ReallySmol.Link!</h1>
    <hr>
    <p>A drop dead simple link shortener for pros</p>
    <br>

    <form action="/action/shorten.php" method="POST">
      <input type="text" name="url" placeholder="Link to Shorten!">
      <input type="submit" value="Shorten!">
    </form><br>

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
  </div>
  </body>

</html>