<?php

function image_upload_meta_box($field_name = '', $value= '')
{
	$image_thumb = '';
	if ($value) {
		$image_thumb = wp_get_attachment_url($value);
	}
	
	return '
	<img id="' . $field_name . '_id" class="image_preview" src="'.$image_thumb.'"><br>
	<a id="' . $field_name . '_image_button" data-uploader_title="Wähle ein Bild" data-uploader_button_text="Bild wählen" class="image_upload_button button">Bild wählen</a>
	<a id="' . $field_name . '_image_delete" class="image_delete_button button">Bild löschen</a>
	<input id="' . $field_name . '" class="image_data_field" type="hidden" name="' . $field_name . '" value="'.$value.'">';
}
