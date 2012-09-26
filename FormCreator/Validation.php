<?php
/**
 * Description of Validation
 * @author Ferid Mövsümov
 */
abstract class Validation {
    protected $_maxLength = 250;
    protected $_minLength = 0;
    protected $_required = false;
    protected $_label;
    protected $_type="";
    
    public function getType() {
        return $this->_type;
    }

    public function setType($type) {
        $this->_type = $type;
    }
        
    public function getMustBeChecked() {
        return $this->_mustBeChecked;
    }

    public function setMustBeChecked($mustBeChecked) {
        $this->_mustBeChecked = $mustBeChecked;
    }

        
    public function getLabel() {
        return $this->_label;
    }

    public function setLabel($label) {
        $this->_label = $label;
    }

        
    public function getMaxLength() {
        return $this->_maxLength;
    }

    public function setMaxLength($maxLength) {
        $this->_maxLength = $maxLength;
    }

    public function getMinLength() {
        return $this->_minLength;
    }

    public function setMinLength($minLength) {
        $this->_minLength = $minLength;
    }

    public function getRequired() {
        return $this->_required;
    }

    public function setRequired($required) {
        $this->_required = $required;
    }
    
}
?>