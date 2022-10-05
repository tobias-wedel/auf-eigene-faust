<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

class TwthemeCreateTaxonomy
{
	public function __construct($taxonomy_name, $posttype, $args, $fields)
	{
		$this->taxonomy_name = $taxonomy_name;
		$this->posttype = $posttype;
		$this->args = $args;
		$this->fields = $fields;
		
		add_action('init', [$this, 'register_taxonomy']);
		
		if (!is_array($fields) || empty($fields)) {
			return;
		}
		
		// Add fields
		add_action($taxonomy_name . '_add_form_fields', [$this, 'twtheme_add_form_fields']); // Add new
		add_action($taxonomy_name . '_edit_form_fields', [$this, 'twtheme_edit_form_fields'], 10, 2); // Edit
		
		// Save fields
		add_action('created_' . $taxonomy_name, [$this, 'save_term_fields']);
		add_action('edited_' . $taxonomy_name, [$this, 'save_term_fields']);
	}
	
	public function register_taxonomy()
	{
		register_taxonomy($this->taxonomy_name, $this->posttype, $this->args);
	}
	
	public function twtheme_add_form_fields($taxonomy)
	{
		
		// Add a nonce field so we can check for it later.
		wp_nonce_field('twtheme_' . $this->taxonomy_name . '_data', '_twtheme_' . $this->taxonomy_name . '_data_nonce');
		
		echo TwthemeFieldBuilder::output($this->fields, 'taxonomy', '', false, false);
	}
	
	public function twtheme_edit_form_fields($term, $taxonomy)
	{
		// Close default term table
		echo '</table>';
		
		// Add a nonce field so we can check for it later.
		wp_nonce_field('twtheme_' . $this->taxonomy_name . '_data', '_twtheme_' . $this->taxonomy_name . '_data_nonce');
		
		echo TwthemeFieldBuilder::output($this->fields, 'taxonomy', $term->term_id, false, true);
		
		// Open the default term table (This will be empty)
		echo '<table>';
	}
	
	public function save_term_fields($term_id)
	{
		// Verify nonce
		if (isset($_REQUEST['_twtheme_' . $this->taxonomy_name . '_data_nonce']) && !wp_verify_nonce($_REQUEST['_twtheme_' . $this->taxonomy_name . '_data_nonce'], 'twtheme_' . $this->taxonomy_name . '_data')) {
			return;
		}
		
		// Save into DB
		foreach ($this->fields as $tab) {
			if (!empty($tab['fields'])) {
				update_term_meta($term_id, $tab['id'], $_POST[$tab['id']]);
			}
		}
	}
}
