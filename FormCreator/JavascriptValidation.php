<?php

include_once 'Validation.php';

/**
 * Description of JavascriptValidation
 * @author ferid Mövsümov
 */
class JavascriptValidation extends Validation {

    private $_formElementId;
    private static $_jsCode = "";
    protected $_mustBeChecked=false;

    public function getFormElementId() {
        return $this->_formElementId;
    }

    public function setFormElementId($formElementId) {
        $this->_formElementId = $formElementId;
    }

    public function getJavascriptValidationCode() {
        $jsCode = "";

        $jsCode.="<script type=text/javascript>

                 $(document).ready(function(){
                                     
                        $('#formId').submit(function() {
                        var warnings='';
                    
                            " . static::$_jsCode . "

                            if(warnings != '')
                            {
                                $('#warnings').html(warnings);
                                return false;
                            }
                        });                      
                });
                    
                 </script>";

        return $jsCode;
    }

    public function generateCode() {
        $jsCode = "";
        //mesajları yazdırmak lazım

        if ($this->_type == 'text' || $this->_type == 'textarea' || $this->_type == 'password') {
            if ($this->_required) {
                $jsCode.="
                        if($('#" . $this->_formElementId . "').val() == '')
                        {
                            warnings +='" . $this->_label . " değeri boş olamaz<br/>'; 
                        }

                    ";
            }
        }

        //max kontrolü
        if ($this->_type == 'text' || $this->_type == 'textarea' || $this->_type == 'password') {
            $jsCode.="
                        if($('#" . $this->_formElementId . "').val().length >" . $this->_maxLength . ")
                        {
                            warnings +='" . $this->_label . " büyüklüğü " . $this->_maxLength . " karakterden büyük olamaz<br/>';
                        }

                ";
        }


        if ($this->_type == 'text' || $this->_type == 'textarea' || $this->_type == 'password') {
            //min kontrolü
            $jsCode.="
                        if($('#" . $this->_formElementId . "').val().length <" . $this->_minLength . ")
                        {
                            warnings +='" . $this->_label . " en az " . $this->_minLength . " karakterden oluşmalıdır.<br/>';
                        }

                 ";
        }

        if ($this->_type == 'checkbox') {
            $jsCode.="
                        if(!$('#" . $this->_formElementId . "').is(':checked'))
                        {
                            warnings +='" . $this->_label . " tiklenmelidir!<br/>';
                        }
                 ";
        }

        static::$_jsCode.=$jsCode;
        return $jsCode;
    }

}

?>