<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Corporate_Prime
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class("row c-blog-section"); ?>>
	<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
	<?php if(has_post_thumbnail()): ?>
	<div class="img-thumbnail">
		<?php the_post_thumbnail('corporate-prime-fullwidth'); ?>
	</div>
	<?php endif; ?>
	<div class="row post-data">
		<header class="entry-header col-md-12">
			<?php	
				if ( is_single() ) {
					the_title( '<h1 class="entry-title">', '</h1>' );
				} else {
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				}

				if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php corporate_prime_posted_on(); ?>
				</div><!-- .entry-meta -->
				<?php
				endif; 
			?>
		</header><!-- .entry-header -->
	
		<div class="entry-content col-md-12">
			<?php
				the_content( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'corporate-prime' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );
	
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'corporate-prime' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
	
		<footer class="entry-footer col-md-12">
			<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php corporate_prime_entry_footer(); ?>
			</div><!-- .entry-meta -->
			<?php
			endif; 
			?>
		</footer><!-- .entry-footer -->

	</div>
</article><!-- #post-## -->
<div class="clearfix"></div>