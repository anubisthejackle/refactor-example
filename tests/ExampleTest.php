<?php

namespace Legacy {
    use function PHPUnit\Framework\assertEquals;
    /** List of defined functions to mock */
    $timestamp = \time();
    $dateExecutions = 0;
    
    $file_exists_returns = [true];
    $fileExistsExecutions = 0;
    
    $execExecutions = 0;
    $expectedExecCommand = null;
    
    $mailExecutions = 0;
    $expectedMailTo = null;
    $expectedMailSubject = null;
    $expectedMailBody = null;

    function date( $format ) {
        global $timestamp;
        global $dateExecutions;

        $dateExecutions++;
        
        return \date($format, $timestamp);
    }


    function file_exists( $file ) {
        global $file_exists_returns;
        global $fileExistsExecutions;

        $fileExistsExecutions++;

        if(\is_array($file_exists_returns) && count($file_exists_returns) > 0){
            return array_shift($file_exists_returns);
        }elseif(\is_array($file_exists_returns)){
            // Default to false if empty array
            return false;
        }

        return $file_exists_returns;
    }

    function exec($command) {
        global $execExecutions;
        global $expectedExecCommand;
        $execExecutions++;

        if($expectedExecCommand !== null){
            assertEquals($expectedExecCommand, $command);
        }
    }

    function mail($email, $subject, $message) {
        global $mailExecutions;
        global $expectedMailTo;
        global $expectedMailSubject;
        global $expectedMailBody;

        $mailExecutions++;

        if($expectedMailTo !== null){
            assertEquals($expectedMailTo, $email);
        }

        if($expectedMailSubject !== null) {
            assertEquals($expectedMailSubject, $subject);
        }

        if($expectedMailBody !== null){
            assertEquals($expectedMailBody, $message);
        }
    }
}


namespace Tests {
    class ExampleTest extends \PHPUnit\Framework\TestCase {

        public function setUp() : void {
            global $timestamp;
            global $dateExecutions;
            global $file_exists_returns;
            global $fileExistsExecutions;

            $timestamp = \time();
            $dateExecutions = 0;
            $file_exists_returns = [true];
            $fileExistsExecutions = 0;
        }
        public function test_monday_script_runs_as_expected_when_file_exists() {
            global $timestamp;
            global $file_exists_returns;
            global $fileExistsExecutions;

            $file_exists_returns = true;
            $timestamp = \strtotime('last Monday');

            
            $this->expectOutputString('Success');
            include( dirname(__DIR__) . '/scripts/legacyScript.php' );

            $this->assertEquals(5, $fileExistsExecutions);
        }
        
        public function test_monday_script_runs_as_expected_when_file_doesnt_initially_exist_but_downloads_successfully() {
            global $timestamp;
            global $file_exists_returns;
            global $fileExistsExecutions;
            global $execExecutions;

            $file_exists_returns = [false,true,true,true,true];
            $timestamp = \strtotime('last Monday');

            
            $this->expectOutputString('Success');
            include( dirname(__DIR__) . '/scripts/legacyScript.php' );

            $this->assertEquals(5, $fileExistsExecutions, "Number of times file_exists function was called.");
            $this->assertEquals(1, $execExecutions, "Number of times exec function was called.");
        }

        public function test_monday_script_runs_as_expected_when_file_doesnt_initially_exist_and_does_not_download() {
            global $timestamp;
            global $file_exists_returns;
            global $fileExistsExecutions;
            global $execExecutions;
            global $mailExecutions;
            global $expectedMailTo;
            global $expectedMailSubject;
            global $expectedMailBody;

            $expectedMailTo = 'me@email.com';
            $expectedMailSubject = 'File failed to download';
            $expectedMailBody = 'The file failed to download. You might need to download it manually.';

            $file_exists_returns = false;
            $timestamp = \strtotime('last Monday');

            include( dirname(__DIR__) . '/scripts/legacyScript.php' );

            $this->assertEquals(5, $fileExistsExecutions, "Number of times file_exists function was called.");
            $this->assertEquals(5, $execExecutions, "Number of times exec function was called.");
            $this->assertEquals(1, $mailExecutions, "Number of times mail function was called.");
        }

        public function test_friday_script_runs_as_expected_when_file_exists() {
            global $timestamp;
            global $file_exists_returns;
            global $fileExistsExecutions;

            $file_exists_returns = true;
            $timestamp = \strtotime('last Friday');

            
            $this->expectOutputString('SuccessSuccessSuccess');
            include( dirname(__DIR__) . '/scripts/legacyScript.php' );

            $this->assertEquals(15, $fileExistsExecutions);
        }
        
        public function test_friday_script_runs_as_expected_when_file_doesnt_initially_exist_but_downloads_successfully() {
            global $timestamp;
            global $file_exists_returns;
            global $fileExistsExecutions;
            global $execExecutions;

            $file_exists_returns = [false,true,true,true,true,true,true,true,true,true,true,true,true,true,true];
            $timestamp = \strtotime('last Friday');

            
            $this->expectOutputString('SuccessSuccessSuccess');
            include( dirname(__DIR__) . '/scripts/legacyScript.php' );

            $this->assertEquals(15, $fileExistsExecutions, "Number of times file_exists function was called.");
            $this->assertEquals(6, $execExecutions, "Number of times exec function was called.");
        }

        public function test_friday_script_runs_as_expected_when_file_doesnt_initially_exist_and_does_not_download() {
            global $timestamp;
            global $file_exists_returns;
            global $fileExistsExecutions;
            global $execExecutions;
            global $mailExecutions;
            global $expectedMailTo;
            global $expectedMailSubject;
            global $expectedMailBody;

            $expectedMailTo = 'me@email.com';
            $expectedMailSubject = 'File failed to download';
            $expectedMailBody = 'The file failed to download. You might need to download it manually.';

            $file_exists_returns = false;
            $timestamp = \strtotime('last Friday');

            include( dirname(__DIR__) . '/scripts/legacyScript.php' );

            $this->assertEquals(15, $fileExistsExecutions, "Number of times file_exists function was called.");
            $this->assertEquals(18, $execExecutions, "Number of times exec function was called.");
            $this->assertEquals(4, $mailExecutions, "Number of times mail function was called.");
        }


    }
}