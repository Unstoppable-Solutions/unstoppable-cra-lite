<?php
/**
 * Self Assessment Class
 *
 * CRA compliance questionnaire that feeds into the readiness score.
 * This is the "oh no" engine.
 *
 * @package Unstoppable_CRA_Lite
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Self Assessment Class.
 */
class UCRAL_Self_Assessment {

    /**
     * Get all assessment questions.
     *
     * @return array
     */
    public static function get_questions() {
        return array(
            // Security Contact & Disclosure.
            array(
                'id'       => 'security_contact',
                'question' => __( 'Do you have a publicly accessible security contact (email or form)?', 'unstoppable-cra-lite' ),
                'category' => 'vulnerability_handling',
                'weight'   => 10,
                'help'     => __( 'CRA requires manufacturers to provide a means for security researchers to report vulnerabilities.', 'unstoppable-cra-lite' ),
            ),
            array(
                'id'       => 'disclosure_policy',
                'question' => __( 'Do you have a documented vulnerability disclosure policy?', 'unstoppable-cra-lite' ),
                'category' => 'vulnerability_handling',
                'weight'   => 10,
                'help'     => __( 'A coordinated disclosure policy (typically 90 days) is required.', 'unstoppable-cra-lite' ),
            ),
            array(
                'id'       => 'vuln_tracking',
                'question' => __( 'Do you track reported vulnerabilities in a formal system?', 'unstoppable-cra-lite' ),
                'category' => 'vulnerability_handling',
                'weight'   => 8,
                'help'     => __( 'You must maintain records of vulnerabilities and their resolution.', 'unstoppable-cra-lite' ),
            ),
            
            // SBOM & Dependencies.
            array(
                'id'       => 'dependency_inventory',
                'question' => __( 'Do you maintain an inventory of all third-party dependencies?', 'unstoppable-cra-lite' ),
                'category' => 'sbom',
                'weight'   => 10,
                'help'     => __( 'CRA requires a Software Bill of Materials (SBOM) documenting all components.', 'unstoppable-cra-lite' ),
            ),
            array(
                'id'       => 'sbom_format',
                'question' => __( 'Can you generate SBOMs in a standard format (CycloneDX or SPDX)?', 'unstoppable-cra-lite' ),
                'category' => 'sbom',
                'weight'   => 8,
                'help'     => __( 'Machine-readable SBOM formats are expected for compliance.', 'unstoppable-cra-lite' ),
            ),
            array(
                'id'       => 'dep_updates',
                'question' => __( 'Do you have a process for monitoring and updating dependencies?', 'unstoppable-cra-lite' ),
                'category' => 'sbom',
                'weight'   => 6,
                'help'     => __( 'Keeping dependencies updated is essential for addressing known vulnerabilities.', 'unstoppable-cra-lite' ),
            ),
            
            // Security Updates.
            array(
                'id'       => 'update_mechanism',
                'question' => __( 'Do your products have a mechanism for delivering security updates?', 'unstoppable-cra-lite' ),
                'category' => 'documentation',
                'weight'   => 10,
                'help'     => __( 'Users must be able to receive and install security patches.', 'unstoppable-cra-lite' ),
            ),
            array(
                'id'       => 'support_period',
                'question' => __( 'Have you defined and documented a support period for your products?', 'unstoppable-cra-lite' ),
                'category' => 'documentation',
                'weight'   => 6,
                'help'     => __( 'CRA requires manufacturers to state how long security updates will be provided.', 'unstoppable-cra-lite' ),
            ),
            array(
                'id'       => 'eol_policy',
                'question' => __( 'Do you have an end-of-life policy communicated to users?', 'unstoppable-cra-lite' ),
                'category' => 'documentation',
                'weight'   => 4,
                'help'     => __( 'Users must know when a product will stop receiving updates.', 'unstoppable-cra-lite' ),
            ),
            
            // Incident Reporting.
            array(
                'id'       => 'incident_process',
                'question' => __( 'Do you have a documented incident response process?', 'unstoppable-cra-lite' ),
                'category' => 'incident_reporting',
                'weight'   => 8,
                'help'     => __( 'CRA requires reporting actively exploited vulnerabilities within 24 hours.', 'unstoppable-cra-lite' ),
            ),
            array(
                'id'       => 'enisa_aware',
                'question' => __( 'Are you familiar with ENISA reporting requirements?', 'unstoppable-cra-lite' ),
                'category' => 'incident_reporting',
                'weight'   => 6,
                'help'     => __( 'Certain incidents must be reported to the EU cybersecurity agency (ENISA).', 'unstoppable-cra-lite' ),
            ),
            array(
                'id'       => 'incident_contacts',
                'question' => __( 'Do you have 24/7 contacts for security incident response?', 'unstoppable-cra-lite' ),
                'category' => 'incident_reporting',
                'weight'   => 4,
                'help'     => __( 'The 24-hour reporting window requires rapid response capability.', 'unstoppable-cra-lite' ),
            ),
            
            // CE Marking & Conformity.
            array(
                'id'       => 'ce_awareness',
                'question' => __( 'Are you aware that digital products will require CE marking under CRA?', 'unstoppable-cra-lite' ),
                'category' => 'ce_marking',
                'weight'   => 2,
                'help'     => __( 'Products with digital elements must bear CE marking to be sold in the EU.', 'unstoppable-cra-lite' ),
            ),
            array(
                'id'       => 'conformity_assessment',
                'question' => __( 'Have you begun conformity assessment procedures for your products?', 'unstoppable-cra-lite' ),
                'category' => 'ce_marking',
                'weight'   => 8,
                'help'     => __( 'You must assess and document that your products meet CRA requirements.', 'unstoppable-cra-lite' ),
            ),
            array(
                'id'       => 'technical_docs',
                'question' => __( 'Do you maintain technical documentation for your products?', 'unstoppable-cra-lite' ),
                'category' => 'ce_marking',
                'weight'   => 6,
                'help'     => __( 'Technical documentation must be available to authorities upon request.', 'unstoppable-cra-lite' ),
            ),
            array(
                'id'       => 'declaration_conformity',
                'question' => __( 'Can you produce an EU Declaration of Conformity for your products?', 'unstoppable-cra-lite' ),
                'category' => 'ce_marking',
                'weight'   => 8,
                'help'     => __( 'A formal declaration is required before applying CE marking.', 'unstoppable-cra-lite' ),
            ),
            
            // Security by Design.
            array(
                'id'       => 'secure_design',
                'question' => __( 'Do you follow secure-by-design principles in development?', 'unstoppable-cra-lite' ),
                'category' => 'documentation',
                'weight'   => 6,
                'help'     => __( 'CRA requires products to be designed with security as a core principle.', 'unstoppable-cra-lite' ),
            ),
            array(
                'id'       => 'secure_defaults',
                'question' => __( 'Are your products configured securely by default?', 'unstoppable-cra-lite' ),
                'category' => 'documentation',
                'weight'   => 6,
                'help'     => __( 'Default configurations must minimize attack surface.', 'unstoppable-cra-lite' ),
            ),
            array(
                'id'       => 'security_testing',
                'question' => __( 'Do you perform security testing before releases?', 'unstoppable-cra-lite' ),
                'category' => 'documentation',
                'weight'   => 6,
                'help'     => __( 'Regular security testing is expected as part of due diligence.', 'unstoppable-cra-lite' ),
            ),
        );
    }

    /**
     * Get questions grouped by category.
     *
     * @return array
     */
    public static function get_questions_by_category() {
        $questions  = self::get_questions();
        $categories = array(
            'vulnerability_handling' => array(
                'title'     => __( 'Vulnerability Handling', 'unstoppable-cra-lite' ),
                'questions' => array(),
            ),
            'sbom'                   => array(
                'title'     => __( 'Software Bill of Materials', 'unstoppable-cra-lite' ),
                'questions' => array(),
            ),
            'incident_reporting'     => array(
                'title'     => __( 'Incident Reporting', 'unstoppable-cra-lite' ),
                'questions' => array(),
            ),
            'ce_marking'             => array(
                'title'     => __( 'CE Marking & Conformity', 'unstoppable-cra-lite' ),
                'questions' => array(),
            ),
            'documentation'          => array(
                'title'     => __( 'Documentation & Security', 'unstoppable-cra-lite' ),
                'questions' => array(),
            ),
        );

        foreach ( $questions as $question ) {
            if ( isset( $categories[ $question['category'] ] ) ) {
                $categories[ $question['category'] ]['questions'][] = $question;
            }
        }

        return $categories;
    }

    /**
     * Save assessment answers.
     *
     * @param array $answers Answers (question_id => yes/no).
     * @return bool
     */
    public static function save_answers( $answers ) {
        $sanitized = array();
        
        foreach ( $answers as $id => $value ) {
            $sanitized[ sanitize_key( $id ) ] = 'yes' === $value ? 'yes' : 'no';
        }

        $sanitized['completed_at'] = current_time( 'mysql' );

        return update_option( 'ucral_assessment_answers', $sanitized );
    }

    /**
     * Get saved answers.
     *
     * @return array
     */
    public static function get_answers() {
        return get_option( 'ucral_assessment_answers', array() );
    }

    /**
     * Check if assessment is complete.
     *
     * @return bool
     */
    public static function is_complete() {
        $answers   = self::get_answers();
        $questions = self::get_questions();

        if ( empty( $answers ) ) {
            return false;
        }

        foreach ( $questions as $q ) {
            if ( ! isset( $answers[ $q['id'] ] ) ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get completion date.
     *
     * @return string|false
     */
    public static function get_completion_date() {
        $answers = self::get_answers();
        return isset( $answers['completed_at'] ) ? $answers['completed_at'] : false;
    }

    /**
     * Calculate category scores.
     *
     * @return array
     */
    public static function get_category_scores() {
        $answers    = self::get_answers();
        $categories = self::get_questions_by_category();
        $scores     = array();

        foreach ( $categories as $cat_id => $category ) {
            $total_weight = 0;
            $earned       = 0;

            foreach ( $category['questions'] as $q ) {
                $total_weight += $q['weight'];
                
                if ( isset( $answers[ $q['id'] ] ) && 'yes' === $answers[ $q['id'] ] ) {
                    $earned += $q['weight'];
                }
            }

            $scores[ $cat_id ] = array(
                'title'      => $category['title'],
                'score'      => $total_weight > 0 ? round( ( $earned / $total_weight ) * 100 ) : 0,
                'earned'     => $earned,
                'total'      => $total_weight,
                'yes_count'  => 0,
                'no_count'   => 0,
                'unanswered' => 0,
            );

            foreach ( $category['questions'] as $q ) {
                if ( isset( $answers[ $q['id'] ] ) ) {
                    if ( 'yes' === $answers[ $q['id'] ] ) {
                        $scores[ $cat_id ]['yes_count']++;
                    } else {
                        $scores[ $cat_id ]['no_count']++;
                    }
                } else {
                    $scores[ $cat_id ]['unanswered']++;
                }
            }
        }

        return $scores;
    }

    /**
     * Count requirements met vs unmet.
     *
     * @return array
     */
    public static function count_requirements() {
        $answers   = self::get_answers();
        $questions = self::get_questions();
        
        $met   = 0;
        $unmet = 0;

        foreach ( $questions as $q ) {
            if ( isset( $answers[ $q['id'] ] ) && 'yes' === $answers[ $q['id'] ] ) {
                $met++;
            } else {
                $unmet++;
            }
        }

        return array(
            'met'   => $met,
            'unmet' => $unmet,
            'total' => count( $questions ),
        );
    }
}
