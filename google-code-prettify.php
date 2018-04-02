<?php
/**
 * Plugin Name: Google Code Prettify
 * Plugin URI: http://wordpress.org/plugins/carousel-slider
 * Description: An embeddable script that makes source-code snippets in HTML prettier.
 * Version: 1.0.0
 * Author: Sayful Islam
 * Author URI: https://sayfulislam.com
 * Requires at least: 4.4
 * Tested up to: 4.9
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Google_Code_Prettify' ) ) {

	class Google_Code_Prettify {

		/**
		 * @var object
		 */
		private static $instance;

		/**
		 * @return Google_Code_Prettify
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Google_Code_Prettify constructor.
		 */
		public function __construct() {
			$this->define_constants();

			add_action( 'wp_footer', array( __CLASS__, 'scripts' ) );
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'load_scripts' ) );

			include_once __DIR__ . '/class-google-code-prettify-widget.php';
		}

		private function define_constants() {
			define( 'GOOGLE_CODE_PRETTIFY_VERSION', '1.0.0' );
			define( 'GOOGLE_CODE_PRETTIFY_FILE', __FILE__ );
			define( 'GOOGLE_CODE_PRETTIFY_PATH', dirname( GOOGLE_CODE_PRETTIFY_FILE ) );
			define( 'GOOGLE_CODE_PRETTIFY_INCLUDES', GOOGLE_CODE_PRETTIFY_PATH . '/includes' );
			define( 'GOOGLE_CODE_PRETTIFY_TEMPLATES', GOOGLE_CODE_PRETTIFY_PATH . '/templates' );
			define( 'GOOGLE_CODE_PRETTIFY_WIDGETS', GOOGLE_CODE_PRETTIFY_PATH . '/widgets' );
			define( 'GOOGLE_CODE_PRETTIFY_URL', plugins_url( '', GOOGLE_CODE_PRETTIFY_FILE ) );
			define( 'GOOGLE_CODE_PRETTIFY_ASSETS', GOOGLE_CODE_PRETTIFY_URL . '/assets' );
		}

		public static function load_scripts() {
//			wp_enqueue_style( 'google-code-prettify', GOOGLE_CODE_PRETTIFY_ASSETS . '/css/prettify.css' );
//			wp_enqueue_script( 'google-code-prettify', GOOGLE_CODE_PRETTIFY_ASSETS . '/js/prettify.js' );
			wp_enqueue_style(
				'google-code-prettify',
				GOOGLE_CODE_PRETTIFY_ASSETS . '/libs/highlight/css/github.css'
			);
			wp_enqueue_script(
				'highlight',
				GOOGLE_CODE_PRETTIFY_ASSETS . '/libs/highlight/js/highlight.min.js',
				array(),
				'9.12.0',
				false
			);
		}

		/**
		 * Load script
		 */
		public static function scripts() {
			?>
            <script type="text/javascript">
                // window.addEventListener('load', function () {
                //     PR.prettyPrint();
                // });
                hljs.initHighlightingOnLoad();
            </script>
			<?php
		}
	}
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 */
Google_Code_Prettify::instance();
