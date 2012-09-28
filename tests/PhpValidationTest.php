<?php

require_once '../FormCreator/PhpValidation.php';

/**
 * Description of PhpValidationTest
 *
 * @author Fe3rid Mövsümov
 */
class PhpValidationTest extends PHPUnit_Framework_TestCase {

    protected $_phpValidation;

    /**
     * Öncelikle nesnemizi oluşturuyoruz 
     */
    public function setUp() {
        $this->_phpValidation = new PhpValidation();
    }

    /**
     * işimiz bittikten sonra memoryde yer kaplamaması
     *  için nesnemizi unset ediyoruz 
     */
    public function tearDown() {
        unset($this->_phpValidation);
    }
    
    
    /**
     * getAllowedDataTypes metodunu test ediyoruz 
     */
    public function testGetAllowedDataTypes() {
        $this->assertContainsOnly('string', $this->_phpValidation->getAllowedDataTypes());
    }
    
    /**
     * set metodunu çeşitli setler yaparak test ediyoruz 
     */
    public function testSet() { 
        $this->assertInstanceOf('PhpValidation', $this->_phpValidation->set("Deneme"));
        $this->assertInstanceOf('PhpValidation', $this->_phpValidation->set("Deneme","string"));
        $this->assertInstanceOf('PhpValidation', $this->_phpValidation->set("Denem123","string"));
        $this->assertInstanceOf('PhpValidation', $this->_phpValidation->set(10, "int", "Rakam"));
        $this->assertInstanceOf('PhpValidation', $this->_phpValidation->set(-10, "int", "Rakam"));
    }

   
    /**
     * @dataProvider providerMaxValue
     * @covers PhpValidation::setMaxValue
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
            array(-1, 5),
            array(-10, 0)
        );
    }
    

    /**
     * @dataProvider providerSetMaxLength 
     */
    public function testSetMaxLength($value,$maxLength) {
        $this->assertTrue($this->_phpValidation->set($value, "string")->setMaxLength($maxLength)->isValid());
    }
    
    
    public function providerSetMaxLength()
    {
        return array(
            array("selam", 6),
            array("selam", 10),
            array("ssssssssssss", 20),
            array("denemem", 30)
        );
    }
    
    
    /**
     * @dataProvider providerSetMinValue
     * @param type $value
     * @param type $minValue 
     */
    public function testSetMinValue($value, $minValue) {
         $this->assertTrue($this->_phpValidation->set($value, "int")->setMinValue($minValue)->isValid());
    }
    
    public function providerSetMinValue()
    {
        return array(
            array(2,1),
            array(3,2),
            array(-1,-3)
        );
    }

    
    /**
     * @dataProvider providerMinLength
     * @param type $value
     * @param type $maxValue 
     */
    public function testMinLength($value, $minLength) {
        $this->assertTrue($this->_phpValidation->set($value, "string")->setMinLength($minLength)->isValid());
    }

    /**
     * MinLength fonksiyonu için bazı degerler atayarak denemeler yapiyorum
     * @return type 
     */
    public function providerMinLength() {
        return array(
            array("selam", 2),
            array("selam", 3),
            array("ssssssssssss", 6),
            array("denemem", 7)
        );
    }
    
    
    

    /**
     * @covers PhpValidation::isEmail
     * @covers PhpValidation::set
     * @covers PhpValidation::isValid
     * @dataProvider providerIsEmail
     * @param type $email 
     */
    public function testIsEmail($email) {
        $this->assertTrue($this->_phpValidation->set($email, "string")->isEmail()->isValid());
    }
    
    public function providerIsEmail() {
        return array(
            array("farid@gmail.com"),
            array("faridm88@hotmail.com")
        );
    }
    
    
    //EXCEPTION KONTROLU
    
    /**
     * Eğer desteklenmeyen bir type yazılırsa 1 numaralı exception fırlatılmalıdır
     * @expectedException  Exception
     * @expectedExceptionCode 1
     */
    public function testExceptionHasErrorcode1() {
        $this->_phpValidation->set("deneme", "inf");
    }

    /**
     * Eğer tipi int olarak belirtildiği halde a5 gibi sayısal olmayan
     * bir değer atanmışsa exception #2 fırlatılır
     * @expectedException  Exception
     * @expectedExceptionCode 2
     */
    public function testExceptionHasErrorcode2() {
        $this->_phpValidation->set("a5", "int");
    }

    /**
     * Eğer tipi float belirtildiği yhalde sayısal olmayan birşey verilmişse
     * @expectedException  Exception
     * @expectedExceptionCode 3
     */
    public function testExceptionHasErrorcode3() {
        $this->_phpValidation->set("deneme", "float");
    }

    /**
     * Eğer empty bir değer girilirse
     * @expectedException  Exception
     * @expectedExceptionCode 4
     */
    public function testExceptionHasErrorcode4() {
        $this->_phpValidation->set("", "int");
        $this->_phpValidation->set(" \n  ", "string");
        $this->_phpValidation->set("   ", "string");
    }

    //Validation ile ilgili metodların exceptionlarını test ediyoruz..

    /**
     * Set max value sadece integer değerler için çalışır
     * @expectedException  Exception
     * @expectedExceptionCode 5
     */
    public function testExceptionHasErrorcode5() {
        $this->_phpValidation->set("deneme", "string")->setMaxValue(5);
    }

    /**
     * Sayısal bir değer için setMaxLength kullanılırsa exception fırlatılır
     * @expectedException  Exception
     * @expectedExceptionCode 6
     */
    public function testExceptionHasErrorcode6() {
        $this->_phpValidation->set("1.5", "float")->setMaxLength(5);
    }

    /**
     * String bir değer için setMinValue kullanılırsa exception fırlatılır
     * @expectedException  Exception
     * @expectedExceptionCode 7
     */
    public function testExceptionHasErrorcode7() {
        $this->_phpValidation->set("deneme", "string")->setMinValue(5);
    }

    /**
     * Sayısal bir değer için setMinLength kullanılırsa Exception fırlatılır
     * @expectedException  Exception
     * @expectedExceptionCode 8
     */
    public function testExceptionHasErrorcode8() {
        $this->_phpValidation->set("6", "int")->setMinLength(5);
    }
}

?>
