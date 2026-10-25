<?php
/**
 * Dependency Scanner Template
 *
 * Lists dependencies but no export - that's Pro.
 *
 * @package Unstoppable_CRA_Lite
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="wrap ucral-wrap">
    <h1><span class="dashicons dashicons-search"></span> <?php esc_html_e( 'Dependency Scanner', 'unstoppable-cra-lite' ); ?></h1>

    <div class="ucral-info-box">
        <p>
            <strong><?php esc_html_e( 'Why this matters:', 'unstoppable-cra-lite' ); ?></strong>
            <?php esc_html_e( 'The CRA requires a Software Bill of Materials (SBOM) documenting all components in your software. This scanner identifies dependencies across all your plugins.', 'unstoppable-cra-lite' ); ?>
        </p>
    </div>

    <div class="ucral-section">
        <h2><?php esc_html_e( 'Scan All Plugins', 'unstoppable-cra-lite' ); ?></h2>
        <p><?php esc_html_e( 'Scan your installed plugins to discover Composer packages, NPM dependencies, and embedded JavaScript libraries.', 'unstoppable-cra-lite' ); ?></p>
        
        <p>
            <button type="button" id="ucral-run-scan" class="button button-primary button-hero">
                <span class="dashicons dashicons-search"></span>
                <?php esc_html_e( 'Scan All Plugins', 'unstoppable-cra-lite' ); ?>
            </button>
        </p>

        <div id="ucral-scan-progress" style="display: none;">
            <span class="spinner is-active"></span>
            <?php esc_html_e( 'Scanning plugins for dependencies...', 'unstoppable-cra-lite' ); ?>
        </div>
    </div>

    <?php if ( $last_scan ) : ?>
    <!-- Scan Results -->
    <div class="ucral-section">
        <h2><?php esc_html_e( 'Scan Results', 'unstoppable-cra-lite' ); ?></h2>
        
        <div class="ucral-scan-summary">
            <div class="ucral-stat-card">
                <span class="ucral-stat-value"><?php echo esc_html( $last_scan['total_dependencies'] ); ?></span>
                <span class="ucral-stat-label"><?php esc_html_e( 'Total Dependencies', 'unstoppable-cra-lite' ); ?></span>
            </div>
            <div class="ucral-stat-card">
                <span class="ucral-stat-value"><?php echo esc_html( $last_scan['plugins_with_deps'] ); ?></span>
                <span class="ucral-stat-label"><?php esc_html_e( 'Plugins with Dependencies', 'unstoppable-cra-lite' ); ?></span>
            </div>
            <div class="ucral-stat-card">
                <span class="ucral-stat-value"><?php echo esc_html( count( $last_scan['plugins'] ) ); ?></span>
                <span class="ucral-stat-label"><?php esc_html_e( 'Plugins Scanned', 'unstoppable-cra-lite' ); ?></span>
            </div>
        </div>

        <p class="ucral-scan-date">
            <?php
            printf(
                /* translators: %s: scan date */
                esc_html__( 'Last scanned: %s', 'unstoppable-cra-lite' ),
                esc_html( $last_scan['scan_date'] )
            );
            ?>
        </p>

        <!-- Pro Upsell Banner -->
        <div class="ucral-pro-banner">
            <div class="ucral-pro-content">
                <span class="dashicons dashicons-download"></span>
                <div>
                    <strong>
                        <?php
                        printf(
                            /* translators: %d: number of dependencies */
                            esc_html__( 'Found %d dependencies. Generate compliant SBOM in CycloneDX/SPDX format.', 'unstoppable-cra-lite' ),
                            $last_scan['total_dependencies']
                        );
                        ?>
                    </strong>
                    <p><?php esc_html_e( 'Export machine-readable SBOMs required for CRA compliance.', 'unstoppable-cra-lite' ); ?></p>
                </div>
            </div>
            <a href="https://unstoppablesolutions.app/PluginDetail?slug=unstoppable-cra-compliance" class="button button-primary" target="_blank">
                <?php esc_html_e( 'Upgrade to Pro', 'unstoppable-cra-lite' ); ?>
            </a>
        </div>

        <!-- Dependencies Table -->
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th><?php esc_html_e( 'Plugin', 'unstoppable-cra-lite' ); ?></th>
                    <th><?php esc_html_e( 'Version', 'unstoppable-cra-lite' ); ?></th>
                    <th><?php esc_html_e( 'Composer', 'unstoppable-cra-lite' ); ?></th>
                    <th><?php esc_html_e( 'NPM', 'unstoppable-cra-lite' ); ?></th>
                    <th><?php esc_html_e( 'Embedded JS', 'unstoppable-cra-lite' ); ?></th>
                    <th><?php esc_html_e( 'Total', 'unstoppable-cra-lite' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $last_scan['plugins'] as $slug => $data ) : ?>
                <tr>
                    <td><strong><?php echo esc_html( $data['name'] ); ?></strong></td>
                    <td><?php echo esc_html( $data['version'] ); ?></td>
                    <td><?php echo esc_html( $data['composer'] ); ?></td>
                    <td><?php echo esc_html( $data['npm'] ); ?></td>
                    <td><?php echo esc_html( $data['embedded'] ); ?></td>
                    <td><strong><?php echo esc_html( $data['dependencies'] ); ?></strong></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Export Buttons (Pro) -->
        <div class="ucral-export-buttons">
            <button type="button" class="button ucral-pro-button" disabled>
                <span class="dashicons dashicons-download"></span>
                <?php esc_html_e( 'Export CycloneDX SBOM', 'unstoppable-cra-lite' ); ?>
                <span class="ucral-pro-badge"><?php esc_html_e( 'Pro', 'unstoppable-cra-lite' ); ?></span>
            </button>
            <button type="button" class="button ucral-pro-button" disabled>
                <span class="dashicons dashicons-download"></span>
                <?php esc_html_e( 'Export SPDX SBOM', 'unstoppable-cra-lite' ); ?>
                <span class="ucral-pro-badge"><?php esc_html_e( 'Pro', 'unstoppable-cra-lite' ); ?></span>
            </button>
        </div>
    </div>
    <?php else : ?>
    <div class="ucral-section">
        <div class="ucral-empty-state">
            <span class="dashicons dashicons-search"></span>
            <h3><?php esc_html_e( 'No scan data yet', 'unstoppable-cra-lite' ); ?></h3>
            <p><?php esc_html_e( 'Run a scan to discover dependencies across your plugins.', 'unstoppable-cra-lite' ); ?></p>
        </div>
    </div>
    <?php endif; ?>
</div>
