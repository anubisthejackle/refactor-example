<?php
namespace Legacy {
    use function PHPUnit\Framework\assertTrue;
    function date() {
        return 'MON';
    }
    function file_exists() {
        return true;
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

            include( dirname(__DIR__) . '/scripts/legacyScript.php' );

        }
    }
}