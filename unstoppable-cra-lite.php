<?php
/**
 * Plugin Name: Unstoppable CRA Compliance Checker
 * Plugin URI: https://unstoppablesolutions.app/plugins/cra-compliance-checker
 * Description: Check your WordPress plugins for EU Cyber Resilience Act (CRA) compliance. Scan dependencies, assess readiness, and prepare for December 2027.
 * Version: 1.0.3
 * Author: Unstoppable Solutions
 * Author URI: https://unstoppablesolutions.app
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: unstoppable-cra-lite
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 *
 * @package Unstoppable_CRA_Lite
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Plugin constants.
define( 'UCRAL_VERSION', '1.0.3' );
define( 'UCRAL_PLUGIN_FILE', __FILE__ );
define( 'UCRAL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'UCRAL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'UCRAL_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

// CRA Deadline.
define( 'UCRAL_CRA_DEADLINE', '2027-12-11' );
define( 'UCRAL_CRA_VULN_DEADLINE', '2026-06-11' );

/**
 * Main Plugin Class.
 */
final class Unstoppable_CRA_Lite {

    /**
     * Single instance.
     *
     * @var Unstoppable_CRA_Lite
     */
    private static $instance = null;

    /**
     * Get single instance.
     *
     * @return Unstoppable_CRA_Lite
     */
    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor.
     */
    private function __construct() {
        $this->includes();
        $this->init_hooks();
    }

    /**
     * Include required files.
     */
    private function includes() {
        require_once UCRAL_PLUGIN_DIR . 'includes/class-dependency-scanner.php';
        require_once UCRAL_PLUGIN_DIR . 'includes/class-self-assessment.php';
        require_once UCRAL_PLUGIN_DIR . 'includes/class-security-txt.php';
        require_once UCRAL_PLUGIN_DIR . 'includes/class-readiness-score.php';
        require_once UCRAL_PLUGIN_DIR . 'includes/class-admin.php';
    }

    /**
     * Initialize hooks.
     */
    private function init_hooks() {
        register_activation_hook( UCRAL_PLUGIN_FILE, array( $this, 'activate' ) );
        register_deactivation_hook( UCRAL_PLUGIN_FILE, array( $this, 'deactivate' ) );

        add_action( 'plugins_loaded', array( $this, 'init' ) );
    }

    /**
     * Initialize plugin components.
     */
    public function init() {
        if ( is_admin() ) {
            new UCRAL_Admin();
        }
    }

    /**
     * Activation.
     */
    public function activate() {
        $this->set_default_options();
        flush_rewrite_rules();
    }

    /**
     * Deactivation.
     */
    public function deactivate() {
        flush_rewrite_rules();
    }

    /**
     * Set default options.
     */
    private function set_default_options() {
        if ( false === get_option( 'ucral_assessment_answers' ) ) {
            update_option( 'ucral_assessment_answers', array() );
        }
        if ( false === get_option( 'ucral_last_scan' ) ) {
            update_option( 'ucral_last_scan', array() );
        }
        if ( false === get_option( 'ucral_security_txt_enabled' ) ) {
            update_option( 'ucral_security_txt_enabled', false );
        }
    }

    /**
     * Get days until CRA deadline.
     *
     * @return int
     */
    public static function get_days_until_deadline() {
        return max( 0, (int) ceil( ( strtotime( UCRAL_CRA_DEADLINE ) - time() ) / DAY_IN_SECONDS ) );
    }

    /**
     * Get days until vulnerability handling deadline.
     *
     * @return int
     */
    public static function get_days_until_vuln_deadline() {
        return max( 0, (int) ceil( ( strtotime( UCRAL_CRA_VULN_DEADLINE ) - time() ) / DAY_IN_SECONDS ) );
    }
}

/**
 * Main instance.
 *
 * @return Unstoppable_CRA_Lite
 */
function UCRAL() {
    return Unstoppable_CRA_Lite::instance();
}

// Initialize.
UCRAL();
