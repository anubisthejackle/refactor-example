<?php
namespace Legacy;

$dates = array(
	'MON' => array(
		729181 => 'tue',
	),
	'TUE' => array(
		729182 => 'wed',
	),
	'WED' => array(
		729183 => 'thu',
	),
	'THU' => array(
		729184 => 'fri',
	),
	'FRI' => array(
		729185 => 'sat',
		729021 => 'sun',
		729180 => 'mon',
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