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

    public function setMethod($method) {
        $method=  strtoupper($method);
        
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

    public function getİd() {
        return $this->_id;
    }

    public function setİd($id) {
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
        $this->_method = $method;
        $this->_name = $name;
    }

    /**
     * Oluuşturduğumuz formu geri döndürür. 
     */
    public function show() {
        $result = "";
        $result.="<form action='$this->_action'>";
        $result.="</form>";

        return $result;
    }

}

?>