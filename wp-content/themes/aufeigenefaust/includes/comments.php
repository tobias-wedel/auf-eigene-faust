<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Enqueue the comment reply script
 */
add_action('comment_form_before', 'enqueue_comments_reply');
function enqueue_comments_reply()
{
	if (get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}

/**
 * Validate the policy checkbox
 */
add_filter('preprocess_comment', 'verify_policy_checkbox');
function verify_policy_checkbox($commentdata)
{
	if (empty($_POST['policy']) and ! current_user_can('read')) {
		wp_die(__('<strong>Fehler</strong>: Die Datenschutzerklärung wurde nicht akzeptiert.<br><br><a href="javascript:history.back()">« Zurück</a>'));
	}
	return $commentdata;
}

/**
 * Sets a admin class to admin comments
 */
add_filter('comment_class', 'add_admin_comment_class', 10, 5);
function twtheme_comment_class_admin($classes, $css_class, $comment_ID, $comment, $post_id)
{
	$username = get_comment_author($comment_ID);
	if (!empty($username)) {
		$user = get_user_by('login', $username);
		$user_roles = $user->roles;
		
		if (in_array('administrator', $user_roles)) {
			$classes[] = 'byadmin';
		}
	}
	
	return $classes;
}

/**
 * Removes the author <a> tag
 */
add_filter('get_comment_author_link', 'remove_author_link', 10, 3);
function remove_author_link($return, $author, $comment_id)
{
	return preg_replace("/<\\/?a(\\s+.*?>|>)/", '', $return);
}


/**
* Returns empty IP for comments
*/
add_filter('pre_comment_user_ip', 'remove_comments_ip');
function remove_comments_ip($comment_author_ip)
{
	return '';
}
