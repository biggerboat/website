<!doctype html>
<!--[if lt IE 7]>
<html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>
<html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>
<html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title><?php
    	/*
    	 * Print the <title> tag based on what is being viewed.
    	 */
    	global $page, $paged;

    	wp_title( '|', true, 'right' );

    	// Add the blog name.
    	bloginfo( 'name' );

    	// Add the blog description for the home/front page.
    	$site_description = get_bloginfo( 'description', 'display' );
    	if ( $site_description && ( is_home() || is_front_page() ) )
    		echo " | $site_description";

    	// Add a page number if necessary:
    	if ( $paged >= 2 || $page >= 2 )
    		echo ' | ' . sprintf( __( 'Page %s', 'biggerboat' ), max( $paged, $page ) );

    	?></title>
    <meta name="description" content="We are a group of independent web developers, software engineers, technical consultants, creative coders, enthousiasts, individuals, friends and we are good company.">
    <meta name="author" content="Bigger Boat">

    <meta name="viewport" content="width=1000">

    <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/favicon.ico">

    <link rel="apple-touch-icon-precomposed" href="<?php bloginfo('template_url'); ?>/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php bloginfo('template_url'); ?>/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php bloginfo('template_url'); ?>/apple-touch-icon-114x114-precomposed.png">

    <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/style.css">

    <script src="<?php bloginfo('template_directory'); ?>/js/libs/modernizr-2.0.6.min.js"></script>
    <?php wp_head(); ?>

    <script>
        // make the theme path accessible for javascript.
        var THEME_URL = '<?php echo get_template_directory_uri(); ?>/';
    </script>


</head>

<body id="biggerboat" <?php body_class();?>>

<?php include_once('mail_modal.php'); ?>