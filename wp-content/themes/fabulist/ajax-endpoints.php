<?php

add_action('wp_ajax_nopriv_submit_invitation_request', 'submit_invitation_request');
add_action('wp_ajax_submit_invitation_request', 'submit_invitation_request');

function submit_invitation_request() {
    $result = array(
        'success' => false
    );
    $headers[] = 'From: ElsieGram Invitation <invites@elsiegram.com>';
    $emailSent = wp_mail("garrett.estrin@gmail.com", "ElsieGram Invitation Request", "Name: " . $_GET['name'] . " Email: " . $_GET['email'] . ".", $headers);
    if($emailSent) {
        $result['success'] = true;
    }
    return wp_send_json($result);
}