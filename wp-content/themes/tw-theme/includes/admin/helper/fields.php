<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

function field_builder_fields($field = [], $args = [])
{
	if (!isset($field['type'])) {
		return __('Warning: No field type is given!');
	}
	
	$final_data = [];
	
	if ($field['type'] == 'repeater') {
		$final_data['full_html'] = [];
		$final_data['label'] = [];
		$final_data['field'] = [];
		$repeater_fields = TwthemeFieldBuilder::repeater_field($field, $args);
		
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
	$value = isset($field['value']) ? $field['value'] : '';
	$raw_value = isset($field['value']) ? $field['value'] : '';
	$style = !empty($field['style']) ? 'style="' . esc_attr($field['style']) . '"' : '';
	$class = !empty($field['class']) ? ' ' . esc_attr($field['class']) : '';
	$name = !empty($field['name']) ? 'name="' . esc_attr(str_replace(' ', '', $field['name'])) . '"' : '';
	$disabled = !empty($field['disabled']) ? 'disabled' : '';
	$readonly = !empty($field['readonly']) ? 'readonly' : '';
	$editable = isset($field['editable']) && $field['editable'] === true ? 'editable' : '';
	$editable_button = $editable == 'editable' ? '<span class="dashicons dashicons-edit button make-editable"></span>' : '';
	$preview_button = '';
	$readonly = !empty($field['readonly']) ? 'readonly' : '';
	$required = !empty($field['required']) ? 'required="required"' : '';
	$multiple = !empty($field['multiple']) ? 'multiple="multiple"' : '';
	$placeholder = !empty($field['placeholder']) ? 'placeholder="' . esc_attr($field['placeholder']) . '"' : '';
	$description = !empty($field['description']) ? "\n" . ' <div class="twtheme-field-description">' . wp_kses($field['description'], ['br' => [], 'strong' => [], 'span' => [], 'ol' => [], 'ul' => [], 'li' => [], 'div' => []]) . '</div>' : '';
	$label_class = !empty($field['label_class']) ? 'class="' . esc_attr($field['label_class']) . '"' : '';
	
	$field_atts = !empty($field['atts']) ? $field['atts'] : '';
	$field_args_attr = '';
	
	// Check for integration field
	$data_integration = '';
	if (isset($field['integration']['tool'])) {
		$data_integration = json_encode($field['integration']);
			
		if ($field['integration']['tool'] == 'gmaps') {
			wp_enqueue_script('google-maps-api', 'https://maps.googleapis.com/maps/api/js?key=' . TWTHEME__OPTIONS['integration']['gmaps-api-key'] . '&v=weekly', '', '', true);
			
			if ($field['integration']['service'] == 'geocoding') {
				$preview_button = '<span class="dashicons dashicons-visibility button map-preview"></span>';
			}
		}
		
		$data_integration = "data-integration='" . $data_integration . "'";
		
		if (isset($field['integration']['source'])) {
			$data_integration .= ' data-source="' . $field['integration']['source'] . '"';
		}
	}
	
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
					$value = TwthemeFieldBuilder::data_filter($value, $field['data-filter']);
	
					break;
				}
		}
	} else {
		if (!empty($field['data-filter'])) {
			$value = TwthemeFieldBuilder::data_filter($value, $field['data-filter']);
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
			$final_data['field'] .= '<div class="input-holder"><input id="' . esc_attr($field['id']) . '" ' . 'class="' . $class . '"' . ' ' . $style . ' type="' . $field['type'] . '" ' . $name . ' ' . $placeholder . ' ' . $value . ' ' . $required . ' ' . $validation . ' ' . $data_integration . ' ' . $disabled . ' ' . $readonly . ' ' . $field_args_attr . ' ' . $editable . '/>' . $editable_button . $preview_button . '</div>' . $description . "\n";
			break;
		case 'text-secret':
			$final_data['field'] .= '<input id="' . esc_attr($field['id']) . '" ' . $style . ' type="text" ' . $name . ' placeholder="' . esc_attr($field['placeholder']) . '" value="" ' . $validation . ' ' . $disabled . '/>' . $description . "\n";
			break;
	
		case 'textarea':
			$final_data['field'] .= '<textarea id="' . esc_attr($field['id']) . '" ' . 'class="' . $class . '"' . '  ' . $style . ' rows="5" cols="50" ' . $name . ' ' . $placeholder . ' ' . $validation . ' ' . $required . ' ' . $disabled . '>' . $value . '</textarea>' . $description . "\n";
			break;
			
		case 'editor':
			$editor_settings = [
				'wpautop'	   => true,
				'media_buttons' => false,
				'textarea_name' => $field['name'],
			];
			
			// Add settings to array
			if (isset($field['settings']) && is_array($field['settings'])) {
				$editor_settings = array_merge($field['settings'], $editor_settings);
			}
			
			ob_start();
			wp_editor(html_entity_decode($raw_value), sanitize_title(esc_attr($field['name'])), $editor_settings);
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
				if ($multiple) {
					$name = 'name="' . $field['name'] . '[]"';
				}
				
				$final_data['field'] .= '<select ' . $name . ' id="' . esc_attr($field['id']) . '" ' . $validation . ' ' . $disabled . ' ' . $multiple . '>';
	
				// If both exists merger into one array
				if (!empty($field['options'] && !empty($options_from_data))) {
					$options = array_merge($field['options'], $options_from_data);
				} else {
					$options = !empty($field['options']) ? $field['options'] : $options_from_data;
				}
				
				foreach ($options as $key => $option) {
					$checked = false;
					$option_value = $option['value'];
					
					if ($value && (is_array($value) && in_array($option['value'], $value) || !is_array($value) && $value == $option['value'])) {
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
