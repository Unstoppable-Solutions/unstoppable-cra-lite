<?php
/**
 * Readiness Score Calculator
 *
 * Calculates the overall CRA compliance readiness score.
 * Deliberately weighted to land most users in the 20-45% range.
 *
 * @package Unstoppable_CRA_Lite
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Readiness Score Class.
 */
class UCRAL_Readiness_Score {

    /**
     * CRA Compliance Pillars.
     */
    const PILLAR_SBOM              = 'sbom';
    const PILLAR_VULNERABILITY     = 'vulnerability_handling';
    const PILLAR_INCIDENT          = 'incident_reporting';
    const PILLAR_CE_MARKING        = 'ce_marking';
    const PILLAR_DOCUMENTATION     = 'documentation';

    /**
     * Get all pillars with their details.
     *
     * @return array
     */
    public static function get_pillars() {
        return array(
            self::PILLAR_SBOM => array(
                'title'       => __( 'Software Bill of Materials', 'unstoppable-cra-lite' ),
                'short'       => __( 'SBOM', 'unstoppable-cra-lite' ),
                'description' => __( 'Documentation of all software components and dependencies.', 'unstoppable-cra-lite' ),
                'weight'      => 25,
                'icon'        => 'list-view',
            ),
            self::PILLAR_VULNERABILITY => array(
                'title'       => __( 'Vulnerability Handling', 'unstoppable-cra-lite' ),
                'short'       => __( 'Vulnerabilities', 'unstoppable-cra-lite' ),
                'description' => __( 'Processes for receiving, tracking, and addressing security vulnerabilities.', 'unstoppable-cra-lite' ),
                'weight'      => 25,
                'icon'        => 'shield',
            ),
            self::PILLAR_INCIDENT => array(
                'title'       => __( 'Incident Reporting', 'unstoppable-cra-lite' ),
                'short'       => __( 'Incidents', 'unstoppable-cra-lite' ),
                'description' => __( 'Procedures for reporting security incidents to authorities.', 'unstoppable-cra-lite' ),
                'weight'      => 20,
                'icon'        => 'megaphone',
            ),
            self::PILLAR_CE_MARKING => array(
                'title'       => __( 'CE Marking', 'unstoppable-cra-lite' ),
                'short'       => __( 'CE Mark', 'unstoppable-cra-lite' ),
                'description' => __( 'Conformity assessment and EU Declaration of Conformity.', 'unstoppable-cra-lite' ),
                'weight'      => 15,
                'icon'        => 'yes-alt',
            ),
            self::PILLAR_DOCUMENTATION => array(
                'title'       => __( 'Documentation & Security', 'unstoppable-cra-lite' ),
                'short'       => __( 'Docs', 'unstoppable-cra-lite' ),
                'description' => __( 'Technical documentation, update policies, and secure design practices.', 'unstoppable-cra-lite' ),
                'weight'      => 15,
                'icon'        => 'media-document',
            ),
        );
    }

    /**
     * Calculate overall readiness score.
     *
     * @return array Score data.
     */
    public static function calculate() {
        $pillars       = self::get_pillars();
        $pillar_scores = self::calculate_pillar_scores();
        
        $total_weight = 0;
        $weighted_sum = 0;

        foreach ( $pillars as $id => $pillar ) {
            $total_weight += $pillar['weight'];
            $weighted_sum += ( $pillar_scores[ $id ]['score'] / 100 ) * $pillar['weight'];
        }

        $overall_score = $total_weight > 0 ? round( ( $weighted_sum / $total_weight ) * 100 ) : 0;

        // Get requirements count.
        $requirements = UCRAL_Self_Assessment::count_requirements();

        return array(
            'score'        => $overall_score,
            'pillars'      => $pillar_scores,
            'requirements' => $requirements,
            'grade'        => self::get_grade( $overall_score ),
            'status'       => self::get_status( $overall_score ),
        );
    }

    /**
     * Calculate scores for each pillar.
     *
     * @return array
     */
    public static function calculate_pillar_scores() {
        $pillars         = self::get_pillars();
        $category_scores = UCRAL_Self_Assessment::get_category_scores();
        $scan_data       = UCRAL_Dependency_Scanner::get_last_scan();
        $security_txt    = UCRAL_Security_Txt::is_enabled();

        $scores = array();

        foreach ( $pillars as $id => $pillar ) {
            $score  = 0;
            $status = 'fail';
            $issues = array();

            switch ( $id ) {
                case self::PILLAR_SBOM:
                    // SBOM pillar: Check if dependencies are scanned + assessment answers.
                    $base_score = isset( $category_scores['sbom'] ) ? $category_scores['sbom']['score'] : 0;
                    
                    // Boost slightly if they've at least scanned.
                    if ( $scan_data && ! empty( $scan_data['total_dependencies'] ) ) {
                        $base_score = min( 100, $base_score + 15 );
                    }
                    
                    // Cap at 65% without Pro (no export capability).
                    $score = min( 65, $base_score );
                    
                    if ( $score >= 50 ) {
                        $issues[] = __( 'Generate compliant SBOM exports with Pro', 'unstoppable-cra-lite' );
                    } else {
                        $issues[] = __( 'Dependencies not fully documented', 'unstoppable-cra-lite' );
                    }
                    break;

                case self::PILLAR_VULNERABILITY:
                    // Vulnerability handling.
                    $base_score = isset( $category_scores['vulnerability_handling'] ) ? $category_scores['vulnerability_handling']['score'] : 0;
                    
                    // Boost if security.txt is enabled.
                    if ( $security_txt ) {
                        $base_score = min( 100, $base_score + 20 );
                    }
                    
                    // Cap at 75% without Pro (no tracking workflow).
                    $score = min( 75, $base_score );
                    
                    if ( ! $security_txt ) {
                        $issues[] = __( 'No public security contact', 'unstoppable-cra-lite' );
                    }
                    if ( $score >= 50 ) {
                        $issues[] = __( 'Add vulnerability tracking with Pro', 'unstoppable-cra-lite' );
                    }
                    break;

                case self::PILLAR_INCIDENT:
                    // Incident reporting.
                    $base_score = isset( $category_scores['incident_reporting'] ) ? $category_scores['incident_reporting']['score'] : 0;
                    
                    // Cap at 55% without Pro (no ENISA templates).
                    $score = min( 55, $base_score );
                    
                    $issues[] = __( 'Generate ENISA reports with Pro', 'unstoppable-cra-lite' );
                    break;

                case self::PILLAR_CE_MARKING:
                    // CE Marking.
                    $base_score = isset( $category_scores['ce_marking'] ) ? $category_scores['ce_marking']['score'] : 0;
                    
                    // Cap at 50% without Pro (no document generation).
                    $score = min( 50, $base_score );
                    
                    $issues[] = __( 'Generate CE documentation with Pro', 'unstoppable-cra-lite' );
                    break;

                case self::PILLAR_DOCUMENTATION:
                    // Documentation & Security - not capped.
                    $base_score = isset( $category_scores['documentation'] ) ? $category_scores['documentation']['score'] : 0;
                    $score      = $base_score;
                    
                    if ( $score < 50 ) {
                        $issues[] = __( 'Security practices need improvement', 'unstoppable-cra-lite' );
                    }
                    break;
            }

            // Determine status.
            if ( $score >= 70 ) {
                $status = 'pass';
            } elseif ( $score >= 40 ) {
                $status = 'warning';
            } else {
                $status = 'fail';
            }

            $scores[ $id ] = array(
                'title'       => $pillar['title'],
                'short'       => $pillar['short'],
                'description' => $pillar['description'],
                'icon'        => $pillar['icon'],
                'weight'      => $pillar['weight'],
                'score'       => $score,
                'status'      => $status,
                'issues'      => $issues,
            );
        }

        return $scores;
    }

    /**
     * Get letter grade from score.
     *
     * @param int $score Score 0-100.
     * @return string
     */
    public static function get_grade( $score ) {
        if ( $score >= 90 ) {
            return 'A';
        } elseif ( $score >= 80 ) {
            return 'B';
        } elseif ( $score >= 70 ) {
            return 'C';
        } elseif ( $score >= 60 ) {
            return 'D';
        } else {
            return 'F';
        }
    }

    /**
     * Get status label from score.
     *
     * @param int $score Score 0-100.
     * @return array
     */
    public static function get_status( $score ) {
        if ( $score >= 80 ) {
            return array(
                'label' => __( 'Ready', 'unstoppable-cra-lite' ),
                'class' => 'success',
                'color' => '#00a32a',
            );
        } elseif ( $score >= 60 ) {
            return array(
                'label' => __( 'Needs Work', 'unstoppable-cra-lite' ),
                'class' => 'warning',
                'color' => '#dba617',
            );
        } elseif ( $score >= 40 ) {
            return array(
                'label' => __( 'At Risk', 'unstoppable-cra-lite' ),
                'class' => 'warning',
                'color' => '#f0b849',
            );
        } else {
            return array(
                'label' => __( 'Not Compliant', 'unstoppable-cra-lite' ),
                'class' => 'danger',
                'color' => '#d63638',
            );
        }
    }

    /**
     * Get pillar status class.
     *
     * @param string $status Status string.
     * @return string CSS class.
     */
    public static function get_status_class( $status ) {
        switch ( $status ) {
            case 'pass':
                return 'ucral-status-pass';
            case 'warning':
                return 'ucral-status-warning';
            case 'fail':
            default:
                return 'ucral-status-fail';
        }
    }
}
