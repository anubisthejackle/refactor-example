<?php

namespace Legacy;

function getFile($id, $name) {
    $connection = 'ftp://username:password@ftp.example.com/';
    $filepath = '/mnt/data/location/' . $id . '.eps';

	$tries = array(
			strtoupper( $name ) . '.eps',
			strtoupper( $name ) . '.EPS',
			$name . '.eps',
			$name . '.EPS',
		);

	foreach( $tries as $try ) {
		$url = $connection . 'bang' . $try;

		if( file_exists( $filepath ) ) {
            break;
        }

        exec('wget -O ' . str_replace(' ', '\ ', $filepath) . ' ' . $url);		

	}

	if( !file_exists( $filepath ) ) {
		mail( 'me@email.com', 'File failed to download', 'The file failed to download. You might need to download it manually.' );
	} else {
		echo 'Success';
	}
};