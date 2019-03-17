<?php
use Roots\Sage\Setup;
use Roots\Sage\Titles;

// Check if Timber is not activated
if ( ! class_exists( 'Timber' ) ) {

    add_action( 'admin_notices', function() {
        echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
    } );
    return;

}

// Add the directory of templates in include path
Timber::$dirname = array('templates');

/**
 * Extend TimberSite with site wide properties
 */
class SageTimberTheme extends TimberSite {

    function __construct() {
        add_filter( 'timber_context', array( $this, 'add_to_context' ) );
        parent::__construct();
    }

    function add_to_context( $context ) {

        /* Menu */
        $context['menu'] = new TimberMenu();

        /* Site info */
        $context['site'] = $this;

        /* Site info */
        $context['display_sidebar'] = Setup\display_sidebar();
        $context['sidebar_primary'] = Timber::get_widgets('sidebar-primary');
        $context['sidebar_header'] = Timber::get_widgets('sidebar-header');
        $context['imagesDir'] = get_template_directory_uri() . '/dist/img';

        $context['the_title'] = Titles\title();
        $context['brand'] = Setup\brand();



//         $context['pll_e'] = TimberHelper::ob_function('pll_e');

// $context['pll_'] = TimberHelper::function_wrapper('pll_');

        return $context;
    }
}
new SageTimberTheme();
