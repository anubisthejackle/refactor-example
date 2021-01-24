<?php

namespace Legacy;

function getFile($id, $name) {
    $filepath = '/mnt/data/location/' . $id . '.eps';

	if( !fileExistsOrDownload( $name, $filepath ) ) {
		mail( 'me@email.com', 'File failed to download', 'The file failed to download. You might need to download it manually.' );
	} else {
		echo 'Success';
	}
};

function downloadFile($path, $filename) {
    $connection = 'ftp://username:password@ftp.example.com/';
    $url = $connection . 'bang' . $filename;
    exec('wget -O ' . str_replace(' ', '\ ', $path) . ' ' . $url);
}

function fileExistsOrDownload($name, $filepath) {
	$tries = array(
        strtoupper( $name ) . '.eps',
        strtoupper( $name ) . '.EPS',
        $name . '.eps',
        $name . '.EPS',
    );

    foreach( $tries as $try ) {
        
        if( file_exists( $filepath ) ) {
            return true;
        }

        downloadFile($filepath, $try);

    }

    return false;
    
}