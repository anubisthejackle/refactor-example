<?php

namespace Legacy;

function getDates() {
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
    
    return $dates[ strtoupper( date( 'D' ) ) ];
}

function getFile() {

    $datesAndIds = getDates();

    foreach($datesAndIds as $id => $name) {
        $filepath = '/mnt/data/location/' . $id . '.eps';
    
        if( !fileExistsOrDownload( $name, $filepath ) ) {
            mail( 'me@email.com', 'File failed to download', 'The file failed to download. You might need to download it manually.' );
        } else {
            echo 'Success';
        }
    }

};

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

function downloadFile($path, $filename) {

    $connection = ftp_connect('ftp.example.com');
    ftp_login($connection, 'username', 'password');
    ftp_pasv($connection, true);

    $filename = 'bang' . $filename;
    ftp_get($connection, $path, $filename);

}