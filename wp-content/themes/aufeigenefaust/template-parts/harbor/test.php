<?php

// Exit if accessed directly.
defined('ABSPATH') || exit();

$test = get_query_var('test');

$test['peter'] = 'peter';

set_query_var('test', $test);
	print_rpre($test);


echo 'Test';
