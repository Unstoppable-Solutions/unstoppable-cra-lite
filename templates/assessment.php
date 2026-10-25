<?php
/**
 * Self-Assessment Template
 *
 * The "oh no" engine - questionnaire that feeds into readiness score.
 *
 * @package Unstoppable_CRA_Lite
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="wrap ucral-wrap">
    <h1><span class="dashicons dashicons-forms"></span> <?php esc_html_e( 'CRA Self-Assessment', 'unstoppable-cra-lite' ); ?></h1>

    <div class="ucral-info-box">
        <p>
            <strong><?php esc_html_e( 'Answer honestly.', 'unstoppable-cra-lite' ); ?></strong>
            <?php esc_html_e( 'This questionnaire helps identify gaps in your CRA compliance. Your answers directly affect your readiness score.', 'unstoppable-cra-lite' ); ?>
        </p>
    </div>

    <?php if ( $is_complete ) : ?>
    <div class="ucral-assessment-complete">
        <span class="dashicons dashicons-yes-alt"></span>
        <p>
            <?php
            printf(
                /* translators: %s: completion date */
                esc_html__( 'Assessment completed on %s', 'unstoppable-cra-lite' ),
                esc_html( UCRAL_Self_Assessment::get_completion_date() )
            );
            ?>
        </p>
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=ucral-dashboard' ) ); ?>" class="button">
            <?php esc_html_e( 'View Your Score', 'unstoppable-cra-lite' ); ?>
        </a>
    </div>
    <?php endif; ?>

    <form id="ucral-assessment-form" class="ucral-assessment-form">
        <?php foreach ( $categories as $cat_id => $category ) : ?>
        <div class="ucral-section ucral-category-section">
            <h2><?php echo esc_html( $category['title'] ); ?></h2>
            
            <div class="ucral-questions-list">
                <?php foreach ( $category['questions'] as $question ) : ?>
                <div class="ucral-question-item">
                    <div class="ucral-question-text">
                        <label><?php echo esc_html( $question['question'] ); ?></label>
                        <p class="ucral-question-help"><?php echo esc_html( $question['help'] ); ?></p>
                    </div>
                    <div class="ucral-question-answer">
                        <label class="ucral-radio">
                            <input type="radio" name="answers[<?php echo esc_attr( $question['id'] ); ?>]" value="yes" <?php checked( isset( $answers[ $question['id'] ] ) && 'yes' === $answers[ $question['id'] ] ); ?>>
                            <span class="ucral-radio-yes"><?php esc_html_e( 'Yes', 'unstoppable-cra-lite' ); ?></span>
                        </label>
                        <label class="ucral-radio">
                            <input type="radio" name="answers[<?php echo esc_attr( $question['id'] ); ?>]" value="no" <?php checked( isset( $answers[ $question['id'] ] ) && 'no' === $answers[ $question['id'] ] ); ?>>
                            <span class="ucral-radio-no"><?php esc_html_e( 'No', 'unstoppable-cra-lite' ); ?></span>
                        </label>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>

        <div class="ucral-section">
            <button type="submit" class="button button-primary button-hero">
                <?php esc_html_e( 'Save Assessment & Calculate Score', 'unstoppable-cra-lite' ); ?>
            </button>
        </div>
    </form>

    <div id="ucral-assessment-result" style="display: none;">
        <div class="ucral-section">
            <h2><?php esc_html_e( 'Your Results', 'unstoppable-cra-lite' ); ?></h2>
            <div class="ucral-result-score">
                <span class="ucral-result-value"></span>
                <span class="ucral-result-grade"></span>
            </div>
            <div class="ucral-result-cta">
                <p><?php esc_html_e( 'Ready to close your compliance gaps?', 'unstoppable-cra-lite' ); ?></p>
                <a href="https://unstoppablesolutions.app/PluginDetail?slug=unstoppable-cra-compliance" class="button button-primary" target="_blank">
                    <?php esc_html_e( 'Get Your Full Compliance Package →', 'unstoppable-cra-lite' ); ?>
                </a>
            </div>
        </div>
    </div>
</div>
