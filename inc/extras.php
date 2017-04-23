<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package wpstarter
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function wpstarter_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	return $classes;
}
add_filter( 'body_class', 'wpstarter_body_classes' );
/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function wpstarter_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'wpstarter_pingback_header' );
/**
 * remove the admin bar (styling) from front-end only?
 */
function hide_admin_bar_from_front_end(){
	if (is_blog_admin()) {
		return true;
	}
	return false;
}
add_filter( 'show_admin_bar', 'hide_admin_bar_from_front_end' );

/**
 * Disable emojicons introduced with WP 4.2
 */
function disable_wp_emojicons() {
	// all actions related to emojis
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	// filter to remove TinyMCE emojis
	function disable_emojicons_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		} else {
			return array();
		}
	}	
	add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );


/**
 * Comments form to support with bootstrap
 */

function bootstrap3_comment_form_fields( $fields ) {
	$commenter = wp_get_current_commenter();
	$req      = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$html5    = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;
	
	$fields   =  array(
		'author' => '<div class="row"><div class="form-group comment-form-author col-sm-6">' . '<label for="author">' . __( 'Name' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label><input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div>',
		'email'  => '<div class="form-group comment-form-email col-sm-6"><label for="email">' . __( 'Email' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label><input class="form-control" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div></div>'      
	);
	return $fields;
}
add_filter( 'comment_form_default_fields', 'bootstrap3_comment_form_fields' );
function bootstrap3_comment_form( $args ) {
	$args['comment_field'] = '<div class="form-group comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label> <textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></div>';
	$args['class_submit'] = 'btn btn-default'; // since WP 4.1
	
	return $args;
}
add_filter( 'comment_form_defaults', 'bootstrap3_comment_form' );
/**
 * Comments form to replacement message textarea with bootstrap
 */
function wpb_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}
add_filter( 'comment_form_fields', 'wpb_move_comment_field_to_bottom' );
// WordPress paginate_links Customization, with Bootstrap compatibility example
function sa_get_bootstrap_paginate_links() {
	ob_start();
	?>
		<div class="pages clearfix">
			<?php
				global $wp_query;
				$current = max( 1, absint( get_query_var( 'paged' ) ) );
				$args = array(
					'base' => str_replace( PHP_INT_MAX, '%#%', esc_url( get_pagenum_link( PHP_INT_MAX ) ) ),
					'format' => '?paged=%#%',
					'current' => $current,
					'total' => $wp_query->max_num_pages,
					'type' => 'array',
					'prev_text' => '&laquo;',
					'next_text' => '&raquo;',
				);
				$pagination = paginate_links( $args ); 
			?>
			<?php if ( ! empty( $pagination ) ) : ?>
				<ul class="pagination">
					<?php if ($current == 1) : ?>
						<li class="paginated_link disabled"><span><?php echo $args['prev_text'] ?></span></li>
					<?php endif ?>
					<?php foreach ( $pagination as $key => $page_link ) : ?>
						<li class="paginated_link<?php if ( strpos( $page_link, 'current' ) !== false ) { echo ' active'; } ?>"><?php echo $page_link ?></li>
					<?php endforeach ?>
					<?php if ($current == $wp_query->max_num_pages) : ?>
						<li class="paginated_link disabled"><span><?php echo $args['next_text'] ?></span></li>
					<?php endif ?>

				</ul>
			<?php endif ?>
		</div>
	<?php
	$links = ob_get_clean();
	return apply_filters( 'sa_bootstap_paginate_links', $links );
}
function sa_bootstrap_paginate_links() {
	echo sa_get_bootstrap_paginate_links();
}
// 
function the_post_navigation_thumb(){
	 $prev = get_previous_post(true); 
	 $prev_thumb = get_the_post_thumbnail_url($prev->ID, 'thumbnail' ); 
	 $next = get_next_post(true); 
	 $next_thumb = get_the_post_thumbnail_url($next->ID, 'thumbnail' ); 
	?>
	<div class="row">
		<?php if($prev) : ?>
		<div class="col-sm-6">
			<div class="media">
			<?php if($prev_thumb) :  ?>
				<div class="media-left">
					<a href="<?php echo get_permalink( $prev_thumb->ID ); ?>">
						<img class="media-object" src="<?php echo aq_resize($prev_thumb, 100, true); ?>" alt="...">
					</a>
				</div>
			<?php endif ?>
				<div class="media-body media-middle">
					<h4 class="media-heading"><a href="<?php echo get_permalink( $prev->ID ); ?>">Previous Post</a></h4>
					<p><?php echo $prev->post_title; ?></p>
				</div>
			</div>
		</div>
		<?php endif ?>
		<?php if($next) : ?>
		<div class="col-sm-6">
			<div class="media">
				<div class="media-body text-right media-middle">
					<h4 class="media-heading"><a href="<?php echo get_permalink( $next->ID ); ?>">Next Post</a></h4>
					<p><?php echo $next->post_title; ?></p>
				</div>
				<?php if($next_thumb) :  ?>
				<div class="media-right">
					<a href="<?php echo get_permalink( $next->ID ); ?>">
						<img class="media-object" src="<?php echo aq_resize($next_thumb, 100, true); ?>" alt="...">
					</a>
				</div>
				<?php endif ?>
			</div>
		</div>
		<?php endif ?>
	</div>
	<?php
}

function title()
{
	if (is_home()) {
		if ($home = get_option('page_for_posts', true)) {
			return get_the_title($home);
		}
		return __('Latest Posts', 'sage');
	}
	if (is_archive()) {
		return get_the_archive_title();
	}
	if (is_search()) {
		return sprintf(__('Search Results for %s', 'sage'), get_search_query());
	}
	if (is_404()) {
		return __('Not Found', 'sage');
	}
	return get_the_title();
}