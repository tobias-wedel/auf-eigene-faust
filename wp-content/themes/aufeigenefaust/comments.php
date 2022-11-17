<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

if (post_password_required()) {
	return;
}

$comments_count = get_comments_number();


?>

<div id="comments" class="comments-area <?php echo get_option('show_avatars') ? 'show-avatars' : ''; ?>">
	<?php if (have_comments()) : ?>
	<div class="h3 comments-title">
		<?php
		if ('1' === $comments_count) {
			echo 'Ein Kommentar';
		} else {
			echo sprintf('%s Kommentare', $comments_count);
		} ?>
	</div>

	<ol class="comment-list">
		<?php
			wp_list_comments(
			[
					'avatar_size' => 60,
					'style'	   => 'ol',
					'short_ping'  => true,
				]
		); ?>
	</ol>

	<?php
		the_comments_pagination(
			[
				'before_page_number' => 'Seite ',
				'mid_size'		   => 0,
				'prev_text'		  => 'Zurück',
				'next_text'		  => 'Weiter',
			]
		); ?>

	<?php if (!comments_open()) : ?>
	<p class="no-comments">Kommentarbereich ist geschlossen</p>
	<?php endif; ?>
	<?php else : ?>
	<?php echo '<h3>Schreibe einen Kommtantar</h3>'; ?>
	<?php endif; ?>

	<?php
	comment_form(
			[
			'fields' => apply_filters(
				'comment_form_default_fields',
				[
					'author' => '<div class="form-input"><input placeholder="Name *" class="form-control" id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" aria-required="true" /><div class="messages"></div></div>',
					'email' => '<div class="form-input"><input placeholder="E-Mail *" class="form-input" id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" aria-required="true" /><div class="messages"></div></div>',
					'policy' => '<div class="form-input"><label for="policy"><input id="policy" name="policy" value="policy-key" class="form-check-input" type="checkbox" aria-required="true"> Ich akzeptiere die <a href="' . get_privacy_policy_url() . '" target="_blank">Datenschutzerklärung</a> *</label><div class="messages"></div></div>',
					'cookies' => '<div class="form-input"><label for="wp-comment-cookies-consent"><input id="wp-comment-cookies-consent" class="form-checkbox" name="wp-comment-cookies-consent" type="checkbox" value="yes"> Meinen Namen, meine E-Mail-Adresse und meine Website in diesem Browser speichern, bis ich wieder kommentiere.</label></div>',
				]
			),
			'comment_field' => '<div class="form-input"><textarea placeholder="Kommentar *" class="form-control" id="comment" name="comment" aria-required="true"></textarea><div class="messages"></div></div>',
			'logged_in_as' => null,
			'title_reply' => 'Antworten',
			'title_reply_before' => '<div class="h3" id="reply-title" class="comment-reply-title">',
			'title_reply_after' => '</div>',
			'submit_button' => '<button type="submit" class="btn btn-primary">Kommentar absenden</button></div>',
			'submit_field' => '<div class="form-row" class="form-submit">%1$s %2$s</div>',
			'comment_notes_before' => '',
		]
		);
	?>
</div>