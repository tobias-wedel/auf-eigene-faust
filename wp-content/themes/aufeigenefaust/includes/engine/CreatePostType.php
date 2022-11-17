<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

class TwthemeCreatePostType
{
	public function __construct($post_type, $title, $args, $fields)
	{
		$this->post_type = $post_type;
		$this->title = $title;
		$this->args = $args;
		$this->fields = $fields;
		
		add_action('init', [$this, 'register_post_type']);
		add_action('add_meta_boxes', [$this, 'add_meta_box']);
		add_action('save_post', [$this, 'save_post']);
		
		twtheme_scripts($post_type);
	}
	
	public function register_post_type()
	{
		register_post_type($this->post_type, $this->args);
	}
	
	public function add_meta_box()
	{
		add_meta_box('twtheme_' . $this->post_type . '_page_options', $this->title, [$this, 'metabox_fields'], $this->post_type, 'normal', 'high', null);
	}
	
	public function metabox_fields($post)
	{
		// Add a nonce field so we can check for it later.
		wp_nonce_field('twtheme_' . $this->post_type . '_data', '_twtheme_' . $this->post_type . '_data_nonce');
		
		echo TwthemeFieldBuilder::output($this->fields, 'posttype', $post->ID);
	}
	
	public function save_post($post_id)
	{
		global $pagenow;
		
		// Bail out on creating a new post
		if ($pagenow === 'post-new.php') {
			return;
		}
		
		// Bail out if this is an autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}
		
		if (isset($_POST['_inline_edit']) && wp_verify_nonce($_POST['_inline_edit'], 'inlineeditnonce')) {
			return;
		}
		
		// Bail out if this is not an harbor item
		if (!isset($_REQUEST['post_type']) || $this->post_type !== $_REQUEST['post_type']) {
			return;
		}
		
		// Bail out on delete
		if (isset($_GET['action']) && $_GET['action'] == 'trash') {
			return;
		}
		
		// Verify nonce
		if (isset($_REQUEST['_twtheme_' . $this->post_type . '_data_nonce']) && !wp_verify_nonce($_REQUEST['_twtheme_' . $this->post_type . '_data_nonce'], 'twtheme_' . $this->post_type . '_data')) {
			return;
		}
		
		// Save into DB
		foreach ($this->fields as $tab) {
			if (!empty($tab['fields'])) {
				update_post_meta($post_id, $tab['id'], $_POST[$tab['id']], false);
			}
		}
	}
}
