<?php
/**
 * Admin Class
 *
 * Handles admin menu, pages, scripts, and AJAX handlers.
 *
 * @package Unstoppable_CRA_Lite
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Admin Class.
 */
class UCRAL_Admin {

    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_menu_icon_style' ) );
        
        // AJAX handlers.
        add_action( 'wp_ajax_ucral_run_scan', array( $this, 'ajax_run_scan' ) );
        add_action( 'wp_ajax_ucral_save_assessment', array( $this, 'ajax_save_assessment' ) );
        add_action( 'wp_ajax_ucral_subscribe_updates', array( $this, 'ajax_subscribe_updates' ) );
    }

    /**
     * Enqueue gold menu icon style globally using wp_add_inline_style.
     */
    public function enqueue_menu_icon_style() {
        wp_register_style( 'ucral-menu-icon', false, array(), UCRAL_VERSION );
        wp_enqueue_style( 'ucral-menu-icon' );

        $ucral_menu_css = '
            #adminmenu .toplevel_page_ucral-dashboard .wp-menu-image::before {
                color: #f0b849 !important;
            }
            #adminmenu .toplevel_page_ucral-dashboard:hover .wp-menu-image::before,
            #adminmenu .toplevel_page_ucral-dashboard.current .wp-menu-image::before {
                color: #f5c96a !important;
            }
        ';

        wp_add_inline_style( 'ucral-menu-icon', $ucral_menu_css );
    }

    /**
     * Add admin menu.
     */
    public function add_admin_menu() {
        add_menu_page(
            __( 'CRA Compliance', 'unstoppable-cra-lite' ),
            __( 'CRA Compliance', 'unstoppable-cra-lite' ),
            'manage_options',
            'ucral-dashboard',
            array( $this, 'render_dashboard' ),
            'dashicons-shield',
            30
        );

        add_submenu_page(
            'ucral-dashboard',
            __( 'Dashboard', 'unstoppable-cra-lite' ),
            __( 'Dashboard', 'unstoppable-cra-lite' ),
            'manage_options',
            'ucral-dashboard',
            array( $this, 'render_dashboard' )
        );

        add_submenu_page(
            'ucral-dashboard',
            __( 'Dependency Scanner', 'unstoppable-cra-lite' ),
            __( 'Dependency Scanner', 'unstoppable-cra-lite' ),
            'manage_options',
            'ucral-scanner',
            array( $this, 'render_scanner' )
        );

        add_submenu_page(
            'ucral-dashboard',
            __( 'Self-Assessment', 'unstoppable-cra-lite' ),
            __( 'Self-Assessment', 'unstoppable-cra-lite' ),
            'manage_options',
            'ucral-assessment',
            array( $this, 'render_assessment' )
        );

        add_submenu_page(
            'ucral-dashboard',
            __( 'Security.txt', 'unstoppable-cra-lite' ),
            __( 'Security.txt', 'unstoppable-cra-lite' ),
            'manage_options',
            'ucral-security-txt',
            array( $this, 'render_security_txt' )
        );

        add_submenu_page(
            'ucral-dashboard',
            __( 'Learn', 'unstoppable-cra-lite' ),
            __( 'Learn', 'unstoppable-cra-lite' ),
            'manage_options',
            'ucral-learn',
            array( $this, 'render_learn' )
        );
    }

    /**
     * Enqueue scripts and styles.
     *
     * @param string $hook Current admin page.
     */
    public function enqueue_scripts( $hook ) {
        if ( strpos( $hook, 'ucral-' ) === false ) {
            return;
        }

        wp_enqueue_style(
            'ucral-admin',
            UCRAL_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            UCRAL_VERSION
        );

        wp_enqueue_script(
            'ucral-admin',
            UCRAL_PLUGIN_URL . 'assets/js/admin.js',
            array( 'jquery' ),
            UCRAL_VERSION,
            true
        );

        wp_localize_script( 'ucral-admin', 'ucral_admin', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonces'   => array(
                'run_scan'        => wp_create_nonce( 'ucral_run_scan' ),
                'save_assessment' => wp_create_nonce( 'ucral_save_assessment' ),
                'security_txt'    => wp_create_nonce( 'ucral_security_txt' ),
                'subscribe'       => wp_create_nonce( 'ucral_subscribe' ),
            ),
            'strings'  => array(
                'scanning'  => __( 'Scanning...', 'unstoppable-cra-lite' ),
                'saving'    => __( 'Saving...', 'unstoppable-cra-lite' ),
                'error'     => __( 'An error occurred.', 'unstoppable-cra-lite' ),
                'pro_title' => __( 'Pro Feature', 'unstoppable-cra-lite' ),
            ),
            'pro_url'  => 'https://unstoppablesolutions.app/PluginDetail?slug=unstoppable-cra-compliance',
        ) );
    }

    /**
     * Render dashboard page.
     */
    public function render_dashboard() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'Permission denied.', 'unstoppable-cra-lite' ) );
        }

        $score_data   = UCRAL_Readiness_Score::calculate();
        $days_left    = Unstoppable_CRA_Lite::get_days_until_deadline();
        $requirements = $score_data['requirements'];

        include UCRAL_PLUGIN_DIR . 'templates/dashboard.php';
    }

    /**
     * Render scanner page.
     */
    public function render_scanner() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'Permission denied.', 'unstoppable-cra-lite' ) );
        }

        $plugins   = UCRAL_Dependency_Scanner::get_installed_plugins();
        $last_scan = UCRAL_Dependency_Scanner::get_last_scan();

        include UCRAL_PLUGIN_DIR . 'templates/scanner.php';
    }

    /**
     * Render assessment page.
     */
    public function render_assessment() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'Permission denied.', 'unstoppable-cra-lite' ) );
        }

        $categories  = UCRAL_Self_Assessment::get_questions_by_category();
        $answers     = UCRAL_Self_Assessment::get_answers();
        $is_complete = UCRAL_Self_Assessment::is_complete();

        include UCRAL_PLUGIN_DIR . 'templates/assessment.php';
    }

    /**
     * Render security.txt page.
     */
    public function render_security_txt() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'Permission denied.', 'unstoppable-cra-lite' ) );
        }

        $settings = UCRAL_Security_Txt::get_settings();
        $preview  = UCRAL_Security_Txt::generate_content();

        include UCRAL_PLUGIN_DIR . 'templates/security-txt.php';
    }

    /**
     * Render learn page.
     */
    public function render_learn() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'Permission denied.', 'unstoppable-cra-lite' ) );
        }

        include UCRAL_PLUGIN_DIR . 'templates/learn.php';
    }

    /**
     * AJAX: Run dependency scan.
     */
    public function ajax_run_scan() {
        check_ajax_referer( 'ucral_run_scan', 'nonce' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => __( 'Permission denied.', 'unstoppable-cra-lite' ) ) );
        }

        $results = UCRAL_Dependency_Scanner::scan_all_plugins();

        wp_send_json_success( array(
            'message' => sprintf(
                /* translators: %d: number of dependencies found */
                __( 'Scan complete. Found %d dependencies across all plugins.', 'unstoppable-cra-lite' ),
                $results['total_dependencies']
            ),
            'results' => $results,
        ) );
    }

    /**
     * AJAX: Save assessment answers.
     */
    public function ajax_save_assessment() {
        check_ajax_referer( 'ucral_save_assessment', 'nonce' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => __( 'Permission denied.', 'unstoppable-cra-lite' ) ) );
        }

        $answers = isset( $_POST['answers'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['answers'] ) ) : array();

        UCRAL_Self_Assessment::save_answers( $answers );

        // Recalculate score.
        $score_data = UCRAL_Readiness_Score::calculate();

        wp_send_json_success( array(
            'message' => __( 'Assessment saved.', 'unstoppable-cra-lite' ),
            'score'   => $score_data['score'],
            'grade'   => $score_data['grade'],
        ) );
    }

    /**
     * AJAX: Subscribe to updates.
     */
    public function ajax_subscribe_updates() {
        check_ajax_referer( 'ucral_subscribe', 'nonce' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => __( 'Permission denied.', 'unstoppable-cra-lite' ) ) );
        }

        $email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';

        if ( ! is_email( $email ) ) {
            wp_send_json_error( array( 'message' => __( 'Please enter a valid email address.', 'unstoppable-cra-lite' ) ) );
        }

        // Store locally (you could integrate with a mailing service here).
        update_option( 'ucral_subscribed_email', $email );
        update_option( 'ucral_subscribed_at', current_time( 'mysql' ) );

        wp_send_json_success( array(
            'message' => __( 'Thank you! You\'ll receive CRA compliance updates at this email.', 'unstoppable-cra-lite' ),
        ) );
    }
}
