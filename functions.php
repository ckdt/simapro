<?php
	if (!class_exists('Timber')){
		add_action( 'admin_notices', function(){
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . admin_url('plugins.php#timber') . '">' . admin_url('plugins.php') . '</a></p></div>';
		});
		return;
	}

	class StarterSite extends TimberSite {

		function __construct(){
			add_theme_support('post-formats');
			add_theme_support('post-thumbnails');
			add_theme_support('menus');
			add_filter('timber_context', array($this, 'add_to_context'));
			add_filter('get_twig', array($this, 'add_to_twig'));
			add_action('init', array($this, 'register_post_types'));
			add_action('init', array($this, 'register_menu_locations'));
			add_action('init', array($this, 'register_taxonomies'));
			add_action('init', array($this, 'register_custom_options_panel'));
			parent::__construct();
		}

		function register_post_types(){
			register_post_type('usps',
				array(
				'labels' => array(
					'name' => _x('USPs', 'post type general name', 'simapro'),
					'singular_name' => _x('USP', 'post type singular name', 'simapro'),
					'add_new' => _x('Add New', 'USP', 'simapro'),
					'add_new_item' => __('Add New USP', 'simapro'),
					'edit_item' => __('Edit USP', 'simapro'),
					'new_item' => __('New USP', 'simapro'),
					'view_item' => __('View USP', 'simapro'),
					'search_items' => __('Search USPs', 'simapro'),
					'not_found' => __('No USPs found', 'simapro'),
					'not_found_in_trash' => __('No USPs found in Trash', 'simapro'),
					'parent' => __('Parent USP', 'simapro'),
				),
				'public' => true,
				'menu_icon' => 'dashicons-megaphone',
				'menu_position' => 5,
				'hierarchical' => true,
				'has_archive' => false,
				'supports' => array('title','editor','thumbnail','excerpt', 'page-attributes'),
				'taxonomies' => array('post_tag'),
				'rewrite' => array('slug' => _x('usps', 'URL slug', 'simapro'), 'with_front' => false)
				)
			);
			register_post_type('testimonials',
				array(
				'labels' => array(
					'name' => _x('Testimonial', 'post type general name', 'simapro'),
					'singular_name' => _x('Testimonial', 'post type singular name', 'simapro'),
					'add_new' => _x('Add New', 'Testimonial', 'simapro'),
					'add_new_item' => __('Add New Testimonial', 'simapro'),
					'edit_item' => __('Edit Testimonial', 'simapro'),
					'new_item' => __('New Testimonial', 'simapro'),
					'view_item' => __('View Testimonial', 'simapro'),
					'search_items' => __('Search Testimonials', 'simapro'),
					'not_found' => __('No Testimonials found', 'simapro'),
					'not_found_in_trash' => __('No Testimonials found in Trash', 'simapro'),
					'parent' => __('Parent Testimonial', 'simapro'),
				),
				'public' => true,
				'menu_icon' => 'dashicons-format-quote',
				'menu_position' => 5,
				'hierarchical' => true,
				'has_archive' => false,
				'supports' => array('title','thumbnail', 'page-attributes'),
				'rewrite' => array('slug' => _x('testimonials', 'URL slug', 'simapro'), 'with_front' => false)
				)
			);
			register_post_type('Support',
				array(
				'labels' => array(
					'name' => _x('Support', 'post type general name', 'simapro'),
					'singular_name' => _x('Support', 'post type singular name', 'simapro'),
					'add_new' => _x('Add New', 'Support', 'simapro'),
					'add_new_item' => __('Add New Support', 'simapro'),
					'edit_item' => __('Edit Support', 'simapro'),
					'new_item' => __('New Support', 'simapro'),
					'view_item' => __('View Support', 'simapro'),
					'search_items' => __('Search Support', 'simapro'),
					'not_found' => __('No Support found', 'simapro'),
					'not_found_in_trash' => __('No Support found in Trash', 'simapro'),
					'parent' => __('Parent Support', 'simapro'),
				),
				'public' => true,
				'menu_icon' => 'dashicons-hammer',
				'menu_position' => 5,
				'hierarchical' => true,
				'has_archive' => false,
				'supports' => array('title','thumbnail', 'page-attributes'),
				'rewrite' => array('slug' => _x('support', 'URL slug', 'simapro'), 'with_front' => false)
				)
			);
		}

		function register_menu_locations(){
			register_nav_menus(
				array(
				'eur_menu' => 'Europe Menu',
				'usa_menu' => 'America Menu',
				'aus_menu' => 'Australia Menu',
				'afr_menu' => 'Africa Menu',
				'asi_menu' => 'Asia Menu',
				'mid_menu' => 'Middle East Menu',
				'other_menu' => 'Others Menu'
				)
			);
		}

		function register_custom_options_panel(){
			if( function_exists('acf_add_options_page') ) {
				$page = acf_add_options_page(array(
					'page_title' 	=> 'Options',
					'menu_title' 	=> 'Options',
					'menu_slug' 	=> 'acf-options',
					'capability' 	=> 'create_users',
					'redirect' 	=> false
				));
			}
		}

		function register_taxonomies(){
			//this is where you can register custom taxonomies
		}

		function add_to_context($context){
			$context['foo'] = 'bar';
			$context['stuff'] = 'I am a value set in your functions.php file';
			$context['notes'] = 'These values are available everytime you call Timber::get_context();';
			//$context['menu'] = new TimberMenu(421);
			$context['site'] = $this;
			return $context;
		}

		function add_to_twig($twig){
			/* this is where you can add your own fuctions to twig */
			$twig->addExtension(new Twig_Extension_StringLoader());
			$twig->addFilter('myfoo', new Twig_Filter_Function('myfoo'));
			return $twig;
		}

	}

	new StarterSite();

	function myfoo($text){
    	$text .= ' bar!';
    	return $text;
	}

	function remove_menus () {
global $menu;
	$restricted = array(__('Posts'),__('Comments'));
	end ($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
	}
}
add_action('admin_menu', 'remove_menus');

function add_scripts_and_styles(){
	wp_deregister_script( 'jquery' );
	wp_deregister_script( 'bootstrap' );
	wp_deregister_script( 'flexslider' );
	wp_deregister_script( 'site' );

	wp_register_script( 'jquery', "http" . ( $_SERVER['SERVER_PORT'] == 443 ? "s" : "" ) . "://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js", array(), false, true );
	wp_register_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), false, true );
	wp_register_script( 'flexslider', get_template_directory_uri() . '/js/flexslider.min.js', array('jquery','bootstrap'), false, true );
	wp_register_script( 'site', get_template_directory_uri() . '/js/site.js', array('jquery','bootstrap','flexslider'), false, true );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'bootstrap' );
	wp_enqueue_script( 'flexslider' );
	wp_enqueue_script( 'site' );

	wp_localize_script( 'site', 'WPURLS', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}

add_action('wp_enqueue_scripts','add_scripts_and_styles');

add_filter( 'wpseo_canonical', '__return_false' );
