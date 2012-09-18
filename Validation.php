<?php
/**
 * Description of Validation
 *
 * @author Ferid Mövsümov
 */
abstract class Validation {
    protected $_maxLength = 50;
    protected $_minLength = 1;
    protected $_required = false;
    protected $_label;
    protected $_mustBeChecked=false;
    
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
    
    public abstract function generateCode();
}
?>
