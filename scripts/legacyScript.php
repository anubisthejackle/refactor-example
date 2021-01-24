<?php
namespace Legacy;
require_once( __DIR__ . '/functions.php' );

$dates = array(
	'MON' => array(
		1234 => 'tue',
	),
	'TUE' => array(
		1235 => 'wed',
	),
	'WED' => array(
		1236 => 'thu',
	),
	'THU' => array(
		1237 => 'fri',
	),
	'FRI' => array(
		1238 => 'sat',
		1239 => 'sun',
		1240 => 'mon',
	),
);

array_map("Legacy\getFile", $dates[ strtoupper( date( 'D' ) ) ], array_keys($dates[ strtoupper( date( 'D' ) ) ]));