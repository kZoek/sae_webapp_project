<?php
require_once("core/init.php");
// title of the page and meta desc
$pageTitle = 'home';
$metaDesc = 'landing page';
$cssSep = 'about.css';
// load the html-head and header 
require_once("layouts/header.php");
/**
 * fetchSingle and fetchAll awaits 2 parameters
 * @param $query -> query wich should be executed
 * @param $params -> array, with parameters for prepared statements, if needed
 */
$aboutContent = $content->fetchAll("SELECT * FROM `contents` WHERE site_category = :cat",['cat' =>'about']);
?>
<!-- site main content -->

    <?php foreach($aboutContent as $about): ?>
    <section class="about">
        <h2><?=escape($about['title'])?></h2>
        <p><?=escape(nl2br($about['content']))?></p>
    </section>
    <?php endforeach; ?>
    <section class="about">
        <h2>about the team</h2>
        <!-- about the team members -->
        <div class="team">
            <div class="teamMember">
                <img class="memberImg" src="https://as2.ftcdn.net/jpg/01/04/01/37/500_F_104013719_0RBp6tC9Q0ryP0bzgTqHGZWPLbmz2Cdt.jpg" alt="team member">
                <h4>teamplayer</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore esse quod reprehenderit.</p>
            </div>
            <div class="teamMember">
                <img class="memberImg" src="https://as2.ftcdn.net/jpg/01/04/01/37/500_F_104013719_0RBp6tC9Q0ryP0bzgTqHGZWPLbmz2Cdt.jpg" alt="team member">
                <h4>teamplayer</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore esse quod reprehenderit.</p>
            </div>  
        </div>
    </section>
<?php
// load the footer and html end
require_once("layouts/footer.php");
?>