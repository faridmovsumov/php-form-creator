<?php

require_once '../FormCreator/PhpValidation.php';

/**
 * Description of PhpValidationTest
 *
 * @author Ferid Movsumov
 */
class PhpValidationTest extends PHPUnit_Framework_TestCase {

    protected $_phpValidation;

    public function setUp() {
        $this->_phpValidation = new PhpValidation();
    }

    /**
     * @expectedException  Exception
     * @expectedExceptionCode 1
     */
    public function testExceptionHasErrorcode1() {
        $this->_phpValidation->set("deneme", "inf");
    }

    /**
     * @expectedException  Exception
     * @expectedExceptionCode 2
     */
    public function testExceptionHasErrorcode2() {
        $this->_phpValidation->set("a5", "int");
    }

    /**
     * @expectedException  Exception
     * @expectedExceptionCode 3
     */
    public function testExceptionHasErrorcode3() {
        $this->_phpValidation->set("deneme", "float");
    }

    /**
     * @expectedException  Exception
     * @expectedExceptionCode 4
     */
    public function testExceptionHasErrorcode4() {
        $this->_phpValidation->set("", "int");
        $this->_phpValidation->set("   ", "int");
    }

    //Validation ile ilgili metodların exceptionlarını test ediyoruz..

    /**
     * @expectedException  Exception
     * @expectedExceptionCode 5
     */
    public function testExceptionHasErrorcode5() {
        $this->_phpValidation->set("deneme", "string")->setMaxValue(5);
    }

    /**
     * @expectedException  Exception
     * @expectedExceptionCode 6
     */
    public function testExceptionHasErrorcode6() {
        $this->_phpValidation->set("1.5", "float")->setMaxLength(5);
    }

    /**
     * @expectedException  Exception
     * @expectedExceptionCode 7
     */
    public function testExceptionHasErrorcode7() {
        $this->_phpValidation->set("deneme", "string")->setMinValue(5);
    }

    /**
     * @expectedException  Exception
     * @expectedExceptionCode 8
     */
    public function testExceptionHasErrorcode8() {
        $this->_phpValidation->set("6", "int")->setMinLength(5);
    }

    /**
     * Allowed Data types sadece string degerleri dondurur
     */
    public function testGetAllowedDataTypes() {
        $this->assertContainsOnly('string', $this->_phpValidation->getAllowedDataTypes());
    }

    /**
     * Aşağıda kullanılmış olan metodlarin gercekten o sinifa ait bir nesne dondurdugunu test eder
     */
    public function testReturnThis() {
        $this->assertInstanceOf('PhpValidation', $this->_phpValidation->set("Deneme"));
        $this->assertInstanceOf('PhpValidation', $this->_phpValidation->set("Deneme")->setMaxLength(5));
        $this->assertInstanceOf('PhpValidation', $this->_phpValidation->set("Deneme")->setMinLength(5));
        $this->assertInstanceOf('PhpValidation', $this->_phpValidation->set(10, "int", "Rakam")->setMinValue(5));
        $this->assertInstanceOf('PhpValidation', $this->_phpValidation->set(10, "int", "Rakam")->setMaxValue(5));
    }

    /**
     * Her bir metodu birer kez test ederek isValid doğru çalışıyor mu test etmiş olacağım
     */
    public function testisValid() {
        $this->_phpValidation->set(5, "int")->setMaxValue(30);
        $this->_phpValidation->set(5, "int")->setMinValue(1);
        $this->_phpValidation->set("Deneme", "string")->setMinLength(1);
        $this->_phpValidation->set("Deneme", "string")->setMaxLength(10);

        $this->assertTrue($this->_phpValidation->isValid());
    }

   
    /**
     * @dataProvider providerMaxValue
     */
    public function testMaxValue($value, $maxValue) {
        $this->assertTrue($this->_phpValidation->set($value, "int")->setMaxValue($maxValue)->isValid());
    }
    
    /**
     * MaxValue fonksiyonu için bazı degerler atayarak denemeler yapiyorum
     * @return type 
     */
    public function providerMaxValue() {
        return array(
            array(1, 5),
            array(1, 6),
            array(-1,5),
            array(-10,0)
        );
    }
    
    
    /**
     * @dataProvider providerMinLength
     * @param type $value
     * @param type $maxValue 
     */
    public function testMinLength($value,$maxValue)
    {
        $this->assertTrue($this->_phpValidation->set($value, "string")->setMinLength($maxValue)->isValid());
    }
    
    
    /**
     * MaxValue fonksiyonu için bazı degerler atayarak denemeler yapiyorum
     * @return type 
     */
    public function providerMinLength() {
        return array(
            array("selam", 2),
            array("selam", 3),
            array("ssssssssssss",6),
            array("denemem",7)
        );
    }
}

?>