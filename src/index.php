<?php
  // hiei index page - index.php
  // (c) prefetcher 2017

  // Include the config file
  require('config.php');

  // Get a list of all the files in the article directory specified in config and sort them by date of modification.
  $articles = glob($hiei_storage . "/*.md");
  usort($articles, function($a, $b) {
      return filemtime($a) < filemtime($b);
  });
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="static/milligram.min.css">
    <link rel="stylesheet" type="text/css" href="static/hiei.css">
    <link rel="shortcut icon" href="static/favicon.ico">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="<?php echo $hiei_title; ?>">
    <meta property="og:description" content="<?php echo $hiei_subtitle; ?>">
    <title><?php echo $hiei_title; ?></title>
  </head>
  <body>
    <header>
      <h1><?php echo $hiei_title; ?></h1>
      <span><?php echo $hiei_subtitle; ?></span>
    </header>
    <?php
      // Loop through every article found
      foreach($articles as $article) {
        $filename = basename($article, ".md"); // Get the base filename
        $creation_date = date("d-m-Y", filemtime($article)); // Get the creation date DD-MM-YYYY

        // Get the title of the post
        $file = fopen($article, 'r');
        $title = fgets($file);
        fclose($file);
        $title = str_replace("#", "", $title); // Hacky but works.

        // Echo it to the client
        echo '<hr><article>';
        echo '<a href="article.php?name=' . $filename . '">' . $title . '</a>';
        echo '<time class="right" datetime="' . $creation_date . '">' . $creation_date . '</time>';
        echo '</article>';
      }
    ?>
    <footer class="right">
      <small><?php echo $hiei_footer; ?> | powered by <a href="https://github.com/naomiEve/hiei">hiei</a></small>
    </footer>
  </body>
</html>
