<?php
/**
 * WordPress AJAX Process Execution.
 *
 * @package WordPress
 * @subpackage Administration
 *
 * @link http://codex.wordpress.org/AJAX_in_Plugins
 */

/**
 * Executing AJAX process.
 *
 * @since 2.1.0
 */
define( 'DOING_AJAX', true );
define( 'WP_ADMIN', true );

/** Load WordPress Bootstrap */
require_once( dirname( dirname( __FILE__ ) ) . '/wp-load.php' );

/** Allow for cross-domain requests (from the frontend). */
send_origin_headers();

// Require an action parameter
if ( empty( $_REQUEST['action'] ) )
	die( '0' );

/** Load WordPress Administration APIs */
require_once( ABSPATH . 'wp-admin/includes/admin.php' );

/** Load Ajax Handlers for WordPress Core */
require_once( ABSPATH . 'wp-admin/includes/ajax-actions.php' );

@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
@header( 'X-Robots-Tag: noindex' );

send_nosniff_header();
nocache_headers();

/** This action is documented in wp-admin/admin.php */
do_action( 'admin_init' );

$core_actions_get = array(
	'fetch-list', 'ajax-tag-search', 'wp-compression-test', 'imgedit-preview', 'oembed-cache',
	'autocomplete-user', 'dashboard-widgets', 'logged-in',
);

$core_actions_post = array(
	'oembed-cache', 'image-editor', 'delete-comment', 'delete-tag', 'delete-link',
	'delete-meta', 'delete-post', 'trash-post', 'untrash-post', 'delete-page', 'dim-comment',
	'add-link-category', 'add-tag', 'get-tagcloud', 'get-comments', 'replyto-comment',
	'edit-comment', 'add-menu-item', 'add-meta', 'add-user', 'autosave', 'closed-postboxes',
	'hidden-columns', 'update-welcome-panel', 'menu-get-metabox', 'wp-link-ajax',
	'menu-locations-save', 'menu-quick-search', 'meta-box-order', 'get-permalink',
	'sample-permalink', 'inline-save', 'inline-save-tax', 'find_posts', 'widgets-order',
	'save-widget', 'set-post-thumbnail', 'date_format', 'time_format', 'wp-fullscreen-save-post',
	'wp-remove-post-lock', 'dismiss-wp-pointer', 'upload-attachment', 'get-attachment',
	'query-attachments', 'save-attachment', 'save-attachment-compat', 'send-link-to-editor',
	'send-attachment-to-editor', 'save-attachment-order', 'heartbeat', 'get-revision-diffs',
	'save-user-color-scheme',
);

// Register core Ajax calls.
if ( ! empty( $_GET['action'] ) && in_array( $_GET['action'], $core_actions_get ) )
	add_action( 'wp_ajax_' . $_GET['action'], 'wp_ajax_' . str_replace( '-', '_', $_GET['action'] ), 1 );

if ( ! empty( $_POST['action'] ) && in_array( $_POST['action'], $core_actions_post ) )
	add_action( 'wp_ajax_' . $_POST['action'], 'wp_ajax_' . str_replace( '-', '_', $_POST['action'] ), 1 );

add_action( 'wp_ajax_nopriv_heartbeat', 'wp_ajax_nopriv_heartbeat', 1 );

add_action( 'wp_ajax_nopriv_audios', 'wp_ajax_nopriv_audios' );

add_action( 'wp_ajax_nopriv_submit', 'wp_ajax_nopriv_submit' );

 
function wp_ajax_nopriv_submit(){
	
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');

		$to = "seetpal.singh@emptask.com"; // this is your Email address
		$from = $_POST['email']; // this is the sender's Email address
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$subject = "Form submission";
		$subject2 = "Copy of your form submission";
		$message = $first_name . " " . $last_name . " wrote the following:" . "\n\n  dg sdgfsdgsdgfsdfg" . $_POST['message'];
		$message2 = "Here is a copy of your message " . $first_name . "\n\n" . $_POST['message'];

		$headers = "From:" . $from;
		$headers2 = "From:" . $to;
		mail($to,$subject,$message,$headers);
//		mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender
		
		echo 	'sd';
//		You can also use header('Location: thank_you.php'); to redirect to another page.

}
function wp_ajax_nopriv_audios(){
	
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	
	$args = array( 'post_type' => 'audio' );
	$getposts = get_posts( $args );
	
	$cnt = count($getposts);
	
	$i = 0;
	
	$json = array();
	
	foreach($getposts as $post) {

		$icon = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID) , $size='small-icon' );

		$path = get_post_meta( $post->ID, 'path', true );
		$key = get_post_meta( $post->ID, 'path', true );
		
		if (!empty($path)){
			
			$json[]= array(
				'ID' => $post->ID,
				'name' => $post->post_title,
				'path' => $path,
				'icon' => $icon[0]
			);
			
		}
		$i++;
	
    } 

	$jsonstring = json_encode($json);
	 echo $jsonstring;
	 
}

function ajax_get_latest_posts($count){
	$args = array( 'posts_per_page' => 5, 'offset'=> 0,'order'=> 'DESC','suppress_filters' => false );
	$posts = get_posts($args);
	 
	//echo get_the_author_meta('user_nicename',1);
     return $posts;
}
if ( is_user_logged_in() ) {
	/**
	 * Fires authenticated AJAX actions for logged-in users.
	 *
	 * The dynamic portion of the hook name, $_REQUEST['action'],
	 * refers to the name of the AJAX action callback being fired.
	 *
	 * @since 2.1.0
	 */
	do_action( 'wp_ajax_' . $_REQUEST['action'] );
} else {
	/**
	 * Fires non-authenticated AJAX actions for logged-out users.
	 *
	 * The dynamic portion of the hook name, $_REQUEST['action'],
	 * refers to the name of the AJAX action callback being fired.
	 *
	 * @since 2.8.0
	 */
	
	do_action( 'wp_ajax_nopriv_' . $_REQUEST['action'] );
}
// Default status

