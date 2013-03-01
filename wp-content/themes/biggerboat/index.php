<?php get_header(); ?>
<?php include_once("includes/crew-block-function.php"); ?>

<div id="container">
    <header>
    </header>

    <div id="main" role="main">
        <div id="animationcontainer">
            <div class="sky">
                <div id="blog">

                    <div class="container">
                        <img class="sign" src="<?php bloginfo('template_url'); ?>/img/blog.png">

                        <div class="top"></div>
                        <div class="tweet">

                            <div class="text"></div>

                        </div>
                        <?php query_posts('order=ASC'); ?>
                        <?php while (have_posts()) : the_post(); ?>

                        <div class="blogtop"></div>
                        <div class="blogcontent">
                            <div class="header">
                                <h2><?php the_title(); ?></h2>
                                <small>by <em><?php the_author() ?></em></small>
                            </div>
                            <?php the_content(); ?>
                        </div>
                        <div class="blogfooter"></div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
            <div id="logo"></div>
            <div id="lighthouse"></div>
            <div id="whatisbiggerboat">
                We are a group of independent web developers, software engineers, technical consultants, creative
                coders, enthousiasts, individuals, friends and we are good company. <br><br>
                <b>You have the need for a bigger boat?</b><br>
                We're just a call away.<br><br>
                <a class="bigbutton gotomail" id="mail_button"><img src="<?php bloginfo('template_url'); ?>/img/email-us.png"></a>
                <a href="#" class="bigbutton gotoblog"><img src="<?php bloginfo('template_url'); ?>/img/go-to-blog.png"></a>
            </div>
            <div id="boatContainer">
                <div id="boat"></div>
            </div>
            <div id="firstwave" class="wave"></div>
            <div id="secondwave" class="wave"></div>
        </div>
        <div id="crew">
            <div class="crewlogo"></div>
            <?php

            $members = array();
            query_posts('post_type=members&posts_per_page=99999&order=ASC&orderby=title');

            while (have_posts()) : the_post();
                $block = crewBlock(get_the_title(), get_field('description'), get_field('skills'), get_field('portfolio_url'), get_field('twitter_url'), get_field('linkedin_url'), get_field('contact'));
                array_push($members,$block);

            endwhile;
            wp_reset_postdata();

            $i = 0;
            $left = "";
            $right = "";

            shuffle($members);

            foreach ($members as &$member) {
                if ($i % 2 == 0) {
                    $left .= $member;
                } else {
                    $right .= $member;
                }
                $i++;
            }



            ?>

            <div class="right column">
                <ul>
                    <?php echo $right; ?>
                </ul>
            </div>
            <div class="left column">
                <ul>
                    <?php echo $left; ?>
                </ul>
            </div>


            <div class="clearfix"></div>
            <div class="anchor"></div>
        </div>

    </div>
    <footer>
    </footer>

	<?php
	/*
	 * All animations are placed in this layer..
	 * Make sure it's behind every element in DOM
	 */
	?>
	<div id="animationlayer"></div>
</div>
<!--! end of #container -->

<?php get_footer(); ?>