<?php
/**
 * Dashboard Template
 *
 * The centerpiece: countdown timer, readiness score, pillar status cards.
 *
 * @package Unstoppable_CRA_Lite
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="wrap ucral-wrap">
    <h1><span class="dashicons dashicons-shield"></span> <?php esc_html_e( 'CRA Compliance Dashboard', 'unstoppable-cra-lite' ); ?></h1>

    <!-- Deadline Countdown -->
    <div class="ucral-deadline-box">
        <div class="ucral-deadline-content">
            <div class="ucral-deadline-timer">
                <span class="ucral-days-number"><?php echo esc_html( $days_left ); ?></span>
                <span class="ucral-days-label"><?php esc_html_e( 'days until deadline', 'unstoppable-cra-lite' ); ?></span>
            </div>
            <div class="ucral-deadline-info">
                <h2><?php esc_html_e( 'EU Cyber Resilience Act', 'unstoppable-cra-lite' ); ?></h2>
                <p><?php esc_html_e( 'Full compliance required by December 11, 2027', 'unstoppable-cra-lite' ); ?></p>
                <p class="ucral-fine-warning">
                    <span class="dashicons dashicons-warning"></span>
                    <?php esc_html_e( 'Non-compliance fines up to €15 million or 2.5% of global turnover', 'unstoppable-cra-lite' ); ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Readiness Score -->
    <div class="ucral-score-section">
        <div class="ucral-score-card">
            <div class="ucral-score-circle ucral-score-<?php echo esc_attr( $score_data['status']['class'] ); ?>">
                <span class="ucral-score-value"><?php echo esc_html( $score_data['score'] ); ?></span>
                <span class="ucral-score-max">/100</span>
            </div>
            <div class="ucral-score-details">
                <h3><?php esc_html_e( 'Compliance Readiness Score', 'unstoppable-cra-lite' ); ?></h3>
                <p class="ucral-score-status ucral-status-<?php echo esc_attr( $score_data['status']['class'] ); ?>">
                    <?php echo esc_html( $score_data['status']['label'] ); ?>
                </p>
                <p class="ucral-requirements-count">
                    <strong><?php echo esc_html( $requirements['unmet'] ); ?></strong> <?php esc_html_e( 'of', 'unstoppable-cra-lite' ); ?> 
                    <strong><?php echo esc_html( $requirements['total'] ); ?></strong> <?php esc_html_e( 'compliance requirements unmet', 'unstoppable-cra-lite' ); ?>
                </p>
            </div>
        </div>

        <?php if ( $score_data['score'] < 70 ) : ?>
        <div class="ucral-upgrade-prompt">
            <p><strong><?php esc_html_e( 'Your compliance gaps need attention.', 'unstoppable-cra-lite' ); ?></strong></p>
            <a href="https://unstoppablesolutions.app/PluginDetail?slug=unstoppable-cra-compliance" class="button button-primary" target="_blank">
                <?php esc_html_e( 'Get Your Full Compliance Package →', 'unstoppable-cra-lite' ); ?>
            </a>
        </div>
        <?php endif; ?>
    </div>

    <!-- CRA Pillars Status -->
    <div class="ucral-section">
        <h2><?php esc_html_e( 'CRA Compliance Pillars', 'unstoppable-cra-lite' ); ?></h2>
        <div class="ucral-pillars-grid">
            <?php foreach ( $score_data['pillars'] as $pillar_id => $pillar ) : ?>
            <div class="ucral-pillar-card <?php echo esc_attr( UCRAL_Readiness_Score::get_status_class( $pillar['status'] ) ); ?>">
                <div class="ucral-pillar-header">
                    <span class="dashicons dashicons-<?php echo esc_attr( $pillar['icon'] ); ?>"></span>
                    <h3><?php echo esc_html( $pillar['short'] ); ?></h3>
                </div>
                <div class="ucral-pillar-score">
                    <span class="ucral-pillar-value"><?php echo esc_html( $pillar['score'] ); ?>%</span>
                </div>
                <div class="ucral-pillar-bar">
                    <div class="ucral-pillar-progress" style="width: <?php echo esc_attr( $pillar['score'] ); ?>%;"></div>
                </div>
                <?php if ( ! empty( $pillar['issues'] ) ) : ?>
                <ul class="ucral-pillar-issues">
                    <?php foreach ( array_slice( $pillar['issues'], 0, 2 ) as $issue ) : ?>
                    <li><?php echo esc_html( $issue ); ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="ucral-section">
        <h2><?php esc_html_e( 'Quick Actions', 'unstoppable-cra-lite' ); ?></h2>
        <div class="ucral-actions-grid">
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=ucral-scanner' ) ); ?>" class="ucral-action-card">
                <span class="dashicons dashicons-search"></span>
                <h4><?php esc_html_e( 'Scan Dependencies', 'unstoppable-cra-lite' ); ?></h4>
                <p><?php esc_html_e( 'Find all third-party components', 'unstoppable-cra-lite' ); ?></p>
            </a>
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=ucral-assessment' ) ); ?>" class="ucral-action-card">
                <span class="dashicons dashicons-forms"></span>
                <h4><?php esc_html_e( 'Self-Assessment', 'unstoppable-cra-lite' ); ?></h4>
                <p><?php esc_html_e( 'Check your compliance status', 'unstoppable-cra-lite' ); ?></p>
            </a>
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=ucral-security-txt' ) ); ?>" class="ucral-action-card">
                <span class="dashicons dashicons-lock"></span>
                <h4><?php esc_html_e( 'Security.txt', 'unstoppable-cra-lite' ); ?></h4>
                <p><?php esc_html_e( 'Set up vulnerability disclosure', 'unstoppable-cra-lite' ); ?></p>
            </a>
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=ucral-learn' ) ); ?>" class="ucral-action-card">
                <span class="dashicons dashicons-welcome-learn-more"></span>
                <h4><?php esc_html_e( 'Learn About CRA', 'unstoppable-cra-lite' ); ?></h4>
                <p><?php esc_html_e( 'Understand the requirements', 'unstoppable-cra-lite' ); ?></p>
            </a>
        </div>
    </div>

    <!-- Email Capture -->
    <div class="ucral-section ucral-subscribe-section">
        <h2><?php esc_html_e( 'Stay Informed', 'unstoppable-cra-lite' ); ?></h2>
        <p><?php esc_html_e( 'Get regulatory updates and compliance tips delivered to your inbox.', 'unstoppable-cra-lite' ); ?></p>
        <form id="ucral-subscribe-form" class="ucral-subscribe-form">
            <input type="email" id="ucral-subscribe-email" placeholder="<?php esc_attr_e( 'Enter your email', 'unstoppable-cra-lite' ); ?>" required>
            <button type="submit" class="button button-primary"><?php esc_html_e( 'Subscribe to CRA Updates', 'unstoppable-cra-lite' ); ?></button>
        </form>
        <div id="ucral-subscribe-message"></div>
    </div>
</div>
