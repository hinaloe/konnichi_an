<?php
/**
 * Konnichi An functions and definitions.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package Konnichi An
 */

if ( ! function_exists( 'konnichi_an_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function konnichi_an_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Konnichi An, use a find and replace
	 * to change 'konnichi_an' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'konnichi_an', get_template_directory() . '/languages' );

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
		'primary' => esc_html__( 'Primary Menu', 'konnichi_an' ),
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

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'konnichi_an_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	if ( ! isset( $content_width ) ) $content_width = 900;
}
endif; // konnichi_an_setup
add_action( 'after_setup_theme', 'konnichi_an_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function konnichi_an_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'konnichi_an_content_width', 640 );
}
add_action( 'after_setup_theme', 'konnichi_an_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function konnichi_an_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'konnichi_an' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'konnichi_an_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function konnichi_an_scripts() {
	wp_enqueue_style( 'konnichi_an-mdl-style', get_template_directory_uri().'/inc/mdl/material.min.css' );
	wp_enqueue_style( 'konnichi_an-mdl-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons');
	wp_enqueue_style( 'konnichi_an-style', get_stylesheet_uri() );

	wp_enqueue_script( 'konnichi_an-navigation', get_template_directory_uri() . '/inc/mdl/material.min.js', array(), '20120206', true );
	wp_enqueue_script( 'konnichi_an-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'konnichi_an-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'konnichi_an_scripts' );

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

function konnichi_an_empty_menu(){
	echo "<li class='mdl-navigation__link'>". esc_html(__('No Menu', 'konnichi_an')). "</li>";
}

function konnichi_an_comments_arg () {
	$req = get_option( 'require_name_email' );
	$aria_req = ($req ? " aria-required='true'" : '');
	$html_req = ( $req ? " required='required'" : '' );
	$commenter = wp_get_current_commenter();

	$comments_arg = array(

		'comment_field' => '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label comment-form-comment"> <textarea class="mdl-textfield__input" id="comment" name="comment" cols="45" rows="10" aria-describedby="form-allowed-tags" aria-required="true" required="required"></textarea><label for="comment" class="mdl-textfield__label">' . _x( 'Comment', 'noun' ) . '</label></div>',
		'class_submit' => 'submit mdl-button mdl-js-button mdl-button--raised',

		'fields' => apply_filters( 'comment_form_default_fields', array(

			'author' => '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label comment-form-author">'.
			            '<input id="author" name="author" type="text" class="mdl-textfield__input" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $html_req . ' />'.
		                '<label class="mdl-textfield__label" for="author">' . __('Name') . ($req ? '<span class="required">*</span>' : '') . '</label></div>',
			'email' => '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label comment-form-email">'.
			            '<input id="email" name="email" type="email" class="mdl-textfield__input" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . $html_req . ' />'.
			            '<label class="mdl-textfield__label" for="email">' . __('Email') . ($req ? '<span class="required">*</span>' : '' ) . '</label></div>',
			'url' => '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label comment-form-url">'.
		             '<input class="mdl-textfield__input" id="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30">'.
		             '<label class="mdl-textfield__label" for="url">' . __( 'Website' ) . '</label></div>',
			)
		),
	);
	return apply_filters('konnichi_an_custom_header_args',$comments_arg);
}

class MdlMenu extends Walker
{
    public function walk( $elements, $max_depth )
    {
        $list = null;

        foreach ( $elements as $item ){
						$url = esc_url($item->url);
						$class = null;
						array_walk_recursive($item->classes, function($classes) use (&$class){
							$class .= $classes. " ";
						});
						$class .= "mdl-navigation__link";
            $list .= "<a href='{$url}' class='{$class}'>". esc_html($item->title). "</a>";
				}
        return $list;
    }
}
