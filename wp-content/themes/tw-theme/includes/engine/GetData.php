<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

class TwthemeGetPostMeta
{
	public function __construct($post_id)
	{
		$post_type = get_current_post_type();
		$post_meta = get_post_meta($post_id);
		$post_fields = $this->get_post_type_fields($post_type);
		$this->full_post_meta = $this->merge_arrays($post_meta, $post_fields);
	}
	
	public function get_post_meta()
	{
		return $this->full_post_meta;
	}
	
	private function get_post_type_fields($post_type)
	{
		switch ($post_type) {
			case 'harbor':
				$fields = twtheme_harbor_fields();
				break;
			default:
				$fields = null;
		}
		
		return $fields;
	}
	
	private function merge_arrays($post_meta, $fields)
	{
		$new_array = [];
		
		foreach ($fields as $first_level_key => $field_first_level) {
			foreach ($field_first_level['fields'] as $second_level_key => $field_second_level) {
				$post_meta_array = maybe_unserialize($post_meta[$fields[$first_level_key]['id']][0]);
				$field_data = $fields[$first_level_key]['fields'][$second_level_key];
				
				if ($field_second_level['type'] == 'headline') {
					continue;
				} elseif ($field_second_level['type'] == 'repeater') {
					$count_entries = count($post_meta_array[$field_second_level['name']]);
					
					// Iterate over all post meta repeater entries
					for ($i = 0; $i < $count_entries; $i++) {
						foreach ($field_second_level['fields'][0] as $repeater_field) {
							foreach ($repeater_field as $field) {
								$value = $post_meta_array[$field_second_level['name']][$i][$repeater_field['name']];
								$new_array[$field_first_level['id']][$field_second_level['name']][$i][$repeater_field['name']]['label'] = $repeater_field['label'];
								$new_array[$field_first_level['id']][$field_second_level['name']][$i][$repeater_field['name']]['group'] = !empty($repeater_field['group']) ? $repeater_field['group'] : '';
								$new_array[$field_first_level['id']][$field_second_level['name']][$i][$repeater_field['name']]['value'] = $value;
							}
						}
					}
				} else {
					$new_array[$field_first_level['id']][$field_second_level['name']]['label'] = $field_data['label'];
					$new_array[$field_first_level['id']][$field_second_level['name']]['group'] = !empty($field_data['group']) ? $field_data['group'] : '';
					$new_array[$field_first_level['id']][$field_second_level['name']]['value'] = $post_meta_array[$field_second_level['id']];
				}
			}
		}
		
		return $new_array;
	}
	
	public function get_group($group_name)
	{
		$data = $this->full_post_meta;
		
		$group_data = [];
		
		foreach ($data as $key_first_level => $data_first_level) {
			foreach ($data_first_level as $key_second_level => $data_second_level) {
				if (!array_search($group_name, $data_second_level)) {
					continue;
				}
				
				$group_data[$key_second_level] = $data_second_level;
			}
		}
		
		return $group_data;
	}
	
	public function get_section($section_name)
	{
		$data = $this->full_post_meta;
		
		return $data['prolog'];
	}
}
