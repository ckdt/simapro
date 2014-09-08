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
			add_action('init', array($this, 'register_taxonomies'));
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
		}

		function register_taxonomies(){
			//this is where you can register custom taxonomies
		}

		function add_to_context($context){
			$context['foo'] = 'bar';
			$context['stuff'] = 'I am a value set in your functions.php file';
			$context['notes'] = 'These values are available everytime you call Timber::get_context();';
			$context['menu'] = new TimberMenu();
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
