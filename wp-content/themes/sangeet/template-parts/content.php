<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package sangeet
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
    <?php 
	if ( is_single() && has_post_thumbnail() ) {
		echo '<div class="single-post-thumbnail clear">';
		echo '<div class="image-shifter">';
		echo the_post_thumbnail('large-thumb');
		echo '</div>';
		echo '</div>';
	}
	
    if ( !is_single() ) {
    	echo '<div class="index-box">';
		if ( has_post_thumbnail()) {
			echo '<div class="small-index-thumbnail clear">';
			echo '<a href="' . esc_url(get_permalink()) . '" title="' . esc_html__('Read ', 'sangeet') . get_the_title() . '" rel="bookmark">';
			echo the_post_thumbnail('index-thumb');
			echo '</a>';
			echo '</div>';
		}
	}
	?>
        <header class="entry-header">
            <?php
                if ( is_single() ) {
                    the_title( '<h1 class="entry-title">', '</h1>' );
                } else {
                    the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
					if (is_sticky()) {
    					echo '<i class="fa fa-thumb-tack sticky-post"></i>';
					}
                }
    
            if ( 'post' === get_post_type() ) : ?>
            <div class="entry-meta">
                <?php sangeet_posted_on(); ?>
            </div><!-- .entry-meta -->
            <?php
            endif; ?>
        </header><!-- .entry-header -->
    

        <div class="entry-content">
            <?php the_excerpt();
                
				if( is_single() ): 
				the_content( sprintf(
                    /* translators: %s: Name of current post. */
                    wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'sangeet' ), array( 'span' => array( 'class' => array() ) ) ),
                    the_title( '<span class="screen-reader-text">"', '"</span>', false )
                ) );
    
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'sangeet' ),
                    'after'  => '</div>',
                ) );
				endif;
				
            ?>
        </div><!-- .entry-content -->
    	
        <footer class="entry-footer">
            <?php sangeet_entry_footer(); ?>
        </footer><!-- .entry-footer -->
    
    <?php if ( !is_single() ): ?>
    </div>
    <?php endif; ?>
</article><!-- #post-## -->
