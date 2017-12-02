<?php
  // hiei article reader - article.php
  // (c) prefetcher 2017

  // Include neccessary files
  require('config.php');
  require('parsedown.php');

  // Get full path to article
  $article_path = $hiei_storage . "/" . $_GET['name'] . ".md";
  $creation_date = date("d-m-Y", filemtime($article_path));

  // Get the article contents
  $article_handler = fopen($article_path ,"r");
  $title = str_replace("#", "", fgets($article_handler)); // Dirty hack to get the title of the article
  $article = fread($article_handler, filesize($article_path));
  fclose($article_handler);

  // Prepare markdown parser
  $parsedown = new Parsedown();

?>
<!DOCTYPE HTML>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="static/milligram.min.css">
    <link rel="stylesheet" type="text/css" href="static/hiei.css">
    <link rel="stylesheet" type="text/css" href="static/github.css">
    <link rel="shortcut icon" href="static/favicon.ico">
    <title><?php echo $title; ?> - <?php echo $hiei_title; ?></title>
    <script src="static/highlight.pack.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
    <header>
      <h1><?php echo $hiei_title; ?></h1>
      <span><?php echo $hiei_subtitle; ?></span>
    </header>
    <hr>
    <article>
      <h1><?php echo $title; ?></h1>
      <small>Uploaded on <time datetime="<?php echo $creation_date; ?>"><?php echo $creation_date; ?></time></small>
      <?php
        echo $parsedown->text($article); // Output markdown!
      ?>
    </article>
    <footer class="right">
      <small>powered by <a href="https://github.com/naomiEve/hiei">hiei</a></small>
    </footer>
  </body>
</html>
