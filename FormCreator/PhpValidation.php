<?php

/**
 * Değişkenler için doğrulama kuralları belirlememizi sağlayan sınıf
 * Değişkenlerimiz kurala uyuyor mu diye kontrol edebilir 
 * Uymayanların neden uymadığına dair mesajlar basabiliriz.
 * @author Ferid Mövsümov
 */
class PhpValidation {

    //Hata mesajları bu arrayde tutulur
    private $_messagesArray = array();
    private $_variable;//Kullanıcı tarafından gönderilen değişken
    //Değişkenin ismidir. Uyarı mesajları basılırken bu isim kullanılır.
    //İsim atanmazsa sırasıyla var1, var2 şeklinde isimler atanır.
    private $_label;
    private $_isValid = true;
    private $_dataType;
    private $_allowedDataTypes = array("int", "string", "float");
    private static $_varNumber = 0; //Label atanmazsa var+varNumber şeklinde kullanılır

    public function getAllowedDataTypes() {
        return $this->_allowedDataTypes;
    }

    /**
     * Meajları belli bir formatta basar alt alta 
     * @param strıng $message 
     */
    private function addMessage($message) {
        $this->_messagesArray[] = $this->_label . " : " . $message;
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

    public function getMessages() {
        return $this->_messagesArray;
    }

    //DOĞRULAMALAR   

    /**
     * Sayısal değerler için kullanılır
     * @param type $maxValue 
     */
    public function setMaxValue($maxValue) {
        if ($this->_dataType == "int" || $this->_dataType == "float") {

            if ($this->_variable > $maxValue) {//şartımıza uymuyor
                $this->addMessage("deger $maxValue değerinden buyuk olamaz");
            }

            return $this;
        } else {
            throw new Exception("setMax fonksiyonu yalnızca int veya float veri tipi için kullanılabilir", 5);
        }
    }

    /**
     * Maximum string uzunluğu belirlemek için kullanılabilir. 
     * Ayrıca integer değerler için kullanıldığında maksimum 
     * basamak sayısını belirtmek içim kullanılabilir.
     * @param type $maxLength
     * @return \PhpValidation
     * @throws Exception 
     */
    public function setMaxLength($maxLength) {
        if ($this->_dataType == "string") {
            
                
            if (strlen($this->_variable) > $maxLength) {
                $this->addMessage("String uzunluğu $maxLength degerinden buyuk olamaz");
            }
            return $this;
                
            
        } elseif($this->_dataType == "int") {
            $this->_variable=(string) $this->_variable;
            
            if (strlen($this->_variable) > $maxLength) {
                $this->addMessage("String uzunluğu $maxLength degerinden buyuk olamaz");
            }
            
            $this->_variable=(int) $this->_variable;
            
            return $this;
            
            
        }
        else {
            throw new Exception("setMaxLength integer veya float icin kullanilabilir",6);
        }
    }

    /**
     * Yalnızca integer değerler için kullanılabilecek bir metoddur.
     * @param type $minValue
     * @return \PhpValidation
     * @throws Exception 
     */
    public function setMinValue($minValue) {
        if ($this->_dataType == "int" || $this->_dataType == "float") {

            if ($this->_variable < $minValue) {//şartımıza uymuyor
                $this->addMessage("deger $minValue değerinden kucuk olamaz");
            }
            return $this;
        } else {
            throw new Exception("setMinValue metodu integer veya float degerler icin kullanilabilir", 7);
        }
    }

    /**
     * integer değerler için minimum basamak sayısını string değerler için ise 
     * min length degerini belirtir.
     * @param type $minLength
     * @return \PhpValidation
     * @throws Exception 
     */
    public function setMinLength($minLength) {


        if ($this->_dataType == "string") {
            
                
            if (strlen($this->_variable) < $minLength) {
                $this->addMessage("String uzunluğu $minLength degerinden kucuk olamaz");
            }
            return $this;
                
            
        } elseif($this->_dataType == "int") {
            $this->_variable=(string) $this->_variable;
            
            if (strlen($this->_variable) < $minLength) {
                $this->addMessage("String uzunluğu $minLength degerinden kucuk olamaz");
            }
            
            $this->_variable=(int) $this->_variable;
            
            return $this;
            
            
        }
        else {
            throw new Exception("setMinLength integer veya float icin kullanilabilir",8);
        }
    }
    
    /**
     * Girilen string değeri integer mi diye kontrol yapar
     * @return \PhpValidation
     * @throws Exception 
     */
    public function isEmail()
    {
        if ($this->_dataType == "string") {
            
            if(!filter_var($this->_variable, FILTER_VALIDATE_EMAIL)){
                $this->addMessage("Email dogru formatta girilmemis");
            }
            
            return $this;
        }
        else {
            throw new Exception("isEmail metodu yalnızca string degerleri icin kullanilabilkir");
        }
    }
}

?>