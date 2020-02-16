<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package fabulist
 */

/**
 * fabulist_doctype_action hook
 *
 * @hooked fabulist_doctype -  10
 *
 */
do_action( 'fabulist_doctype_action' );

/**
 * fabulist_head_action hook
 *
 * @hooked fabulist_head -  10
 *
 */
do_action( 'fabulist_head_action' );

/**
 * fabulist_body_start_action hook
 *
 * @hooked fabulist_body_start -  10
 *
 */
do_action( 'fabulist_body_start_action' );
 
/**
 * fabulist_page_start_action hook
 *
 * @hooked fabulist_page_start -  10
 * @hooked fabulist_loader -  20
 *
 */
do_action( 'fabulist_page_start_action' );

/**
 * fabulist_header_start_action hook
 *
 * @hooked fabulist_header_start -  10
 *
 */
do_action( 'fabulist_header_start_action' );

/**
 * fabulist_site_branding_action hook
 *
 * @hooked fabulist_site_branding -  10
 *
 */
do_action( 'fabulist_site_branding_action' );

/**
 * fabulist_primary_nav_action hook
 *
 * @hooked fabulist_primary_nav -  10
 *
 */
do_action( 'fabulist_primary_nav_action' );

/**
 * fabulist_header_ends_action hook
 *
 * @hooked fabulist_header_ends -  10
 *
 */
do_action( 'fabulist_header_ends_action' );

/**
 * fabulist_site_content_start_action hook
 *
 * @hooked fabulist_site_content_start -  10
 *
 */
do_action( 'fabulist_site_content_start_action' );

/**
 * fabulist_primary_content_action hook
 *
 * @hooked fabulist_add_slider_section -  10
 *
 */
do_action( 'fabulist_primary_content_action' );

$user = wp_get_current_user();
$isAdmin = false;
if ( isset( $user->roles ) && is_array( $user->roles ) ) {
    //check for admins
    if ( in_array( 'administrator', $user->roles ) ) {
        $isAdmin = true;
    }
}

if($isAdmin) {
?>
<style>
    .post__link {
        font-size: 30px;
        text-align: center;
        background-color: #1398d5;
        padding: 15px;
        width: 90%;
        margin: 0 auto;
        border-radius: 20px;
    }

    .post__link a {
        color: #fff;
    }
</style>
<p class="post__link"><a href="/add-post">Add A Post</a></p>
<?php
}
