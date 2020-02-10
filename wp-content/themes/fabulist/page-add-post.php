<?php
    $user = wp_get_current_user();
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        //check for admins
        if ( in_array( 'administrator', $user->roles ) ) {
            // let them stay since admins can post
        } else {
            return wp_redirect(home_url());
        }
    } else {
        return wp_redirect(home_url());
    }
?>

This is the post page. This is where you will add a post.