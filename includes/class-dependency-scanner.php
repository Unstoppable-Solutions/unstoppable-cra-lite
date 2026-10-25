<?php
/**
 * Dependency Scanner Class
 *
 * Scans plugins for Composer and NPM dependencies.
 * Note: Export functionality is Pro only.
 *
 * @package Unstoppable_CRA_Lite
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Dependency Scanner Class.
 */
class UCRAL_Dependency_Scanner {

    /**
     * Get list of installed plugins.
     *
     * @return array List of plugins.
     */
    public static function get_installed_plugins() {
        if ( ! function_exists( 'get_plugins' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        $all_plugins = get_plugins();
        $plugins     = array();

        foreach ( $all_plugins as $plugin_file => $plugin_data ) {
            $slug = dirname( $plugin_file );
            if ( '.' === $slug ) {
                $slug = basename( $plugin_file, '.php' );
            }

            $plugins[ $slug ] = array(
                'name'    => $plugin_data['Name'],
                'version' => $plugin_data['Version'],
                'author'  => $plugin_data['Author'],
                'license' => isset( $plugin_data['License'] ) ? $plugin_data['License'] : '',
                'file'    => $plugin_file,
                'path'    => WP_PLUGIN_DIR . '/' . dirname( $plugin_file ),
            );
        }

        return $plugins;
    }

    /**
     * Scan a plugin for dependencies.
     *
     * @param string $plugin_slug Plugin slug.
     * @return array Scan results.
     */
    public static function scan_plugin( $plugin_slug ) {
        $plugins = self::get_installed_plugins();

        if ( ! isset( $plugins[ $plugin_slug ] ) ) {
            return array(
                'success' => false,
                'message' => __( 'Plugin not found.', 'unstoppable-cra-lite' ),
            );
        }

        $plugin_path = $plugins[ $plugin_slug ]['path'];
        $results     = array(
            'plugin'      => $plugins[ $plugin_slug ],
            'composer'    => array(),
            'npm'         => array(),
            'js_embedded' => array(),
            'total_count' => 0,
        );

        // Scan composer.json.
        $results['composer'] = self::scan_composer( $plugin_path );

        // Scan package.json.
        $results['npm'] = self::scan_npm( $plugin_path );

        // Scan for embedded JS libraries.
        $results['js_embedded'] = self::scan_embedded_js( $plugin_path );

        // Total count.
        $results['total_count'] = count( $results['composer'] ) +
                                   count( $results['npm'] ) +
                                   count( $results['js_embedded'] );

        return $results;
    }

    /**
     * Scan all plugins.
     *
     * @return array Scan results for all plugins.
     */
    public static function scan_all_plugins() {
        $plugins = self::get_installed_plugins();
        $results = array(
            'plugins'           => array(),
            'total_dependencies' => 0,
            'plugins_with_deps' => 0,
            'scan_date'         => current_time( 'mysql' ),
        );

        foreach ( $plugins as $slug => $plugin ) {
            $scan = self::scan_plugin( $slug );
            
            $results['plugins'][ $slug ] = array(
                'name'         => $plugin['name'],
                'version'      => $plugin['version'],
                'dependencies' => $scan['total_count'],
                'composer'     => count( $scan['composer'] ),
                'npm'          => count( $scan['npm'] ),
                'embedded'     => count( $scan['js_embedded'] ),
            );

            $results['total_dependencies'] += $scan['total_count'];
            
            if ( $scan['total_count'] > 0 ) {
                $results['plugins_with_deps']++;
            }
        }

        // Save scan results.
        update_option( 'ucral_last_scan', $results );

        return $results;
    }

    /**
     * Scan composer.json for dependencies.
     *
     * @param string $plugin_path Plugin path.
     * @return array Dependencies.
     */
    private static function scan_composer( $plugin_path ) {
        $dependencies  = array();
        $composer_file = $plugin_path . '/composer.json';
        $composer_lock = $plugin_path . '/composer.lock';

        if ( ! file_exists( $composer_file ) ) {
            return $dependencies;
        }

        $composer_data = json_decode( file_get_contents( $composer_file ), true );

        if ( ! is_array( $composer_data ) ) {
            return $dependencies;
        }

        // Get require dependencies.
        if ( isset( $composer_data['require'] ) && is_array( $composer_data['require'] ) ) {
            foreach ( $composer_data['require'] as $package => $version ) {
                // Skip PHP and extensions.
                if ( 'php' === $package || strpos( $package, 'ext-' ) === 0 ) {
                    continue;
                }

                $dependencies[] = array(
                    'name'    => $package,
                    'version' => $version,
                    'license' => '',
                    'type'    => 'runtime',
                );
            }
        }

        // Try to get more info from composer.lock.
        if ( file_exists( $composer_lock ) ) {
            $lock_data = json_decode( file_get_contents( $composer_lock ), true );
            
            if ( isset( $lock_data['packages'] ) && is_array( $lock_data['packages'] ) ) {
                foreach ( $lock_data['packages'] as $package ) {
                    foreach ( $dependencies as &$dep ) {
                        if ( $dep['name'] === $package['name'] ) {
                            $dep['version'] = $package['version'];
                            $dep['license'] = isset( $package['license'] ) ? implode( ', ', (array) $package['license'] ) : '';
                        }
                    }
                }
            }
        }

        return $dependencies;
    }

    /**
     * Scan package.json for NPM dependencies.
     *
     * @param string $plugin_path Plugin path.
     * @return array Dependencies.
     */
    private static function scan_npm( $plugin_path ) {
        $dependencies = array();
        $package_file = $plugin_path . '/package.json';

        if ( ! file_exists( $package_file ) ) {
            return $dependencies;
        }

        $package_data = json_decode( file_get_contents( $package_file ), true );

        if ( ! is_array( $package_data ) ) {
            return $dependencies;
        }

        // Get production dependencies.
        if ( isset( $package_data['dependencies'] ) && is_array( $package_data['dependencies'] ) ) {
            foreach ( $package_data['dependencies'] as $package => $version ) {
                $dependencies[] = array(
                    'name'    => $package,
                    'version' => $version,
                    'license' => '',
                    'type'    => 'runtime',
                );
            }
        }

        return $dependencies;
    }

    /**
     * Scan for embedded JavaScript libraries.
     *
     * @param string $plugin_path Plugin path.
     * @return array Found libraries.
     */
    private static function scan_embedded_js( $plugin_path ) {
        $libraries   = array();
        $known_libs  = array(
            'jquery'      => '/jquery[.-]?(\d+\.\d+\.\d+)?\.(?:min\.)?js$/i',
            'lodash'      => '/lodash[.-]?(\d+\.\d+\.\d+)?\.(?:min\.)?js$/i',
            'moment'      => '/moment[.-]?(\d+\.\d+\.\d+)?\.(?:min\.)?js$/i',
            'axios'       => '/axios[.-]?(\d+\.\d+\.\d+)?\.(?:min\.)?js$/i',
            'vue'         => '/vue[.-]?(\d+\.\d+\.\d+)?\.(?:min\.)?js$/i',
            'react'       => '/react[.-]?(\d+\.\d+\.\d+)?\.(?:min\.)?js$/i',
            'bootstrap'   => '/bootstrap[.-]?(\d+\.\d+\.\d+)?\.(?:min\.)?js$/i',
            'popper'      => '/popper[.-]?(\d+\.\d+\.\d+)?\.(?:min\.)?js$/i',
            'chart'       => '/chart[.-]?(\d+\.\d+\.\d+)?\.(?:min\.)?js$/i',
            'select2'     => '/select2[.-]?(\d+\.\d+\.\d+)?\.(?:min\.)?js$/i',
            'datatables'  => '/datatables[.-]?(\d+\.\d+\.\d+)?\.(?:min\.)?js$/i',
            'sweetalert'  => '/sweetalert[.-]?(\d+\.\d+\.\d+)?\.(?:min\.)?js$/i',
            'd3'          => '/d3[.-]?(\d+\.\d+\.\d+)?\.(?:min\.)?js$/i',
            'underscore'  => '/underscore[.-]?(\d+\.\d+\.\d+)?\.(?:min\.)?js$/i',
            'backbone'    => '/backbone[.-]?(\d+\.\d+\.\d+)?\.(?:min\.)?js$/i',
        );

        if ( ! is_dir( $plugin_path ) ) {
            return $libraries;
        }

        $found = array();

        try {
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator( $plugin_path, RecursiveDirectoryIterator::SKIP_DOTS ),
                RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ( $iterator as $file ) {
                if ( 'js' !== $file->getExtension() ) {
                    continue;
                }

                $filename = $file->getFilename();
                
                foreach ( $known_libs as $lib_name => $pattern ) {
                    if ( preg_match( $pattern, $filename, $matches ) ) {
                        $version = isset( $matches[1] ) ? $matches[1] : 'unknown';
                        $key     = $lib_name . '-' . $version;
                        
                        if ( ! isset( $found[ $key ] ) ) {
                            $found[ $key ] = true;
                            $libraries[]   = array(
                                'name'    => $lib_name,
                                'version' => $version,
                                'file'    => str_replace( $plugin_path . '/', '', $file->getPathname() ),
                                'type'    => 'embedded',
                            );
                        }
                    }
                }
            }
        } catch ( Exception $e ) {
            // Silent fail on directory iteration errors.
        }

        return $libraries;
    }

    /**
     * Get last scan results.
     *
     * @return array|false
     */
    public static function get_last_scan() {
        return get_option( 'ucral_last_scan', false );
    }
}
