<?php

/**
 * Amac kolay ve hizli bir sekilde form olusturulabimesini saglamak.
 * @author Ferid Movsumov
 */
class Form {

    private $_action;
    private $_method;
    private $_name;
    private $_accept;
    private $_enctype;
    private $_id;
    private $_class;

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

    public function getName() {
        return $this->_name;
    }

    public function setName($name) {
        $this->_name = $name;
    }

    public function getAccept() {
        return $this->_accept;
    }

    public function setAccept($accept) {
        $this->_accept = $accept;
    }

    public function getEnctype() {
        return $this->_enctype;
    }

    public function setEnctype($enctype) {
        $this->_enctype = $enctype;
    }

    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function getClass() {
        return $this->_class;
    }

    public function setClass($class) {
        $this->_class = $class;
    }

    /**
     * Bir formda action url kesinlikle belirtilmelidir.
     * @param type $actionUrl required.
     * @param type $method optional
     * @param type $name optional
     */
    public function __construct($actionUrl, $method = "POST", $name = "form1") {
        $this->setAction($actionUrl);
        $this->setMethod($method);
        $this->_name = $name;
    }

    /**
     * Oluuşturduğumuz formu geri döndürür.
     *  
     */
    public function show() {
        $result = "";

        $formAttributes = $this->getSettedAttributes();

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

        if (isset($this->_name)) {
            $result.="name='$this->_name' ";
        }
        
        if (isset($this->_class)) {
            $result.="class='$this->_class' ";
        }
              
        if (isset($this->_accept)) {
            $result.="accept='$this->_accept' ";
        }
        
        if (isset($this->_enctype)) {
            $result.="enctype='$this->_enctype' ";
        }
        
        if (isset($this->_id)) {
            $result.="id='$this->_id' ";
        }
        
        return $result;
    }
    
    

}

?>