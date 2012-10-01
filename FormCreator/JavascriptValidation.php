<?php

include_once 'Validation.php';

/**
 * Description of JavascriptValidation
 * @author ferid Mövsümov
 */
class JavascriptValidation extends Validation {

    private $_formElementId;
    private static $_jsCode = "";
    private static $_extraJSCode="";
    protected $_mustBeChecked = false;

    public function getFormElementId() {
        return $this->_formElementId;
    }

    public function setFormElementId($formElementId) {
        $this->_formElementId = $formElementId;
    }

    /**
     * generateCode metodunda üretilen kodları ve eğer varsa kullanıcı sözleşmesine ait javascript
     * kontrollerinin kodlarını belli bir düzende oluşturur.
     * @return \strıng 
     */
    public function getJavascriptValidationCode() {
        $jsCode = "";

        $jsCode.="<script type=text/javascript>

                 $(document).ready(function(){
                        var warnings='';             
                        $('#formId').submit(function() {
                        
                        warnings='';
                    
                            " . static::$_jsCode . "

                            if(warnings != '')
                            {
                                $('#warnings').html(warnings);
                                return false;
                            }
                        });
                            
                        ".static::$_extraJSCode."

                });                   
                 </script>";

        return $jsCode;
    }

    /**
     * Javascript kodlarının üretildiği metoddur
     * @return \strıng 
     */
    public function generateCode() {
        $jsCode = "";
        //mesajları yazdırmak lazım

        //Required kontrolu
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

    /**
     * Kullanıcı sözleşmesi için javascript kontrolleri oluşturur
     * scroll textareanın en sonuna geldiğinde checkbox görünür vaziyete getirilir
     * checkbox cliklenmedikçe submit butonu aktif olmaz.
     */
    public function addTermsOfUseReadControl() {
        $jsCode = "";

        //Kullanıcı sözleşmesinin en altına gelindiği zaman checkbox görünür yapılır
        $jsCode =
        "
                    $('input[type=submit]').attr('disabled','disabled');


                    $('#touCheckBox').change(function() {
                        
                        if($('#touCheckBox').is(':checked'))
                        {
                            $('input[type=submit]').removeAttr('disabled');
                        }
                        else
                        {
                            $('input[type=submit]').attr('disabled','disabled');
                        }
                        
                        
                    });

                    if(warnings=='')
                    {
                        $('#kullanicisozlesmesi').hide();
                    }

                    $('#touContent').scroll(function() {
        
                         if($('#touContent').scrollTop() == 2448)
                         {
                             $('#kullanicisozlesmesi').fadeIn('slow');
                         }
                    });
        ";

        static::$_extraJSCode.=$jsCode;
    }

}

?>