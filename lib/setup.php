<?php

namespace Roots\Sage\Setup;

use Roots\Sage\Assets;

/**
 * Theme setup
 */
function setup() {
  // Enable features from Soil when plugin is activated
  // https://roots.io/plugins/soil/
  add_theme_support('soil-clean-up');
  add_theme_support('soil-nav-walker');
  add_theme_support('soil-nice-search');
  add_theme_support('soil-jquery-cdn');
  add_theme_support('soil-relative-urls');

  // Make theme available for translation
  // Community translations can be found at https://github.com/roots/sage-translations
  load_theme_textdomain('sage', get_template_directory() . '/lang');

  // Enable plugins to manage the document title
  // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
  add_theme_support('title-tag');

  // Register wp_nav_menu() menus
  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  register_nav_menus([
    'primary_navigation' => __('Primary Navigation', 'sage')
  ]);

  // Enable post thumbnails
  // http://codex.wordpress.org/Post_Thumbnails
  // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
  // http://codex.wordpress.org/Function_Reference/add_image_size
  add_theme_support('post-thumbnails');

  // Enable post formats
  // http://codex.wordpress.org/Post_Formats
  add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);

  // Enable HTML5 markup support
  // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
  add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

  // Use main stylesheet for visual editor
  // To add custom styles edit /assets/styles/layouts/_tinymce.scss
  add_editor_style(Assets\asset_path('styles/main.css'));
}
add_action('after_setup_theme', __NAMESPACE__ . '\\setup');

/**
 * Register sidebars
 */
function widgets_init() {
  register_sidebar([
    'name'          => __('Primary', 'sage'),
    'id'            => 'sidebar-primary',
    'before_widget' => '<section class="card widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h5 class="card-header">',
    'after_title'   => '</h5>'
  ]);
  // register_sidebar([
  //   'name'          => __('Footer', 'sage'),
  //   'id'            => 'sidebar-footer',
  //   'before_widget' => '<section class="widget %1$s %2$s">',
  //   'after_widget'  => '</section>',
  //   'before_title'  => '<h3>',
  //   'after_title'   => '</h3>'
  // ]);
}
add_action('widgets_init', __NAMESPACE__ . '\\widgets_init');

/**
 * Determine which pages should NOT display the sidebar
 */
function display_sidebar() {
  static $display;

  isset($display) || $display = !in_array(true, [
    // The sidebar will NOT be displayed if ANY of the following return true.
    // @link https://codex.wordpress.org/Conditional_Tags
    is_404(),
    is_front_page(),
    is_page_template('template-custom.php'),
  ]);

  return apply_filters('sage/display_sidebar', $display);
}

/**
 * Theme assets
 */
function assets() {
  // Get the theme data.

  wp_enqueue_style( "fontawesome", "https://use.fontawesome.com/releases/v5.6.3/css/all.css" );

		$the_theme     = wp_get_theme();
		$theme_version = $the_theme->get( 'Version' );

		$css_version = $theme_version . '.' . filemtime( get_template_directory() . '/dist/styles/styles.min.css' );
    wp_enqueue_style( 'zak-styles', get_stylesheet_directory_uri() . '/dist/styles/styles.css', array(), $css_version );
    
    $js_version = $theme_version . '.' . filemtime( get_template_directory() . '/dist/scripts/main.min.js' );
    wp_enqueue_script( 'zak-scripts', get_stylesheet_directory_uri() . '/dist/scripts/main.min.js', array(), $js_version, true );

		/**wp_deregister_script('jquery');
		wp_register_script('jquery', 'https://code.jquery.com/jquery-3.3.1.min.js', false, '3.3.1');
		wp_enqueue_script('jquery');


    */
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);


function my_search_form( $form ) {
  $langUrl = pll_current_language() == pll_default_language() ? "":pll_current_language();
  $form = '
  <div class="">
            <h5 class="card-header">Search</h5>
            <div class="card-body">
            <form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . $langUrl . '/" >
              <div class="input-group">
              <label class="sr-only" for="s">' . __( 'Search for:' ) . '</label>
                <input type="text" class="form-control" placeholder="' . __( 'Search for:' ) . '" value="' . get_search_query() . '" name="s" id="s">
                <span class="input-group-append">
                  <button id="searchsubmit" class="btn btn-secondary" type="submit">'. esc_attr__( 'Search' ) .'</button>
                </span>
              </div>
              </form>
            </div>
          </div>

  
  <div>
  ';

  return $form;
}

add_filter( 'get_search_form', __NAMESPACE__ . '\\my_search_form', 100 );
