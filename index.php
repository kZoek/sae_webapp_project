<?php
require_once("core/init.php");
// title of the page and meta desc
$pageTitle = 'home';
$metaDesc= 'landing page';
// load the html-head and header 
require_once("layouts/header.php");
// create new Instance from DBfunctions to use queries
// awaits PDO connection as parameter
// $content = new DBfunctions($pdo);

/**
 * fetchSingle and fetchAll awaits 2 parameters
 * @param $query -> query wich should be executed
 * @param $params -> array, with parameters for prepared statements
 */
$homeContent = $content->fetchSingle("SELECT * FROM contents WHERE site_category = :cat",['cat' => 'home']);
$newsFeed = $content->fetchAll(" SELECT * FROM `blog_entries` ORDER BY post_date desc");
// var_dump($homeContent);
?>
<!-- site main content -->
<!-- about section -->
<section class="about">
    <h2><?= escape($homeContent['title'])?></h2>
    <p><?= escape(nl2br($homeContent['content']))?></p>
</section>
<!-- newsfeed section -->
<section class="news">
  <h2>updates about the game and us</h2>
    <article class="newsEntry">
    <?php foreach($newsFeed as $feed) : ?>
      <h3><?= escape($feed['entry_title'])?></h3>
      <p><?= escape($feed['entry_content'])?></p>
      <span class="timestamp">posted:<?= escape($feed['post_date'])?></span>
      <?php endforeach; ?>
    </article>
</section>
<?php
// load the footer and html end
require_once("layouts/footer.php");
?>