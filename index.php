<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package 	WordPress
 * @subpackage 	Timber
 * @since 		Timber 0.1
 */

	if (!class_exists('Timber')){
		echo 'Timber not activated. Make sure you activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
		return;
	}
	$context = Timber::get_context();

	$context['intro'] = new TimberPost(39); // Replace id with proper id for Intro Page.
	$context['about'] = new TimberPost(35); // Replace id with proper id for Intro Page.
	$context['trynow'] = new TimberPost(47); // Replace id with proper id for Intro Page.

	$context['usps'] = Timber::get_posts('post_type=usps&post_status=publish');
	$context['testimonials'] = Timber::get_posts('post_type=testimonials&post_status=publish');
	$context['support'] = Timber::get_posts('post_type=support&post_status=publish');

	$templates = array('index.twig');
	if (is_home()){
		array_unshift($templates, 'home.twig');
	}
	Timber::render($templates, $context);
