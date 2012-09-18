<?php
include_once 'Validation.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PhpValidation
 *
 * @author Ferid Mövsümov
 */
class PhpValidation extends Validation {
    private $_formElementName;
    
    public function getFormElementName() {
        return $this->_formElementName;
    }

    public function setFormElementName($formElementName) {
        $this->_formElementName = $formElementName;
    }

        
    public function generateCode() {
        
    }

}

?>
