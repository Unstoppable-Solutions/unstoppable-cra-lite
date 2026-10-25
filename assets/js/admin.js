/**
 * Admin JavaScript
 *
 * @package Unstoppable_CRA_Lite
 */

(function($) {
    'use strict';

    $(document).ready(function() {

        // Run Dependency Scan
        $('#ucral-run-scan').on('click', function() {
            var $btn = $(this);
            var $progress = $('#ucral-scan-progress');

            $btn.prop('disabled', true);
            $progress.show();

            $.ajax({
                url: ucral_admin.ajax_url,
                type: 'POST',
                data: {
                    action: 'ucral_run_scan',
                    nonce: ucral_admin.nonces.run_scan
                },
                success: function(response) {
                    if (response.success) {
                        // Reload page to show results
                        location.reload();
                    } else {
                        alert(response.data.message || ucral_admin.strings.error);
                    }
                },
                error: function() {
                    alert(ucral_admin.strings.error);
                },
                complete: function() {
                    $btn.prop('disabled', false);
                    $progress.hide();
                }
            });
        });

        // Save Assessment
        $('#ucral-assessment-form').on('submit', function(e) {
            e.preventDefault();
            var $form = $(this);
            var $btn = $form.find('button[type="submit"]');
            var answers = {};

            // Collect answers
            $form.find('input[type="radio"]:checked').each(function() {
                var name = $(this).attr('name');
                var match = name.match(/answers\[(\w+)\]/);
                if (match) {
                    answers[match[1]] = $(this).val();
                }
            });

            $btn.prop('disabled', true).text(ucral_admin.strings.saving);

            $.ajax({
                url: ucral_admin.ajax_url,
                type: 'POST',
                data: {
                    action: 'ucral_save_assessment',
                    nonce: ucral_admin.nonces.save_assessment,
                    answers: answers
                },
                success: function(response) {
                    if (response.success) {
                        // Show result
                        $('#ucral-assessment-result').show();
                        $('#ucral-assessment-result .ucral-result-value').text(response.data.score + '/100');
                        $('#ucral-assessment-result .ucral-result-grade').text('Grade: ' + response.data.grade);
                        
                        // Scroll to result
                        $('html, body').animate({
                            scrollTop: $('#ucral-assessment-result').offset().top - 50
                        }, 500);
                    } else {
                        alert(response.data.message || ucral_admin.strings.error);
                    }
                },
                error: function() {
                    alert(ucral_admin.strings.error);
                },
                complete: function() {
                    $btn.prop('disabled', false).text('Save Assessment & Calculate Score');
                }
            });
        });

        // Security.txt Form
        $('#ucral-security-txt-form').on('submit', function(e) {
            e.preventDefault();
            var $form = $(this);
            var $btn = $form.find('button[type="submit"]');
            var $message = $('#ucral-security-txt-message');

            $btn.prop('disabled', true).text(ucral_admin.strings.saving);

            $.ajax({
                url: ucral_admin.ajax_url,
                type: 'POST',
                data: $form.serialize() + '&action=ucral_save_security_txt&nonce=' + ucral_admin.nonces.security_txt,
                success: function(response) {
                    if (response.success) {
                        $message.html('<div class="notice notice-success"><p>' + response.data.message + '</p></div>');
                        $('#ucral-security-txt-preview').text(response.data.preview);
                    } else {
                        $message.html('<div class="notice notice-error"><p>' + response.data.message + '</p></div>');
                    }
                },
                error: function() {
                    $message.html('<div class="notice notice-error"><p>' + ucral_admin.strings.error + '</p></div>');
                },
                complete: function() {
                    $btn.prop('disabled', false).text('Save Security.txt Settings');
                }
            });
        });

        // Subscribe Form
        $('#ucral-subscribe-form').on('submit', function(e) {
            e.preventDefault();
            var $form = $(this);
            var $btn = $form.find('button[type="submit"]');
            var $message = $('#ucral-subscribe-message');
            var email = $('#ucral-subscribe-email').val();

            $btn.prop('disabled', true);

            $.ajax({
                url: ucral_admin.ajax_url,
                type: 'POST',
                data: {
                    action: 'ucral_subscribe_updates',
                    nonce: ucral_admin.nonces.subscribe,
                    email: email
                },
                success: function(response) {
                    if (response.success) {
                        $message.html('<p style="color: #00a32a; margin-top: 10px;">' + response.data.message + '</p>');
                        $form.hide();
                    } else {
                        $message.html('<p style="color: #d63638; margin-top: 10px;">' + response.data.message + '</p>');
                    }
                },
                error: function() {
                    $message.html('<p style="color: #d63638; margin-top: 10px;">' + ucral_admin.strings.error + '</p>');
                },
                complete: function() {
                    $btn.prop('disabled', false);
                }
            });
        });

        // Pro button click handler (show modal or redirect)
        $('.ucral-pro-button').on('click', function(e) {
            e.preventDefault();
            window.open(ucral_admin.pro_url, '_blank');
        });

    });
})(jQuery);
