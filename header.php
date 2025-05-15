<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100;0,300;0,400;0,600;1,400" rel="stylesheet">
    <script type="module">
        const hours = (new Date()).getHours();
        document.documentElement.classList.add(
            hours < 5 ? "night" :
            hours < 6 ? "twilight" :
            hours < 20 ? "day" :
            hours < 21 ? "twilight" :
            "night"
        );
    </script>
    <?php wp_head(); ?>
    <link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo(‘atom_url’); ?>">
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo(‘name’); ?> RSS Comments Feed" href="<?php bloginfo(‘comments_rss2_url’); ?>">
</head>

<body>

<?php wp_body_open() ?>

<div class="root">
    <header>
	<?php if (has_custom_logo()): ?>
	    <div class="logo">
		<h1>
		    <?= the_custom_logo() ?> 
		</h1>
	    </div>
	<?php else: ?>
	    <h1>
		<a href="<?= esc_url( home_url( '/' ) ); ?>" rel="home" <?php echo $is_front ? 'aria-current="page"' : ''; ?>><?php bloginfo( 'name' ); ?></a>
	    </h1>
	<?php endif ?>
    
        <div class="hamburger">
            <label for="show-nav">
                <svg viewBox="0 0 40 40" width="40" height="40">
                    <title>show navigation</title>
                    <rect y="0" width="40" height="8" fill="currentColor"></rect>
                    <rect y="15" width="40" height="8" fill="currentColor"></rect>
                    <rect y="30" width="40" height="8" fill="currentColor"></rect>
                </svg>
            </label>
        </div>
        <div class="divider">
            <svg width="10rem" height="10rem">
                <line x1="-10%" y1="-10%" x2="500%" y2="500%" stroke="currentColor" stroke-width="1.25rem" stroke-linecap="square"></line>
                <line x1="55%" y1="50%" x2="1000%" y2="50%" stroke="currentColor" stroke-width="1.25rem" stroke-linecap="square" class="divider__horz"></line>
            </svg>
        </div>
        <input type="checkbox" id="show-nav">
        <label for="show-nav" class="nav-close"></label>
        <div class="nav">
            <?php wp_nav_menu (['container' => 'nav', 'container_class' => 'navigation-container', 'menu_class' => 'menu', 'depth' => 0, 'theme_location' => 'primary-menu', 'fallback_cb' => '__return_false']); ?>
        </div>
    </header>
