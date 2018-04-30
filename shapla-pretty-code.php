<?php
/**
 * Plugin Name: Shapla Pretty Code
 * Plugin URI: https://github.com/sayful1/shapla-pretty-code
 * Description: Syntax highlighting WordPress plugin for WordPress sites.
 * Version: 1.2.0
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

if ( ! class_exists( 'Shapla_Pretty_Code' ) ) {

	class Shapla_Pretty_Code {

		/**
		 * @var object
		 */
		private static $instance;

		/**
		 * @return Shapla_Pretty_Code
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
			$this->includes();
			$this->update_plugin();

			add_action( 'wp_footer', array( __CLASS__, 'scripts' ), 90 );
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'load_scripts' ) );
		}

		/**
		 * Plugin constants
		 */
		private function define_constants() {
			define( 'SHAPLA_PRETTY_CODE_VERSION', '1.2.0' );
			define( 'SHAPLA_PRETTY_CODE_FILE', __FILE__ );
			define( 'SHAPLA_PRETTY_CODE_PATH', dirname( SHAPLA_PRETTY_CODE_FILE ) );
			define( 'SHAPLA_PRETTY_CODE_INCLUDES', SHAPLA_PRETTY_CODE_PATH . '/includes' );
			define( 'SHAPLA_PRETTY_CODE_URL', plugins_url( '', SHAPLA_PRETTY_CODE_FILE ) );
			define( 'SHAPLA_PRETTY_CODE_ASSETS', SHAPLA_PRETTY_CODE_URL . '/assets' );
		}

		/**
		 * Includes plugin files
		 */
		private function includes() {
			include_once SHAPLA_PRETTY_CODE_INCLUDES . '/class-shapla-pretty-code-widget.php';
		}

		/**
		 * Update plugin from github
		 */
		public function update_plugin() {
			require_once SHAPLA_PRETTY_CODE_INCLUDES . '/libraries/class-shapla-github-plugin-updater.php';
			new Shapla_GitHub_Plugin_Updater(
				__FILE__,
				'sayful1',
				"shapla-pretty-code"
			);
		}

		/**
		 * Load plugin public scripts
		 */
		public static function load_scripts() {
			wp_enqueue_style( 'shapla-highlight-code',
				SHAPLA_PRETTY_CODE_ASSETS . '/libs/highlight/css/github.css' );
			wp_enqueue_script( 'shapla-highlight-code',
				SHAPLA_PRETTY_CODE_ASSETS . '/libs/highlight/js/highlight.min.js',
				array(), '9.12.0', true );
		}

		/**
		 * Load script
		 */
		public static function scripts() {
			?>
            <script type="text/javascript">
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
Shapla_Pretty_Code::instance();
