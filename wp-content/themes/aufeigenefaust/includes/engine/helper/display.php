<?php

// Exit if accessed directly.
defined('ABSPATH') || exit();

function twtheme_get_value($data = [])
{
	if (!is_array($data)) {
		return;
	}
	
	if (!empty($data['value'])) {
		return $data['value'];
	} else {
		return $data['placeholder'];
	}
}
