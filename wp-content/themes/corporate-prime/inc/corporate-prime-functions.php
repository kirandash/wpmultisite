<?php
function corporate_prime_get_social_block(){
    global $corporate_prime_theme_data; $theme_data = $corporate_prime_theme_data;
    $open_new_tab = ($theme_data['social_link_open_in_new_tab'])?'target="_blank"':'';
    ?>
        <ul class="social">
        	<?php if(!empty($theme_data['social_link_facebook'])): ?>
            <li><a href="<?php echo esc_url($theme_data['social_link_facebook']); ?>"  <?php echo esc_attr($open_new_tab); ?>><i class="fa fa-facebook icon"></i></a></li>
            <?php endif; ?>
            <?php if(!empty($theme_data['social_link_google'])): ?>
            <li><a href="<?php echo esc_url($theme_data['social_link_google']); ?>"  <?php echo esc_attr($open_new_tab); ?>><i class="fa fa-google-plus icon"></i></a></li>
            <?php endif; ?>
            <?php if(!empty($theme_data['social_link_twitter'])): ?>
            <li><a href="<?php echo esc_url($theme_data['social_link_twitter']); ?>"  <?php echo esc_attr($open_new_tab); ?>><i class="fa fa-twitter icon"></i></a></li>
            <?php endif; ?>
            <?php if(!empty($theme_data['social_link_youtube'])): ?>
            <li><a href="<?php echo esc_url($theme_data['social_link_youtube']); ?>"  <?php echo esc_attr($open_new_tab); ?>><i class="fa fa-youtube icon"></i></a></li>
            <?php endif; ?>
            <?php if(!empty($theme_data['social_link_linkedin'])): ?>
            <li><a href="<?php echo esc_url($theme_data['social_link_linkedin']); ?>"  <?php echo esc_attr($open_new_tab); ?>><i class="fa fa-linkedin icon"></i></a></li>
            <?php endif; ?>
        </ul>    
    <?php
}

function corporate_prime_page_menu_args( $args ) {
    if ( ! isset( $args['show_home'] ) )
        $args['show_home'] = true;
    return $args;
}
add_filter( 'wp_page_menu_args', 'corporate_prime_page_menu_args' );

 
function corporate_prime_fallback_page_menu( $args = array() ) {

    $defaults = array('sort_column' => 'menu_order, post_title', 'menu_class' => 'menu', 'echo' => true, 'link_before' => '', 'link_after' => '');
    $args = wp_parse_args( $args, $defaults );
    $args = apply_filters( 'wp_page_menu_args', $args );

    $menu = '';

    $list_args = $args;

    // Show Home in the menu
    if ( ! empty($args['show_home']) ) {
        if ( true === $args['show_home'] || '1' === $args['show_home'] || 1 === $args['show_home'] )
            $text = __('Home','corporate-prime');
        else
            $text = $args['show_home'];
        $class = '';
        if ( is_front_page() && !is_paged() )
            $class = 'class="current_page_item"';
        $menu .= '<li ' . $class . '><a href="' . home_url( '/' ) . '" title="' . esc_attr($text) . '">' . $args['link_before'] . $text . $args['link_after'] . '</a></li>';
        // If the front page is a page, add it to the exclude list
        if (get_option('show_on_front') == 'page') {
            if ( !empty( $list_args['exclude'] ) ) {
                $list_args['exclude'] .= ',';
            } else {
                $list_args['exclude'] = '';
            }
            $list_args['exclude'] .= get_option('page_on_front');
        }
    }

    $list_args['echo'] = false;
    $list_args['title_li'] = '';
    $list_args['walker'] = new corporate_prime_walker_page_menu;
    $menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages($list_args) );

    if ( $menu )
        $menu = '<ul class="'. esc_attr($args['menu_class']) .'">' . $menu . '</ul>';

    $menu = '<div class="' . esc_attr($args['container_class']) . '">' . $menu . "</div>\n";
    $menu = apply_filters( 'wp_page_menu', $menu, $args );
    if ( $args['echo'] )
        echo $menu;
    else
        return $menu;
}
class corporate_prime_walker_page_menu extends Walker_Page{
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class='dropdown-menu'>\n";
    }
    function start_el( &$output, $page, $depth=0, $args = array(), $current_page = 0 ) {
        if ( $depth )
            $indent = str_repeat("\t", $depth);
        else
            $indent = '';

        extract($args, EXTR_SKIP);
        $css_class = array('page_item', 'page-item-'.$page->ID);
        if ( !empty($current_page) ) {
            $_current_page = get_post( $current_page );
            if ( in_array( $page->ID, $_current_page->ancestors ) )
                $css_class[] = 'current_page_ancestor';
            if ( $page->ID == $current_page )
                $css_class[] = 'current_page_item';
            elseif ( $_current_page && $page->ID == $_current_page->post_parent )
                $css_class[] = 'current_page_parent';
        } elseif ( $page->ID == get_option('page_for_posts') ) {
            $css_class[] = 'current_page_parent';
        }

        $css_class = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );

        $output .= $indent . '<li class="' . $css_class . '"><a href="' . esc_url(get_permalink($page->ID)) . '">' . $link_before . apply_filters( 'the_title', $page->post_title, $page->ID ) . $link_after . '</a>';

        if ( !empty($show_date) ) {
            if ( 'modified' == $show_date )
                $time = $page->post_modified;
            else
                $time = $page->post_date;

            $output .= " " . mysql2date($date_format, $time);
        }
    }
}

function corporate_prime_excerpt_more($more) {
    return '';
}
add_filter('excerpt_more', 'corporate_prime_excerpt_more');

?>