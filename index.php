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

	/*$context['lang_class'] = get_field('language', 'options');*/
	$context['lang_name'] = get_field('language_name', 'options');
	$context['ga'] = get_field('google_analytics_code', 'options');
	$context['canon'] = get_field('canonical_link', 'options');
	$context['usp_title'] = get_field('usp_title', 'options');
	$context['menu_item_1'] = get_field('main_menu_item_1', 'options');
	$context['menu_item_2'] = get_field('main_menu_item_2', 'options');
	$context['menu_item_3'] = get_field('main_menu_item_3', 'options');
	$context['footer_text'] = get_field('footer_text', 'options');

	$context['intro'] = new TimberPost(39); // Replace id with proper id for Intro Page.
	$context['local'] = new TimberPost(199);
	$context['about'] = new TimberPost(35);
	$context['trynow'] = new TimberPost(47);
	$context['newsletter'] = new TimberPost(104);

	$context['usps'] = Timber::get_posts('post_type=usps&post_status=publish&orderby=menu_order&order=ASC');
	$context['usps_categories'] = Timber::get_terms('post_tag',array('hide_empty'=>false));

	$context['testimonials'] = Timber::get_posts('post_type=testimonials&post_status=publish&orderby=menu_order&order=ASC');
	$context['support'] = Timber::get_posts('post_type=support&post_status=publish&orderby=menu_order&order=ASC');

	$context['menu_eu'] = new TimberMenu('eur_menu');
	$context['menu_usa'] = new TimberMenu('usa_menu');
	$context['menu_aus'] = new TimberMenu('aus_menu');
	$context['menu_afr'] = new TimberMenu('afr_menu');
	$context['menu_asi'] = new TimberMenu('asi_menu');
	$context['menu_mid'] = new TimberMenu('mid_menu');
	$context['menu_other'] = new TimberMenu('other_menu');

	$templates = array('index.twig');
	if (is_home()){
		array_unshift($templates, 'home.twig');
	}
	Timber::render($templates, $context);
