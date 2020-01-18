<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package fabulist
 */

$class = 'grid-item';
$class .= has_post_thumbnail() ? '' : ' no-post-thumbnail';
$read_more = fabulist_theme_option( 'read_more_text', esc_html__( 'View Details', 'fabulist' ) );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
	<div class="post-wrapper">
		<?php if ( has_post_thumbnail() ) : ?>
            <div class="featured-image">

                    <?php the_post_thumbnail( 'medium_large', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>

            </div><!-- .recent-image -->
		<?php endif; ?>
		<p>
			<?php 
				if (the_post_thumbnail_caption()) { 
					the_post_thumbnail_caption(); 
				}
			?>
		</p>
	</div><!-- .post-wrapper -->
</article><!-- #post-<?php the_ID(); ?> -->
