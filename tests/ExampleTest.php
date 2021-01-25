<?php
namespace Legacy {
    use function PHPUnit\Framework\assertTrue;

    $dateReturnValue = 'MON';

    function date() {
        global $dateReturnValue;
        return $dateReturnValue;
    }

    $fileExistsReturnValue = true;

    function file_exists() {
        global $fileExistsReturnValue;

        if(is_array($fileExistsReturnValue)){
            return array_shift($fileExistsReturnValue);
        }

        return $fileExistsReturnValue;
    }

    function exec() {}

    $mailCounter = 0;
    function mail() {
        global $mailCounter;
        $mailCounter++;
    }
}

namespace Tests {
    class ExampleTest extends \PHPUnit\Framework\TestCase {
        public function setUp() : void {
            global $fileExistsReturnValue;
            global $dateReturnValue;
            global $mailCounter;

            $mailCounter = 0;
            $fileExistsReturnValue = true;
            $dateReturnValue = 'MON';
        }
        public function test_monday_script_runs_as_expected_when_file_exists() {

            $this->expectOutputString('Success');
            include( dirname(__DIR__) . '/scripts/legacyScript.php' );

        }

        public function test_monday_script_runs_as_expected_when_file_does_not_exist() {
            global $fileExistsReturnValue;
            global $mailCounter;

            $fileExistsReturnValue = false;
            include( dirname(__DIR__) . '/scripts/legacyScript.php' );
            $this->assertEquals(1, $mailCounter);
        }

        public function test_monday_script_runs_as_expected_when_file_does_not_exist_but_does_download() {
            global $fileExistsReturnValue;
            $fileExistsReturnValue = [false,true,true,true,true];
            include( dirname(__DIR__) . '/scripts/legacyScript.php' );
            $this->expectOutputString('Success');

        }

        public function test_friday_script_runs_as_expected_when_file_exists() {
            global $dateReturnValue;
            $dateReturnValue = 'FRI';
            $this->expectOutputString('SuccessSuccessSuccess');
            include( dirname(__DIR__) . '/scripts/legacyScript.php' );
        }

        public function test_friday_script_runs_as_expected_when_file_does_not_exist() {
            global $fileExistsReturnValue;
            global $dateReturnValue;
            global $mailCounter;
            $dateReturnValue = 'FRI';
            $fileExistsReturnValue = false;
            
            include( dirname(__DIR__) . '/scripts/legacyScript.php' );
            $this->assertEquals(3, $mailCounter);
        }
    }
}