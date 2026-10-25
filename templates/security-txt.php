<?php
/**
 * Security.txt Template
 *
 * Generate a security.txt file - genuinely useful, satisfies a real CRA requirement.
 *
 * @package Unstoppable_CRA_Lite
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="wrap ucral-wrap">
    <h1><span class="dashicons dashicons-lock"></span> <?php esc_html_e( 'Security.txt Generator', 'unstoppable-cra-lite' ); ?></h1>

    <div class="ucral-info-box ucral-info-success">
        <p>
            <strong><?php esc_html_e( 'This satisfies a CRA requirement!', 'unstoppable-cra-lite' ); ?></strong>
            <?php esc_html_e( 'The CRA requires a publicly accessible security contact. A security.txt file (RFC 9116) is the industry standard for vulnerability disclosure.', 'unstoppable-cra-lite' ); ?>
        </p>
    </div>

    <div class="ucral-section">
        <h2><?php esc_html_e( 'Configure Security.txt', 'unstoppable-cra-lite' ); ?></h2>
        
        <form id="ucral-security-txt-form" class="ucral-form">
            <table class="form-table">
                <tr>
                    <th scope="row"><?php esc_html_e( 'Enable Security.txt', 'unstoppable-cra-lite' ); ?></th>
                    <td>
                        <label>
                            <input type="checkbox" name="enabled" value="1" <?php checked( $settings['enabled'] ); ?>>
                            <?php esc_html_e( 'Serve security.txt at /.well-known/security.txt', 'unstoppable-cra-lite' ); ?>
                        </label>
                        <?php if ( $settings['enabled'] ) : ?>
                        <p class="description">
                            <a href="<?php echo esc_url( UCRAL_Security_Txt::get_url() ); ?>" target="_blank">
                                <?php echo esc_html( UCRAL_Security_Txt::get_url() ); ?>
                            </a>
                        </p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="contact_email"><?php esc_html_e( 'Contact Email', 'unstoppable-cra-lite' ); ?></label>
                        <span class="required">*</span>
                    </th>
                    <td>
                        <input type="email" name="contact_email" id="contact_email" class="regular-text" value="<?php echo esc_attr( $settings['contact_email'] ); ?>" required>
                        <p class="description"><?php esc_html_e( 'Email address for security vulnerability reports.', 'unstoppable-cra-lite' ); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="contact_url"><?php esc_html_e( 'Contact URL', 'unstoppable-cra-lite' ); ?></label>
                    </th>
                    <td>
                        <input type="url" name="contact_url" id="contact_url" class="regular-text" value="<?php echo esc_attr( $settings['contact_url'] ); ?>">
                        <p class="description"><?php esc_html_e( 'Optional: URL to a security contact form or page.', 'unstoppable-cra-lite' ); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="policy_url"><?php esc_html_e( 'Disclosure Policy URL', 'unstoppable-cra-lite' ); ?></label>
                    </th>
                    <td>
                        <input type="url" name="policy_url" id="policy_url" class="regular-text" value="<?php echo esc_attr( $settings['policy_url'] ); ?>">
                        <p class="description"><?php esc_html_e( 'Link to your vulnerability disclosure policy.', 'unstoppable-cra-lite' ); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="expires"><?php esc_html_e( 'Expires', 'unstoppable-cra-lite' ); ?></label>
                        <span class="required">*</span>
                    </th>
                    <td>
                        <input type="date" name="expires" id="expires" value="<?php echo esc_attr( $settings['expires'] ); ?>" required>
                        <p class="description"><?php esc_html_e( 'Date when this security.txt should be reviewed and updated.', 'unstoppable-cra-lite' ); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="encryption_url"><?php esc_html_e( 'Encryption Key URL', 'unstoppable-cra-lite' ); ?></label>
                    </th>
                    <td>
                        <input type="url" name="encryption_url" id="encryption_url" class="regular-text" value="<?php echo esc_attr( $settings['encryption_url'] ); ?>">
                        <p class="description"><?php esc_html_e( 'Link to your PGP public key for encrypted communications.', 'unstoppable-cra-lite' ); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="acknowledgments"><?php esc_html_e( 'Acknowledgments URL', 'unstoppable-cra-lite' ); ?></label>
                    </th>
                    <td>
                        <input type="url" name="acknowledgments" id="acknowledgments" class="regular-text" value="<?php echo esc_attr( $settings['acknowledgments'] ); ?>">
                        <p class="description"><?php esc_html_e( 'Link to your security researcher hall of fame.', 'unstoppable-cra-lite' ); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="preferred_lang"><?php esc_html_e( 'Preferred Languages', 'unstoppable-cra-lite' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="preferred_lang" id="preferred_lang" class="regular-text" value="<?php echo esc_attr( $settings['preferred_lang'] ); ?>" placeholder="en, de, fr">
                        <p class="description"><?php esc_html_e( 'Comma-separated language codes (e.g., en, de, fr).', 'unstoppable-cra-lite' ); ?></p>
                    </td>
                </tr>
            </table>

            <p class="submit">
                <button type="submit" class="button button-primary">
                    <?php esc_html_e( 'Save Security.txt Settings', 'unstoppable-cra-lite' ); ?>
                </button>
            </p>
        </form>

        <div id="ucral-security-txt-message"></div>
    </div>

    <div class="ucral-section">
        <h2><?php esc_html_e( 'Preview', 'unstoppable-cra-lite' ); ?></h2>
        <pre id="ucral-security-txt-preview" class="ucral-code-preview"><?php echo esc_html( $preview ); ?></pre>
    </div>
</div>
