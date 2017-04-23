<?php
/**
 * wpstarter functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wpstarter
 */

if ( ! function_exists( 'wpstarter_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wpstarter_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on wpstarter, use a find and replace
	 * to change 'wpstarter' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'wpstarter', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'wpstarter' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'wpstarter_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'wpstarter_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wpstarter_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wpstarter_content_width', 640 );
}
add_action( 'after_setup_theme', 'wpstarter_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wpstarter_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wpstarter' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'wpstarter' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'wpstarter_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function wpstarter_scripts() {
	wp_enqueue_style( 'wpstarter-style', get_stylesheet_uri() );
	wp_enqueue_style( 'wpstarter-main', get_template_directory_uri() . '/dist/styles/main.css' );
	wp_enqueue_script( 'wpstarter-navigation', get_template_directory_uri() . '/dist/scripts/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'wpstarter-skip-link-focus-fix', get_template_directory_uri() . '/dist/scripts/skip-link-focus-fix.js', array(), '20151215', true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wpstarter_scripts' );

/**
 * Enqueue scripts and styles. on admin
 */
function load_custom_wp_admin_style() {
    wp_enqueue_style( 'cristy-admin-style', get_template_directory_uri() . '/admin/css/admin.css', false, '1.0.0' );
	wp_enqueue_script( 'cristy-admin-script', get_template_directory_uri() . '/admin/js/admin.js', array('jquery'), '20151215', true );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
/**
 * wp_bootstrap_navwalker additions.
 */
require get_template_directory() . '/inc/wp_bootstrap_navwalker.php';

/**
 * Load aq_resizer file.
 */
require get_template_directory() . '/inc/aq_resizer.php';

/**
 * Load TGM-Plugin-Activation files.
 */
require get_template_directory() . '/inc/TGM-Plugin-Activation-2.6.1/required-plugins.php';

/**
 * Custom wp_bootstrap_comment_walker for this theme.
 */
require get_template_directory() . '/inc/wp_bootstrap_comment_walker.php';

/**
 * Custom wp_recent_posts_widget for this theme.
 */
require get_template_directory() . '/inc/wp_recent_posts_widget.php';

/**
 * Custom template metabox for this theme.
 */
require get_template_directory() . '/inc/template-metabox.php';

/**
 * Custom template options for this theme.
 */
require get_template_directory() . '/inc/template-options.php';