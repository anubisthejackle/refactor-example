<?php
namespace Legacy {
    function date() {
        return 'MON';
    }
    function file_exists() {
        return true;
    }
    function exec() {}
    function mail() {}
}

namespace Tests {
    class ExampleTest extends \PHPUnit\Framework\TestCase {
        public function test_monday_script_runs_as_expected_when_file_exists() {

            $this->expectOutputString('Success');
            include( dirname(__DIR__) . '/scripts/legacyScript.php' );

        }
    }
}