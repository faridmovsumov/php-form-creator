<?php

/**
 * Amac kolay ve hizli bir sekilde form olusturulabimesini saglamak.
 * @author Ferid Movsumov
 */
class Form {

    private $_action;
    private $_method;
    private $_additionalParams;

    public function getAction() {
        return $this->_action;
    }

    /**
     * İlgili dosyanın var olup olmadığını kontrol eder. 
     * Eğer varsa set eder.
     * @param type $action
     * @throws Exception 
     */
    private function setAction($action) {
        if (file_exists(__DIR__ . "/" . $action)) {
            $this->_action = $action;
        } else {
            throw new Exception(__DIR__ . "/" . $action . " isimli dosya mevcut değil");
        }
    }

    public function getMethod() {
        return $this->_method;
    }

    /**
     * Method ya POST ya da GET olabilir
     * gelen stringe toupper fonksiyonu uygulanıyor.
     * @param type $method
     * @throws Exception 
     */
    public function setMethod($method) {
        $method = strtoupper($method);

        if ($method == "POST" || $method == "GET") {
            $this->_method = $method;
        } else {
            throw new Exception("Form method $method olamaz get veya post kullanmayı deneyin!");
        }
    }

    /**
     * Bir formda action url kesinlikle belirtilmelidir.
     * @param type $actionUrl required.
     * @param type $method optional
     * @param type $name optional
     */
    public function __construct($actionUrl, $method = "POST") {
        $this->setAction($actionUrl);
        $this->setMethod($method);
    }

    /**
     * Oluuşturduğumuz formu geri döndürür.
     *  
     */
    public function show() {
        $result = "";

        $formAttributes = $this->getSettedAttributes();
    
        if (isset($this->_additionalParams)) {
            $formAttributes.=$this->_additionalParams;
        }

        $result.="<form $formAttributes>";
        $result.="\n</form>";
        return $result;
    }

    /**
     * Set edilmiş form attributlarını döndürür birleşik bir string şeklinde
     * @return type 
     */
    public function getSettedAttributes() {
        $result = " ";

        if (isset($this->_action)) {
            $result.="action='$this->_action' ";
        }

        if (isset($this->_method)) {
            $result.="method='$this->_method' ";
        }

        return $result;
    }

    /**
     * Ek parametreler için kullanılır
     * Çok sık ihtiyaç duyulmayan parametreler,
     * array olarak key value şeklinde buraya gönderilecek
     * @param type $params
     * @return \strıng 
     */
    public function setAdditionalParams($params) {
        $result = " ";
        foreach ($params as $key => $value) {
            $result.=$key . "='" . $value . "' ";
        }

        $this->_additionalParams = $result;
    }

}

?>