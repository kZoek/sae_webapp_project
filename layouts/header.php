<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?=$metaDesc?>">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Do+Hyeon&family=Fanwood+Text:ital@0;1&family=Holtwood+One+SC&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/font_and_color.css">
    <link rel="stylesheet" href="css/main.css">
    <?php if(isset($cssSep)) :?>
    <link rel="stylesheet" href="css/<?=$cssSep?>">
    <?php endif;?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title><?=$pageTitle?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="js/code.js" defer></script>
</head>
<body>
    <!-- navigation -->
    <!-- navigation array found in core/init.php -->
    <nav>
        <ul>
        <?php foreach ($mainnav as $navitem) : ?>
            <?php echo'<li><a href="'.$navitem['link'].'">'.$navitem['text'].'</a></li>'; ?>
        <?php endforeach; ?>
        </ul>
    </nav>
    <!-- title of the page -->
    <header class="title">
        <h1 class="sitetitle">lost in the woods</h1>
    </header>