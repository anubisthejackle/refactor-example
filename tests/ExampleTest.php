<?php
namespace Legacy {
    use function PHPUnit\Framework\assertTrue;
    function date() {
        return 'MON';
    }

    $fileExistsReturnValue = true;

    function file_exists() {
        global $fileExistsReturnValue;

        return $fileExistsReturnValue;
    }
    function exec() {}
    function mail() {
        assertTrue(true);
    }
}

namespace Tests {
    class ExampleTest extends \PHPUnit\Framework\TestCase {
        public function test_monday_script_runs_as_expected_when_file_exists() {

            $this->expectOutputString('Success');
            include( dirname(__DIR__) . '/scripts/legacyScript.php' );

        }

        public function test_monday_script_runs_as_expected_when_file_does_not_exist() {
            global $fileExistsReturnValue;
            $fileExistsReturnValue = false;
            include( dirname(__DIR__) . '/scripts/legacyScript.php' );

        }

        public function test_monday_script_runs_as_expected_when_file_does_not_exist_but_does_download() {
            global $fileExistsReturnValue;
            $fileExistsReturnValue = false;
            include( dirname(__DIR__) . '/scripts/legacyScript.php' );
            $this->expectOutputString('Success');

        }
    }
}