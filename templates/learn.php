<?php
/**
 * Learn Template
 *
 * Educational content hub - this is the conversion content.
 *
 * @package Unstoppable_CRA_Lite
 */

defined( 'ABSPATH' ) || exit;

$days_left = Unstoppable_CRA_Lite::get_days_until_deadline();
?>
<div class="wrap ucral-wrap">
    <h1><span class="dashicons dashicons-welcome-learn-more"></span> <?php esc_html_e( 'Understanding the EU Cyber Resilience Act', 'unstoppable-cra-lite' ); ?></h1>

    <div class="ucral-learn-grid">
        <!-- What is the CRA? -->
        <div class="ucral-learn-card">
            <div class="ucral-learn-header">
                <span class="dashicons dashicons-info-outline"></span>
                <h2><?php esc_html_e( 'What is the CRA?', 'unstoppable-cra-lite' ); ?></h2>
            </div>
            <div class="ucral-learn-content">
                <p><?php esc_html_e( 'The Cyber Resilience Act (CRA) is EU legislation that establishes cybersecurity requirements for products with digital elements. It applies to hardware and software products placed on the EU market.', 'unstoppable-cra-lite' ); ?></p>
                <p><strong><?php esc_html_e( 'Key points:', 'unstoppable-cra-lite' ); ?></strong></p>
                <ul>
                    <li><?php esc_html_e( 'Covers all products with digital elements sold in the EU', 'unstoppable-cra-lite' ); ?></li>
                    <li><?php esc_html_e( 'Requires manufacturers to ensure cybersecurity throughout the product lifecycle', 'unstoppable-cra-lite' ); ?></li>
                    <li><?php esc_html_e( 'Mandates vulnerability handling and incident reporting', 'unstoppable-cra-lite' ); ?></li>
                    <li><?php esc_html_e( 'Requires CE marking for compliant products', 'unstoppable-cra-lite' ); ?></li>
                </ul>
            </div>
        </div>

        <!-- Who does it apply to? -->
        <div class="ucral-learn-card">
            <div class="ucral-learn-header">
                <span class="dashicons dashicons-groups"></span>
                <h2><?php esc_html_e( 'Who Does It Apply To?', 'unstoppable-cra-lite' ); ?></h2>
            </div>
            <div class="ucral-learn-content">
                <p><?php esc_html_e( 'The CRA applies to manufacturers of products with digital elements that are placed on the EU market. For WordPress developers, this means:', 'unstoppable-cra-lite' ); ?></p>
                <ul>
                    <li><strong><?php esc_html_e( 'Commercial plugins and themes:', 'unstoppable-cra-lite' ); ?></strong> <?php esc_html_e( 'If you sell plugins or themes to EU customers, you\'re a manufacturer.', 'unstoppable-cra-lite' ); ?></li>
                    <li><strong><?php esc_html_e( 'SaaS with downloadable components:', 'unstoppable-cra-lite' ); ?></strong> <?php esc_html_e( 'If your service includes downloadable software.', 'unstoppable-cra-lite' ); ?></li>
                    <li><strong><?php esc_html_e( 'Client work:', 'unstoppable-cra-lite' ); ?></strong> <?php esc_html_e( 'Custom development may also be covered depending on the arrangement.', 'unstoppable-cra-lite' ); ?></li>
                </ul>
                <p class="ucral-note">
                    <strong><?php esc_html_e( 'Note:', 'unstoppable-cra-lite' ); ?></strong>
                    <?php esc_html_e( 'Free and open-source software developed non-commercially may be exempt, but the boundaries are complex.', 'unstoppable-cra-lite' ); ?>
                </p>
            </div>
        </div>

        <!-- The Fines -->
        <div class="ucral-learn-card ucral-learn-warning">
            <div class="ucral-learn-header">
                <span class="dashicons dashicons-warning"></span>
                <h2><?php esc_html_e( 'The €15 Million Question', 'unstoppable-cra-lite' ); ?></h2>
            </div>
            <div class="ucral-learn-content">
                <p><?php esc_html_e( 'Non-compliance with CRA requirements can result in significant penalties:', 'unstoppable-cra-lite' ); ?></p>
                <div class="ucral-fine-grid">
                    <div class="ucral-fine-item">
                        <span class="ucral-fine-amount"><?php esc_html_e( '€15M', 'unstoppable-cra-lite' ); ?></span>
                        <span class="ucral-fine-desc"><?php esc_html_e( 'or 2.5% of global turnover for essential requirements', 'unstoppable-cra-lite' ); ?></span>
                    </div>
                    <div class="ucral-fine-item">
                        <span class="ucral-fine-amount"><?php esc_html_e( '€10M', 'unstoppable-cra-lite' ); ?></span>
                        <span class="ucral-fine-desc"><?php esc_html_e( 'or 2% of global turnover for other obligations', 'unstoppable-cra-lite' ); ?></span>
                    </div>
                </div>
                <p><?php esc_html_e( 'Beyond fines, non-compliant products can be removed from the EU market entirely.', 'unstoppable-cra-lite' ); ?></p>
            </div>
        </div>

        <!-- Timeline -->
        <div class="ucral-learn-card">
            <div class="ucral-learn-header">
                <span class="dashicons dashicons-calendar-alt"></span>
                <h2><?php esc_html_e( 'Critical Deadlines', 'unstoppable-cra-lite' ); ?></h2>
            </div>
            <div class="ucral-learn-content">
                <div class="ucral-timeline">
                    <div class="ucral-timeline-item <?php echo Unstoppable_CRA_Lite::get_days_until_vuln_deadline() <= 0 ? 'ucral-timeline-passed' : ''; ?>">
                        <div class="ucral-timeline-date"><?php esc_html_e( 'June 11, 2026', 'unstoppable-cra-lite' ); ?></div>
                        <div class="ucral-timeline-title"><?php esc_html_e( 'Vulnerability Handling Required', 'unstoppable-cra-lite' ); ?></div>
                        <div class="ucral-timeline-desc"><?php esc_html_e( 'Manufacturers must have documented vulnerability handling procedures and incident reporting capabilities.', 'unstoppable-cra-lite' ); ?></div>
                    </div>
                    <div class="ucral-timeline-item">
                        <div class="ucral-timeline-date"><?php esc_html_e( 'December 11, 2027', 'unstoppable-cra-lite' ); ?></div>
                        <div class="ucral-timeline-title"><?php esc_html_e( 'Full CRA Compliance', 'unstoppable-cra-lite' ); ?></div>
                        <div class="ucral-timeline-desc"><?php esc_html_e( 'All requirements apply, including CE marking, technical documentation, and conformity assessment.', 'unstoppable-cra-lite' ); ?></div>
                        <div class="ucral-timeline-badge"><?php echo esc_html( $days_left ); ?> <?php esc_html_e( 'days remaining', 'unstoppable-cra-lite' ); ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SBOM Requirement -->
        <div class="ucral-learn-card">
            <div class="ucral-learn-header">
                <span class="dashicons dashicons-list-view"></span>
                <h2><?php esc_html_e( 'Software Bill of Materials (SBOM)', 'unstoppable-cra-lite' ); ?></h2>
            </div>
            <div class="ucral-learn-content">
                <p><?php esc_html_e( 'The CRA requires manufacturers to provide an SBOM - a comprehensive list of all components in your software.', 'unstoppable-cra-lite' ); ?></p>
                <p><strong><?php esc_html_e( 'Your SBOM must include:', 'unstoppable-cra-lite' ); ?></strong></p>
                <ul>
                    <li><?php esc_html_e( 'All third-party libraries and dependencies', 'unstoppable-cra-lite' ); ?></li>
                    <li><?php esc_html_e( 'Version numbers for each component', 'unstoppable-cra-lite' ); ?></li>
                    <li><?php esc_html_e( 'Licensing information', 'unstoppable-cra-lite' ); ?></li>
                    <li><?php esc_html_e( 'Dependency relationships', 'unstoppable-cra-lite' ); ?></li>
                </ul>
                <p><?php esc_html_e( 'Standard formats include CycloneDX and SPDX, which are machine-readable and allow for automated vulnerability scanning.', 'unstoppable-cra-lite' ); ?></p>
            </div>
        </div>

        <!-- Vulnerability Handling -->
        <div class="ucral-learn-card">
            <div class="ucral-learn-header">
                <span class="dashicons dashicons-shield"></span>
                <h2><?php esc_html_e( 'Vulnerability Handling', 'unstoppable-cra-lite' ); ?></h2>
            </div>
            <div class="ucral-learn-content">
                <p><?php esc_html_e( 'Article 14 of the CRA establishes specific requirements for handling vulnerabilities:', 'unstoppable-cra-lite' ); ?></p>
                <ul>
                    <li><strong><?php esc_html_e( 'Security contact:', 'unstoppable-cra-lite' ); ?></strong> <?php esc_html_e( 'Provide a way for researchers to report vulnerabilities', 'unstoppable-cra-lite' ); ?></li>
                    <li><strong><?php esc_html_e( 'Coordinated disclosure:', 'unstoppable-cra-lite' ); ?></strong> <?php esc_html_e( 'Document your disclosure timeline (typically 90 days)', 'unstoppable-cra-lite' ); ?></li>
                    <li><strong><?php esc_html_e( 'Vulnerability tracking:', 'unstoppable-cra-lite' ); ?></strong> <?php esc_html_e( 'Maintain records of reported vulnerabilities and their status', 'unstoppable-cra-lite' ); ?></li>
                    <li><strong><?php esc_html_e( 'Timely patches:', 'unstoppable-cra-lite' ); ?></strong> <?php esc_html_e( 'Provide security updates throughout the support period', 'unstoppable-cra-lite' ); ?></li>
                </ul>
            </div>
        </div>

        <!-- Incident Reporting -->
        <div class="ucral-learn-card">
            <div class="ucral-learn-header">
                <span class="dashicons dashicons-megaphone"></span>
                <h2><?php esc_html_e( 'Incident Reporting to ENISA', 'unstoppable-cra-lite' ); ?></h2>
            </div>
            <div class="ucral-learn-content">
                <p><?php esc_html_e( 'When vulnerabilities are actively exploited, the CRA requires reporting to ENISA (EU Agency for Cybersecurity):', 'unstoppable-cra-lite' ); ?></p>
                <ul>
                    <li><strong><?php esc_html_e( '24 hours:', 'unstoppable-cra-lite' ); ?></strong> <?php esc_html_e( 'Initial notification of actively exploited vulnerability', 'unstoppable-cra-lite' ); ?></li>
                    <li><strong><?php esc_html_e( '72 hours:', 'unstoppable-cra-lite' ); ?></strong> <?php esc_html_e( 'Detailed vulnerability report', 'unstoppable-cra-lite' ); ?></li>
                    <li><strong><?php esc_html_e( '14 days:', 'unstoppable-cra-lite' ); ?></strong> <?php esc_html_e( 'Final report after incident resolution', 'unstoppable-cra-lite' ); ?></li>
                </ul>
                <p><?php esc_html_e( 'You need documented procedures and templates ready before an incident occurs.', 'unstoppable-cra-lite' ); ?></p>
            </div>
        </div>

        <!-- CE Marking -->
        <div class="ucral-learn-card">
            <div class="ucral-learn-header">
                <span class="dashicons dashicons-yes-alt"></span>
                <h2><?php esc_html_e( 'CE Marking for Software', 'unstoppable-cra-lite' ); ?></h2>
            </div>
            <div class="ucral-learn-content">
                <p><?php esc_html_e( 'Yes, software will require CE marking under the CRA. To apply the mark, you must:', 'unstoppable-cra-lite' ); ?></p>
                <ul>
                    <li><?php esc_html_e( 'Complete a conformity assessment', 'unstoppable-cra-lite' ); ?></li>
                    <li><?php esc_html_e( 'Prepare technical documentation', 'unstoppable-cra-lite' ); ?></li>
                    <li><?php esc_html_e( 'Issue an EU Declaration of Conformity', 'unstoppable-cra-lite' ); ?></li>
                    <li><?php esc_html_e( 'Meet all essential cybersecurity requirements', 'unstoppable-cra-lite' ); ?></li>
                </ul>
                <p><?php esc_html_e( 'The declaration must reference specific CRA annexes and be kept available for 10 years.', 'unstoppable-cra-lite' ); ?></p>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="ucral-section ucral-learn-cta">
        <h2><?php esc_html_e( 'Ready to Get Compliant?', 'unstoppable-cra-lite' ); ?></h2>
        <p><?php esc_html_e( 'Don\'t wait until the deadline. Start your compliance journey today.', 'unstoppable-cra-lite' ); ?></p>
        <div class="ucral-cta-buttons">
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=ucral-assessment' ) ); ?>" class="button button-secondary button-hero">
                <?php esc_html_e( 'Take the Self-Assessment', 'unstoppable-cra-lite' ); ?>
            </a>
            <a href="https://unstoppablesolutions.app/PluginDetail?slug=unstoppable-cra-compliance" class="button button-primary button-hero" target="_blank">
                <?php esc_html_e( 'Get the Full Compliance Package', 'unstoppable-cra-lite' ); ?>
            </a>
        </div>
    </div>
</div>
