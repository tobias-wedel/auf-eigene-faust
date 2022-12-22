<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

class TwthemeGetPostMeta
{
	public function __construct($post_id)
	{
		$post_type = get_current_post_type();
		$this->post_meta = get_post_meta($post_id);
		$this->post_fields = $this->get_post_type_fields($post_type);
		$this->full_post_meta = $this->merge_arrays();
	}
	
	public function get_post_meta()
	{
		return $this->full_post_meta;
	}
	
	private function get_post_type_fields($post_type)
	{
		$fields = null;
		
		if (function_exists('twtheme_' . $post_type . '_fields')) {
			$fields = call_user_func('twtheme_' . $post_type . '_fields');
		}
		
		return $fields;
	}
	
	private function merge_arrays()
	{
		$new_array = [];
		
		$fields = $this->post_fields;
		$post_meta = $this->post_meta;
		
		foreach ($fields as $first_level_key => $field_first_level) {
			foreach ($field_first_level['fields'] as $second_level_key => $field_second_level) {
				$post_meta_array = maybe_unserialize($post_meta[$fields[$first_level_key]['id']][0]);
				$field_data = $fields[$first_level_key]['fields'][$second_level_key];
				
				if ($field_second_level['type'] == 'headline') {
					continue;
				} elseif ($field_second_level['type'] == 'repeater' && !empty($post_meta_array[$field_second_level['name']])) {
					$count_entries = count($post_meta_array[$field_second_level['name']]);
					
					// Iterate over all post meta repeater entries
					for ($i = 0; $i < $count_entries; $i++) {
						foreach ($field_second_level['fields'][0] as $repeater_field) {
							foreach ($repeater_field as $field) {
								$value = !empty($post_meta_array[$field_second_level['name']][$i][$repeater_field['name']]) ? $post_meta_array[$field_second_level['name']][$i][$repeater_field['name']] : '';
								$new_array[$field_first_level['id']][$field_second_level['name']][$i][$repeater_field['name']]['label'] = !empty($repeater_field['label']) ? $repeater_field['label'] : '';
								$new_array[$field_first_level['id']][$field_second_level['name']][$i][$repeater_field['name']]['placeholder'] = !empty($repeater_field['placeholder']) ? $repeater_field['placeholder'] : '';
								$new_array[$field_first_level['id']][$field_second_level['name']][$i][$repeater_field['name']]['group'] = !empty($repeater_field['group']) ? $repeater_field['group'] : '';
								$new_array[$field_first_level['id']][$field_second_level['name']][$i][$repeater_field['name']]['group-child'] = !empty($repeater_field['group-child']) ? $repeater_field['group-child'] : '';
								$new_array[$field_first_level['id']][$field_second_level['name']][$i][$repeater_field['name']]['id'] = !empty($repeater_field['id']) ? $repeater_field['id'] : '';
								$new_array[$field_first_level['id']][$field_second_level['name']][$i][$repeater_field['name']]['type'] = !empty($repeater_field['type']) ? $repeater_field['type'] : '';
								$new_array[$field_first_level['id']][$field_second_level['name']][$i][$repeater_field['name']]['title'] = !empty($repeater_field['title']) ? $repeater_field['title'] : '';
								$new_array[$field_first_level['id']][$field_second_level['name']][$i][$repeater_field['name']]['value'] = $value;
							}
						}
					}
				} else {
					$new_array[$field_first_level['id']][$field_second_level['name']]['label'] = !empty($field_data['label']) ? $field_data['label'] : '';
					$new_array[$field_first_level['id']][$field_second_level['name']]['placeholder'] = !empty($field_data['placeholder']) ? $field_data['placeholder'] : '';
					$new_array[$field_first_level['id']][$field_second_level['name']]['group'] = !empty($field_data['group']) ? $field_data['group'] : '';
					$new_array[$field_first_level['id']][$field_second_level['name']]['group-child'] = !empty($field_data['group-child']) ? $field_data['group-child'] : '';
					$new_array[$field_first_level['id']][$field_second_level['name']]['id'] = !empty($field_data['id']) ? $field_data['id'] : '';
					$new_array[$field_first_level['id']][$field_second_level['name']]['type'] = !empty($field_data['type']) ? $field_data['type'] : '';
					$new_array[$field_first_level['id']][$field_second_level['name']]['title'] = !empty($field_data['title']) ? $field_data['title'] : '';
					$new_array[$field_first_level['id']][$field_second_level['name']]['value'] = !empty($post_meta_array[$field_second_level['id']]) ? $post_meta_array[$field_second_level['id']] : '';
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
				// Check for deeper elements (repeater)
				if (isset($data_second_level[0])) {
					foreach ($data_second_level as $key_third_level => $data_third_level) {
						foreach ($data_third_level as $key_fourth_level => $data_fourth_level) {
							if (!array_search($group_name, $data_fourth_level)) {
								continue;
							}
						
							// Check for a group child and make it sublevel
							if (!empty($data_fourth_level['group-child'])) {
								$group_data[$key_third_level][$data_fourth_level['group-child']][$data_fourth_level['id']] = $data_fourth_level;
							} else {
								$group_data[$key_third_level][$key_fourth_level] = $data_fourth_level;
							}
						}
					}
				} else {
					if (!array_search($group_name, $data_second_level)) {
						continue;
					}
					
					// Check for a group child and make it sublevel
					if (!empty($data_second_level['group-child'])) {
						$group_data[$data_second_level['group-child']][$data_second_level['id']] = $data_second_level;
					} else {
						$group_data[$key_second_level] = $data_second_level;
					}
				}
			}
		}
		return $group_data;
	}
	
	public function get_section($section_name)
	{
		$data = $this->full_post_meta;
		
		return $data[$section_name];
	}
}
