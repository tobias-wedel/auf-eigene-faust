<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Check the user agent
 */
function get_device()
{
	$currentDevice = [
		'system' => '',
		'device' => '',
	];

	$userAgent = $_SERVER['HTTP_USER_AGENT'];

	if (preg_match('/ipad/i', $userAgent, $device)) {
		$currentDevice['system'] = strtolower($device[0]);
		$currentDevice['device'] = 'tablet';
	} elseif (preg_match('/android/i', $userAgent, $device) && !preg_match('/mobile/i', $userAgent)) {
		$currentDevice['system'] = strtolower($device[0]);
		$currentDevice['device'] = 'tablet';
	} elseif (preg_match('/iphone|android/i', $userAgent, $device)) {
		$currentDevice['system'] = strtolower($device[0]);
		$currentDevice['device'] = 'mobile';
	}

	return $currentDevice;
}

function is_mobile()
{
	$get_device = get_device();

	if ('mobile' == $get_device['device']) {
		return true;
	} else {
		return false;
	}
}

function is_tablet()
{
	$get_device = get_device();

	if ('tablet' == $get_device['device']) {
		return true;
	} else {
		return false;
	}
}

function is_desktop()
{
	$get_device = get_device();

	if ('mobile' != $get_device['device'] && 'tablet' != $get_device['device']) {
		return true;
	} else {
		return false;
	}
}
