<script src="<?php bloginfo('template_directory'); ?>/js/libs/jquery-1.6.2.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/libs/jquery.easing.1.3.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/libs/jquery.scrollTo-1.4.2-min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/libs/jquery.animate-enhanced.js"></script>
<script defer src="<?php bloginfo('template_directory'); ?>/js/plugins.js"></script>

<?php
	/* Add the dynamic scripts
	 * @see functions.php
	 */
	wp_footer();
?>

<!-- Change UA-XXXXX-X to be your site's ID -->
<script>
    window._gaq = [
        ['_setAccount','UA-25907447-1'],
        ['_trackPageview'],
        ['_trackPageLoadTime']
    ];
    Modernizr.load({
        load: ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js'
    });
</script>

<!--[if lt IE 7 ]>
<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
<script>window.attachEvent('onload', function() {
    CFInstall.check({mode:'overlay'})
})</script>
<![endif]-->

</body>
</html>
<!-- 8 / 8 -->
