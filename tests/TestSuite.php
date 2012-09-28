<?php

require_once 'PhpValidationTest.php';
/**
 * Static test suite.
 */
class TestsSuite extends PHPUnit_Framework_TestSuite {

    /**
     * Constructs the test suite handler.
     */
    public function __construct() {
        $this->setName('TestsSuite');
        $this->addTestSuite('PhpValidationTest');

    }
    /**
     * Creates the suite.
     */
    public static function suite() {
        return new self ();
    }
    
    
    
}
?>