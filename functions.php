<?php

// Load latest jQuery
if ( !function_exists(core_mods) ) {
	function core_mods() {
		if ( !is_admin() ) {
			wp_deregister_script('jquery');
			wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"), false);
			wp_enqueue_script('jquery');
		}
	}
	add_action('wp_enqueue_scripts', 'core_mods');
}

// Load other custom scripts
function frankiewp_scripts() {
	wp_enqueue_script('functions', get_template_directory_uri() . '/js/functions.js', array('jquery'));
}
add_action( 'wp_enqueue_scripts', 'frankiewp_scripts' );

// Clear out the head links. Optionally re-enable these
function removeHeadLinks() {
remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
remove_action( 'wp_head', 'index_rel_link' ); // index link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version
}
add_action('init', 'removeHeadLinks');
remove_action('wp_head', 'wp_generator');

//Sets up theme defaults and registers support for various WordPress features
if ( ! function_exists( 'frankiewp_setup' ) ) :
function frankiewp_setup() {
	//Enable support for Post Thumbnails
	add_theme_support( 'post-thumbnails' );

	//This theme uses wp_nav_menu() in one location
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'frankiewp' ),
	) );

	//Enable support for Post Formats
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
}
endif;
add_action( 'after_setup_theme', 'frankiewp_setup' );

// Set up a Sidebar
if (function_exists('register_sidebar')) {
	register_sidebar(array(
		'name' => __('Sidebar Widgets','frankiewp' ),
		'id'   => 'sidebar-widgets',
		'description'   => __( 'These are widgets for the sidebar.','frankiewp' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>'
	));
}

// Custom Comments List
function frankiewp_comment($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
		 	<?php echo get_avatar( $comment->comment_author_email, 48 ); ?>
		 	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
		</div>
		<?php if ($comment->comment_approved == '0') : ?>
		 	<em><?php _e('Your comment is awaiting moderation.') ?></em>
		 	<br />
		<?php endif; ?>
		
		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','') ?></div>
		
		<?php comment_text() ?>
		
		<div class="reply">
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</div>
	</div>
<?php
}