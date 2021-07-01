<?php
require_once("core/init.php");
// title of the page and meta desc
$pageTitle = 'tutorial';
$metaDesc= 'explanation about the gameplay and userinterface';
// load the html-head and header 
require_once("layouts/header.php");
/**
 * fetchSingle and fetchAll awaits 2 parameters
 * @param $query -> query wich should be executed
 * @param $params -> array, with parameters for prepared statements, if needed
 */
$tutorialContent = $content->fetchAll("SELECT * FROM `contents` WHERE site_category = :cat",['cat' =>'tutorial']);
?>
<!-- site main content -->
<!-- tutorial section -->
    <h2 class="smTitle">Tutorial how to play</h2>
    <?php foreach ($tutorialContent as $tutorial):?>
    <section class="tutorial">
    <h3><?=escape($tutorial['title'])?></h3>
    <p><?=escape(nl2br($tutorial['content']))?></p>
    </section>
    <?php endforeach; ?>
<?php
// load the footer and html end
require_once("layouts/footer.php");
?>