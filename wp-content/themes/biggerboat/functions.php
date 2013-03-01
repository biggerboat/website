<?php
/**
 * @author Jankees van Woezik <jankees@base42.nl>
 */
register_taxonomy('member_skills', 'members', array(
                                                   'hierarchical' => false,
                                                   'show_ui' => true,
                                                   'labels' => array(
                                                       'name' => __('Skills'),
                                                   ),
                                                   'rewrite' => array('slug' => 'member/skills'),
                                                   'has_archive' => false
                                              ));
register_post_type('members', array(
                                   'labels' => array(
                                       'name' => __('Member'),
                                   ),
                                   'public' => true,
                                   'supports' => array('title'),
                              ));


add_image_size('biggerboat_post', 459, 9999999, true);


/**
 * Add moving objects animation
 * @author Patrick Brouwer <patrick@inlet.nl>
 */
add_action('wp_enqueue_scripts', 'add_moving_objects_scripts');
function add_moving_objects_scripts()
{
	wp_enqueue_script('movingobjects', get_stylesheet_directory_uri() . '/js/mylibs/movingobjects.animation.js', null, null, true);
	wp_enqueue_script('script', get_stylesheet_directory_uri() . '/js/script.js', null, null, true);
	wp_localize_script('script', 'templatepaths', array(
														'root' => get_stylesheet_directory_uri(),
														'js' => get_stylesheet_directory_uri() . '/js',
														'img' => get_stylesheet_directory_uri() . '/img',
												   ));
}