<?php

/**
 * Description of PhpValidation
 *
 * @author Ferid Mövsümov
 */
class PhpValidation {

    private $_message = "";
    private $_variable;
    private $_label;
    private $_isValid = true;
    private $_dataType;
    private $_allowedDataTypes = array("int", "string", "float");
    private static $_varNumber = 0;

    public function getAllowedDataTypes() {
        return $this->_allowedDataTypes;
    }

    /**
     * Meajları belli bir formatta basar alt alta 
     * @param strıng $message 
     */
    private function setMessage($message) {
        $this->_message.=$this->_label . " : " . $message . "<br/>";

        $this->_isValid = false;
    }

    /**
     * Değişken tipi ile değişkenin değerini karşılaştırı ve atanmaya uygun ise atama yapar
     * @param type $variable
     * @throws Exception 
     */
    private function setVariable($variable) {
        if (!empty($variable)) {
            if ($this->_dataType == "int") {
                if (is_numeric($variable)) {
                    $this->_variable = (int) $variable;
                } else {
                    throw new Exception("Veri türü int ancak değişken integer değil", 2);
                }
            }elseif ($this->_dataType == "float") {

                if (is_numeric($variable)) {
                    $this->_variable = (float) $variable;
                } else {
                    throw new Exception("Veri türü float olarak belirtilmesine rağmen veri sayısal değere sahip değil", 3);
                }
            }
            else//String ise
            {
                $this->_variable=$variable;
            }
        } else {
            throw new Exception("Variable can not be empty", 4);
        }
    }

    /**
     * Doğrulaması yapılacak değişken boş olmamalıdır.
     * @param type $variable
     * @throws Exception 
     */
    public function set($variable, $dataType = "string", $label = "") {
        $dataType = trim($dataType);


        //Label atamamışsa ben bir label atarım
        if (!empty($label)) {
            $this->_label = $label;
        } else {
            $this->_label = "var" . static::$_varNumber;
        }

        if (in_array($dataType, $this->_allowedDataTypes)) {
            $this->_dataType = $dataType;
        } else {
            throw new Exception("Belirtilen veri turu desteklenmiyor", 1);
        }

        $this->setVariable($variable);

        static::$_varNumber++;

        return $this;
    }

    public function isValid() {
        return $this->_isValid;
    }

    public function getMessage() {
        return $this->_message;
    }

    //DOĞRULAMALAR   

    /**
     * Sayısal değerler için kullanılır
     * @param type $maxValue 
     */
    public function setMaxValue($maxValue) {
        if ($this->_dataType == "int" || $this->_dataType == "float") {

            if ($this->_variable > $maxValue) {//şartımıza uymuyor
                $this->setMessage("deger $maxValue değerinden buyuk olamaz");
            }

            return $this;
        } else {
            throw new Exception("setMax fonksiyonu yalnızca int veya float veri tipi için kullanılabilir", 5);
        }
    }

    public function setMaxLength($maxLength) {
        if ($this->_dataType == "string") {

            if (is_numeric($maxLength) && intval($maxLength) > 0) {

                if (strlen($this->_variable) > $maxLength) {
                    $this->setMessage("String uzunluğu $maxLength degerinden buyuk olamaz");
                }
            } else {
                throw new Exception("setMaxLength metoduna parametre olarak pozitif bir tamsayı değeri verilmelidir.");
            }

            return $this;
        } else {
            throw new Exception("setMaxLength metodu yalnizca string degerler icin kullanilabilir", 6);
        }
    }

    public function setMinValue($minValue) {
        if ($this->_dataType == "int" || $this->_dataType == "float") {

            if ($this->_variable < $minValue) {//şartımıza uymuyor
                $this->setMessage("deger $minValue değerinden kucuk olamaz");
            }
            return $this;
        } else {
            throw new Exception("setMinValue metodu integer veya float degerler icin kullanilabilir", 7);
        }
    }

    public function setMinLength($minLength) {


        if ($this->_dataType == "string") {
            if (is_numeric($minLength) && intval($minLength) > 0) {
                
                if (strlen($this->_variable) < $minLength) {
                    $this->setMessage("String uzunluğu $minLength degerinden kucuk olamaz");
                }
                return $this;
                
            } else {
                throw new Exception("setMinLength metoduna parametre olarak pozitif bir tamsayı değeri verilmelidir.");
            }
        } else {
            throw new Exception("setMinLength metodu yalnizca string degerler icin kullanilabilir", 8);
        }
    }

}

?>