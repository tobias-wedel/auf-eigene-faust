<?php

class ThemeFieldBuilder
{
	public static function display_field($field = [], $args = [])
	{
		if (!isset($field['type'])) {
			return __('Warning: No field type given!');
		}

		$final_data = [];
		
		if ($field['type'] == 'repeater') {
			$final_data['full_html'] = [];
			$final_data['label'] = [];
			$final_data['field'] = [];
			$repeater_fields = ThemeFieldBuilder::repeater_field($field, $args);
			
			
			if (is_array($repeater_fields)) {
				foreach ($repeater_fields as $fields_group_key => $fields) {
					foreach ($fields as $field_key => $field) {
						$final_data['full_html'][$fields_group_key][$field_key] = $field['full_html'];
						$final_data['label'][$fields_group_key][$field_key] = $field['label'];
						$final_data['field'][$fields_group_key][$field_key] = $field['field'];
					}
				}
				return $final_data;
			}
			
			return;
		}
		
		$final_data['full_html'] = '';
		$final_data['label'] = '';
		$final_data['field'] = '';
		$value = isset($field['value']) ? esc_attr($field['value']) : '';
		$raw_value = isset($field['value']) ? esc_attr($field['value']) : '';
		$style = !empty($field['style']) ? 'style="' . esc_attr($field['style']) . '"' : '';
		$class = !empty($field['class']) ? ' ' . esc_attr($field['class']) : '';
		$name = !empty($field['name']) ? 'name="' . esc_attr(str_replace(' ', '', $field['name'])) . '"' : '';
		$disabled = !empty($field['disabled']) ? 'disabled' : '';
		$readonly = !empty($field['readonly']) ? 'readonly' : '';
		$editable = isset($field['editable']) && $field['editable'] === true ? 'editable' : '';
		$editable_button = $editable == 'editable' ? '<span class="dashicons dashicons-edit button make-editable"></span>' : '';
		$readonly = !empty($field['readonly']) ? 'readonly' : '';
		$required = !empty($field['required']) ? 'required="required"' : '';
		$placeholder = !empty($field['placeholder']) ? 'placeholder="' . esc_attr($field['placeholder']) . '"' : '';
		$description = !empty($field['description']) ? "\n" . ' <div class="twtheme-field-description">' . wp_kses($field['description'], ['br' => [], 'strong' => [], 'span' => [], 'ol' => [], 'ul' => [], 'li' => [], 'div' => []]) . '</div>' : '';
		$label_class = !empty($field['label_class']) ? 'class="' . esc_attr($field['label_class']) . '"' : '';

		$field_atts = !empty($field['atts']) ? $field['atts'] : '';
		$field_args_attr = '';
		
		// Build atts
		if (!empty($field_atts)) {
			foreach ($field_atts as $key => $attr_value) {
				$field_args_attr .= $key . '="' . $attr_value . '"';
			}
		}

		$validation = !empty($field['validate']) ? 'data-validation="' . esc_attr($field['validate']) . '"' : '';
		$options_from_data = !empty($field['options_from_data']) ? $field['options_from_data'] : '';

		// Check the request referrer for meta_box
		// If yes, check if we are editing or submit a new post
		if (isset($args['referrer'])) {
			switch ($args['referrer']) {
				// Get value from options
				case 'option':
					if (!empty($args['option_name'])) {
						$option_name = $field['name'];

						preg_match_all('/\[(.*?)\]/', $field['name'], $option_hierarchy);

						// Build array
						$option_namevalue = get_option($args['option_name']);
						foreach ($option_hierarchy[1] as $option_hierarchy) {
							$option_namevalue = isset($option_namevalue[$option_hierarchy]) ? $option_namevalue[$option_hierarchy] : '';
						}

						$value = !empty($option_namevalue) ? $option_namevalue : $value;
						$raw_value = !empty($option_namevalue) ? $option_namevalue : $value;
						$value = ThemeFieldBuilder::data_filter($value, $field['data-filter']);

						break;
					}
			}
		} else {
			if (!empty($field['data-filter'])) {
				$value = ThemeFieldBuilder::data_filter($value, $field['data-filter']);
			}
		}

		if (!empty($value) && $field['type'] != 'textarea' && $field['type'] != 'form-builder' && $field['type'] != 'radio' && $field['type'] != 'select' && $field['type'] != 'link' && $field['type'] != 'button' && $field['type'] != 'image' && $field['type'] != 'checkbox') {
			$value = 'value="' . $value . '"';
		}

		switch ($field['type']) {
			case 'text':
			case 'password':
			case 'number':
			case 'email':
			case 'file':
			case 'date':
				$final_data['field'] .= '<input id="' . esc_attr($field['id']) . '" ' . 'class="' . $class . '"' . ' ' . $style . ' type="' . $field['type'] . '" ' . $name . ' ' . $placeholder . ' ' . $value . ' ' . $required . ' ' . $validation . ' ' . $disabled . ' ' . $readonly . ' ' . $field_args_attr . ' ' . $editable . '/>' . $editable_button . $description . "\n";
				break;
		
			case 'integration':
				if (isset($field['integration']['tool'])) {
					$data_integration = json_encode($field['integration']);
					
					if ($field['integration']['tool'] == 'gmaps') {
						wp_enqueue_script('google-maps-api', 'https://maps.googleapis.com/maps/api/js?key=' . TWTHEME__OPTIONS['integration']['gmaps-api-key'] . '&v=weekly', '', '', true);
										
						switch ($field['integration']['service']) {
							case 'geocoding':
								$final_data['field'] .= '<input id="' . esc_attr($field['id']) . '" data-integration=\'' . $data_integration . '\' ' . 'class="' . $class . '"' . ' ' . $style . ' type="text" ' . $name . ' ' . $placeholder . ' ' . $value . ' ' . $required . ' ' . $validation . ' ' . $disabled . ' ' . $readonly . ' ' . $field_args_attr . ' />' . "\n";
						
								break;
						}
					}
				}
				
				break;
						
			case 'text-secret':
				$final_data['field'] .= '<input id="' . esc_attr($field['id']) . '" ' . $style . ' type="text" ' . $name . ' placeholder="' . esc_attr($field['placeholder']) . '" value="" ' . $validation . ' ' . $disabled . '/>' . $description . "\n";
				break;

			case 'textarea':
				$final_data['field'] .= '<textarea id="' . esc_attr($field['id']) . '" ' . 'class="' . $class . '"' . '  ' . $style . ' rows="5" cols="50" ' . $name . ' ' . $placeholder . ' ' . $validation . ' ' . $required . ' ' . $disabled . '>' . $value . '</textarea>' . $description . "\n";
				break;
				
			case 'editor':
				ob_start();
				wp_editor(html_entity_decode($raw_value), sanitize_title(esc_attr($field['name'])), array(
					'wpautop'	   => true,
					'media_buttons' => false,
					'textarea_name' => $field['name'],
					'textarea_rows' => 8,
				));
				$final_data['field'] .= ob_get_contents();
				ob_end_clean();
				break;

			case 'checkbox':
				$checked = '';
				if (isset($value) && 'on' == $value) {
					$checked = 'checked="checked"';
				}
				$final_data['field'] .= '<input id="' . esc_attr($field['id']) . '" ' . 'class="' . $class . '"' . ' type="' . $field['type'] . '" ' . $name . ' vale="' . $value . '" ' . $checked . ' ' . $required . ' ' . $validation . ' ' . $disabled . '/>' . $description . "\n";
				break;

			case 'checkbox_multi':
				foreach ($field['options'] as $k => $v) {
					$checked = false;
					if (in_array($k, $value)) {
						$checked = true;
					}
					$final_data['field'] .= '<label for="' . esc_attr($field['id'] . '_' . $k) . '"><input type="checkbox" ' . checked($checked, true, false) . ' name="' . $field['name'] . '[]" value="' . esc_attr($k) . '" id="' . esc_attr($field['id'] . '_' . $k) . '"  ' . $validation . '/> ' . $v . '</label> ';
				}
				break;

			case 'radio':
				$checked = '';
				// Radio with options array
				if (!empty($field['options'])) {
					foreach ($field['options'] as $key => $option) {
						$checked = false;
						
						if (empty($value) && isset($option['checked']) && $option['checked'] === true) {
							$checked = 'checked="checked"';
						} elseif ($option['value'] == $value) {
							$checked = 'checked="checked"';
						}
						
						$final_data['field'] .= '<input id="' . esc_attr($field['id']) . '-'.$key.'" ' . 'class="' . $class . '"' . ' type="' . $field['type'] . '" ' . $name . ' value="' . $option['value'] . '" ' . $checked . ' ' . $required . ' ' . $disabled . '/><label for="'. esc_attr($field['id']) . '-'.$key.'">'.$option['label'].'</label>'. "\n";
					}
					
					$final_data['field'] .=  $description;
				}
				// Single Radio
				else {
					if (isset($option) && 'on' == $option) {
						$checked = 'checked="checked"';
					}
					$final_data['field'] .= '<input id="' . esc_attr($field['id']) . '" ' . 'class="' . $class . '"' . ' type="' . $field['type'] . '" ' . $name . ' value="' . $value . '" ' . $checked . ' ' . $required . ' ' . $validate . ' ' . $page . ' ' . $disabled . '/>' . $description . "\n";
				}
				break;

			case 'select':
				if (!empty($field['options']) || !empty($options_from_data)) {
					$final_data['field'] .= '<select ' . $name . ' id="' . esc_attr($field['id']) . '" ' . $validation . ' ' . $disabled . '>';

					// If both exists merger into one array
					if (!empty($field['options'] && !empty($options_from_data))) {
						$options = array_merge($field['options'], $options_from_data);
					} else {
						$options = !empty($field['options']) ? $field['options'] : $options_from_data;
					}

					foreach ($options as $key => $option) {
						$checked = false;
						$option_value = $option['value'];

						if ($value == $option['value']) {
							$checked = true;
						} elseif (!$value && isset($option['checked']) && $option['checked'] == true) {
							$checked = true;
						}

						// Check for label
						// If not set use the value as label
						$option['label'] = !empty($option['label']) ? $option['label'] : $option['value'];

						$final_data['field'] .= '<option ' . selected($checked, true, false) . ' value="' . esc_attr($option['value']) . '">' . esc_attr($option['label']) . '</option>';
					}
					$final_data['field'] .= '</select> ';
					$final_data['field'] .= $description;
				}

				break;

			case 'select_multi':
				$final_data['field'] .= '<select name="' . $field['name'] . '[]" id="' . esc_attr($field['id']) . '" multiple="multiple">';
				foreach ($field['options'] as $k => $v) {
					$selected = false;
					if (in_array($k, $value)) {
						$selected = true;
					}
					$final_data['field'] .= '<option ' . selected($selected, true, false) . ' value="' . esc_attr($k) . '" />' . $v . '</label> ';
				}
				$final_data['field'] .= '</select> ';
				break;
				
			case 'gallery':
			case 'image':
				/* array with image IDs for hidden field */
				$final_data['field'] .= '<ul class="tw_gallery_mtb">';
				
				if ($images = get_posts(array(
						'post_type' => 'attachment',
						'orderby' => 'post__in', /* we have to save the order */
						'order' => 'ASC',
						'post__in' => explode(',', $raw_value), /* $value is the image IDs comma separated */
						'numberposts' => -1,
						'post_mime_type' => 'image'
					))) {
					foreach ($images as $image) {
						$values[] = $image->ID;
						$image_src = wp_get_attachment_image_src($image->ID, 'thumbnail');
						$final_data['field'] .= '<li data-id="' . $image->ID .  '"><span style="background-image:url(' . $image_src[0] . ')"></span><a href="#" class="tw_gallery_remove">&times;</a></li>';
					}
				}
				
				$values = !empty($values) ? esc_attr(implode(',', $values)) : '';
				$multiple = $field['type'] == 'gallery' ? 'multiple' : '';
				
				$final_data['field'] .= '</ul></div>';
				$final_data['field'] .= '<a id="' . $field['id'] . '_image_button" data-uploader_title="Bilder auswählen" data-uploader_button_text="Bilder wählen" ' . $multiple . ' class="image_upload_button button">Bild(er) wählen</a>';
				$final_data['field'] .= '<input id="' . $field['id'] . '" class="image_data_field" type="hidden" ' . $name . ' value="' . $values . '">';
				break;

			case 'color':
				$final_data['field'] .= '<div class="color-picker" style="position:relative;">';
				$final_data['field'] .= '	<input type="text" ' . $name . '" class="color" value="' . esc_attr_e($value) . '" />';
				$final_data['field'] .= '	<div style="position:absolute;background:#FFF;z-index:99;border-radius:100%;" class="colorpicker"></div>';
				$final_data['field'] .= '</div>';
				break;

			case 'link':
				$final_data['field'] .= '<a id="' . esc_attr($field['id']) . '" ' . 'class="' . $class . '"' . ' ' . $style . ' ' . $placeholder . ' ' . $field_args_attr . '>' . $value . '</a>' . $description . "\n";
				break;

			case 'button':
				$final_data['field'] .= '<button id="' . esc_attr($field['id']) . '" ' . 'class="' . $class . '"' . ' ' . $style . ' type="submit" ' . $name . ' ' . $placeholder . ' ' . $required . ' ' . $validation . ' ' . $disabled . ' ' . $field_args_attr . '>' . $value . '</button>' . $description . "\n";
				break;
		}

		if (!empty($field['label'])) {
			$disabled = $disabled ? 'class="disabled"' : '';
			switch ($field['type']) {
				case 'checkbox':
				case 'checkbox_multi':
				case 'radio':
				case 'select_multi':
					$final_data['label'] .= '<label for="' . esc_attr($field['id']) . '" ' . $disabled . ' class="' . $label_class . '">' . trim($field['label']) . '</label>';
					$final_data['full_html'] .= '<div class="form-check">' . "\n";
					$final_data['full_html'] .= $final_data['field'] . $final_data['label'];
					$final_data['full_html'] .= '</div>' . "\n";
					break;
				default:
					$required_symbol = isset($options['general']['required-symbol']) ? $options['general']['required-symbol'] : '';
					$required_symbol = $required && !empty(trim($required_symbol)) ? '<span class="required-symbol">' . filter_locale_string($required_symbol, 'globals', $args['locale']) . '</span>' : '';

					$final_data['label'] .= '<label for="' . esc_attr($field['id']) . '" ' . $disabled . ' class="' . $label_class . '">' . trim($field['label']) . $required_symbol . '</label>';
					$final_data['full_html'] .= $final_data['label'] . $final_data['field'];

					break;
			}
		} else {
			$final_data['full_html'] .= $final_data['field'];
		}
		
		return $final_data;
	}

	/**
	 * Validate individual settings field
	 * @param  string $value Inputted value
	 * @return string	   Validated value
	 */
	public static function validate_field($value)
	{
		if ($value && strlen($value) > 0 && $value != '') {
			$value = urlencode(strtolower(str_replace(' ', '-', $value)));
		}
		return $value;
	}

	public static function data_filter($value, $filter)
	{
		if (!empty($value)) {
			switch ($filter) {
				case 'htmlentities':
					return htmlentities($value, ENT_QUOTES);
					break;
				case 'esc_url':
					return esc_url($value);
					break;
				case 'esc_js':
					return esc_js($value);
					break;
				case 'stringtonumber':
					return floatval($value);
					break;
				default:
					return $value;
			}
		}
	}
	
	public static function repeater_field($field, $args)
	{
		if (!empty($field['fields'])) {
			$repeater_field = [];
			foreach ($field['fields'] as $repeater_key => $options) {
				foreach ($options as $key => $option) {
					$field_rendered = ThemeFieldBuilder::display_field($option, $args);
					$repeater_field[$repeater_key][$key]['full_html'] = $field_rendered['full_html'];
					$repeater_field[$repeater_key][$key]['label'] = $field_rendered['label'];
					$repeater_field[$repeater_key][$key]['field'] = $field_rendered['field'];
				}
			}
			
			return $repeater_field;
		}
	}
	
	public static function output($fields, $values_key, $tabs = true)
	{
		$html = '';
		$html_tabs_menu = '';
		$html_tabs_content = '';
		
		
		// Build the tabs HTML
		foreach ($fields as $key => $tab) {
			$tab_id = $tab['id'];
			$tab_content_style = $key === array_key_first($fields) ? 'display: block;' : 'display: none;';
			$tab_menu_class = $key === array_key_first($fields) ? 'active' : '';
		
			$html_tabs_menu .= '<button data-tabid="' . $tab_id . '" class="tablink ' . $tab_menu_class . '" onclick="openTab(event, \'' . $tab_id . '\')">' . $tab['title'] . '</button>';
			$html_tabs_content .= '<div id="' . $tab_id . '" class="tabcontent" style="' . $tab_content_style . '">';
			$html_tabs_content .= '<h3>' . $tab['title'] . '</h3>';
		
			$html_tabs_content .= '<table class="form-table">';
			
			// Get entries from database
			// If the values_key is numeric its an post ID
			if (is_numeric($values_key)) {
				$values = get_post_meta($values_key, $tab['id'], true);
			}
			// If not its an option
			else {
				$values = get_option($values_key)[$tab['id']];
				$tab_id = $values_key . '['.$tab_id.']';
			}
			
			if (!empty($tab['fields'])) {
				foreach ($tab['fields'] as $field) {
					$form_field_data = [
						'type' => !empty($field['type']) ? $field['type'] : '',
						'class' => !empty($field['class']) ? $field['class'] : '',
						'tab_id' => $tab_id,
						'placeholder' => !empty($field['placeholder']) ? $field['placeholder'] : '',
						'description' => !empty($field['description']) ? $field['description'] : '',
						'style' => !empty($field['style']) ? $field['style'] : '',
						'options' => !empty($field['options']) ? $field['options'] : '',
						'fields' => !empty($field['fields']) ? $field['fields'] : '',
						'options_from_data' => !empty($field['options_from_data']) ? $field['options_from_data'] : '',
						'disabled' => !empty($field['disabled']) ? $field['disabled'] : '',
						'readonly' => !empty($field['readonly']) ? $field['readonly'] : '',
						'editable' => !empty($field['editable']) ? $field['editable'] : '',
						'data-filter' => !empty($field['data-filter']) ? $field['data-filter'] : '',
						'integration' => !empty($field['integration']) ? $field['integration'] : '',
					];
					
					// Check for field groups/repeater
					if (isset($field['fields'])) {
						if (isset($values[$field['name']])) {
							$repeater_blocks_count = count($values[$field['name']]);
							
							// Add fields from database to the fields array
							// Skip fist one because its already listed
							for ($i = 1; $i < $repeater_blocks_count; $i++) {
								array_push($field['fields'], $field['fields'][0]);
							}
						}

						
						foreach ($field['fields'] as $repeater_group_key => $repeater_group) {
							foreach ($repeater_group as $repeater_field_key => $repeater_field) {
								$form_field_data['fields'][$repeater_group_key][$repeater_field_key]['value'] = isset($repeater_field['id']) && !empty($values[$field['name']][$repeater_group_key][$repeater_field['id']]) ? $values[$field['name']][$repeater_group_key][$repeater_field['id']] : '';
								$form_field_data['fields'][$repeater_group_key][$repeater_field_key]['name'] = !empty($repeater_field['name']) ? $tab_id . '[' . $field['name'] . '][' . $repeater_group_key . '][' . $repeater_field['name'] . ']' : '';
								$form_field_data['fields'][$repeater_group_key][$repeater_field_key]['id'] = $form_field_data['fields'][$repeater_group_key][$repeater_field_key]['name'];
								$form_field_data['fields'][$repeater_group_key][$repeater_field_key]['label'] = !empty($repeater_field['label']) ? $repeater_field['label'] : '';
								$form_field_data['fields'][$repeater_group_key][$repeater_field_key]['type'] = !empty($repeater_field['type']) ? $repeater_field['type'] : '';
								$form_field_data['fields'][$repeater_group_key][$repeater_field_key]['description'] = !empty($repeater_field['description']) ? $repeater_field['description'] : '';
								$form_field_data['fields'][$repeater_group_key][$repeater_field_key]['integration'] = !empty($repeater_field['integration']) ? $repeater_field['integration'] : '';
								$form_field_data['fields'][$repeater_group_key][$repeater_field_key]['readonly'] = !empty($repeater_field['readonly']) ? $repeater_field['readonly'] : '';
								$form_field_data['fields'][$repeater_group_key][$repeater_field_key]['editable'] = !empty($repeater_field['editable']) ? $repeater_field['editable'] : '';
							}
						}
					} else {
						// Check if name already contains array brackets
						$value_key = $values;
						
						if (isset($field['name'])) {
							if (substr($field['name'], 0, 1) == '[') {
								// Build a valid array
								preg_match_all('/\[(.*?)\]/', $field['name'], $value_array_keys);
							
								$value_key = $values;
							
								foreach ($value_array_keys[1] as $key) {
									$value_key = $value_key[$key];
								}
							} else {
								$field['name'] = '[' . $field['name'] . ']';
								$value_key = !empty($values[$field['id']]) ? $values[$field['id']] : '';
							}
						}
						$form_field_data['value'] = isset($field['id']) && !empty($value_key) ? $value_key : '';
						$form_field_data['name'] = !empty($field['name']) ? $tab_id . $field['name'] : '';
						$form_field_data['id'] = !empty($field['id']) ? $field['id'] : '';
						$form_field_data['label'] = !empty($field['label']) ? $field['label'] : '';
					}
		
					// Check for headline or form field
					if ($form_field_data['type'] == 'headline') {
						$html_tabs_content .= '<tr class="headline">';
						$html_tabs_content .= '<td colspan="2" style="padding: 0;"><hr /><h3>' . $form_field_data['label'] . '</h3></td>';
					} else {
						$form_field = ThemeFieldBuilder::display_field($form_field_data);
						
						// Display Group Fields
						if (is_array($form_field['label'])) {
							$html_tabs_content .= '<tr><td colspan="2" class="repeater-groups-holder"><a class="add-block button btn">+</a><div class="drag-fields">';
							foreach ($form_field['label'] as $group_key => $group) {
								$html_tabs_content .= '<table class="repeater-group" data-repeatergroupkey="' . $group_key . '"><tr>';
								$group_count = count($group);
								foreach ($group as $field_key => $field) {
									if (!empty($form_field['label'][$group_key][$field_key])) {
										$html_tabs_content .= '<th>';
										
										if ($field_key == '0') {
											$html_tabs_content .= '<div class="action-bar"><span class="small dashicons dashicons-editor-ul"></span><span class="small dashicons dashicons-trash"></span></div>';
										}
										
										$html_tabs_content .= $form_field['label'][$group_key][$field_key];
										$html_tabs_content .= '</th>';
									}
									if (!empty($form_field['field'][$group_key][$field_key])) {
										$html_tabs_content .= '<td>' . $form_field['field'][$group_key][$field_key] . '</td>';
									}
									$html_tabs_content .= '</tr>';
									if (($field_key + 1) != $group_count) {
										$html_tabs_content .= '<tr>';
									}
								}
								$html_tabs_content .= '</tr></table>';
							}
							$html_tabs_content .= '</div></td></tr>';
						} else {
							if (!empty($form_field['label'])) {
								$html_tabs_content .= '<th>' . $form_field['label'] . '</th>';
							}
							if (!empty($form_field['field'])) {
								$html_tabs_content .= '<td>' . $form_field['field'] . '</td>';
							}
						}
					}
					$html_tabs_content .= '</tr>';
				}
			}
			$html_tabs_content .= '</table>';
			$html_tabs_content .= '</div>';
		}
		
		
		$html .= '<div class="tw-page-wrapper">';
		
		
		if ($tabs === true) {
			$html .= '<div class="tabs">';
			$html .= $html_tabs_menu;
			$html .= '</div>';
		}
		
		$html .= $html_tabs_content;
		$html .= '</div>';
		
		return $html;
	}
}
