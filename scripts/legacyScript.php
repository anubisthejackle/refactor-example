<?php
namespace Legacy;

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

$connection = 'ftp://username:password@ftp.example.com/';

foreach( $dates[ strtoupper( date( 'D' ) ) ] as $id => $name ) {
	$filepath = '/mnt/data/location/' . $id . '.eps';

	$tries = array(
			strtoupper( $name ) . '.eps',
			strtoupper( $name ) . '.EPS',
			$name . '.eps',
			$name . '.EPS',
		);

	foreach( $tries as $try ) {
		$url = $connection . 'bang' . $try;

		if( !file_exists( $filepath ) ) {
			exec('wget -O ' . str_replace(' ', '\ ', $filepath) . ' ' . $url);
		}

	}

	if( !file_exists( $filepath ) ) {
		mail( 'me@email.com', 'File failed to download', 'The file failed to download. You might need to download it manually.' );
	} else {
		echo 'Success';
	}
}