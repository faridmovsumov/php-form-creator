<?php

/**
 * Amac kolay ve hizli bir sekilde form olusturulabimesini saglamak.
 * @author Ferid Movsumov
 */
class Form {

    private $_action;
    private $_method;
    private $_additionalParams;
    private $_formElementsArray;
    private $_tableAttributes = "";

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
    public function show($tableParams = array()) {
        $result = "";

        $formAttributes = $this->getSettedAttributes();

        if (isset($this->_additionalParams)) {
            $formAttributes.=$this->_additionalParams;
        }

        $result.="<table $this->_tableAttributes >\n";

        $result.="<form $formAttributes>\n";

        if (isset($this->_formElementsArray)) {
            foreach ($this->_formElementsArray as $formElement) {
                $result.="<tr>" . $formElement . "</tr>\n";
            }
        }

        $result.="</form>\n";
        $result.="</table>\n";
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
    public function setFormAttributes($params) {
        $result = " ";
        foreach ($params as $key => $value) {
            $result.=$key . "='" . $value . "' ";
        }

        $this->_additionalParams = $result;
    }

    /**
     * $label: <input type='$type' name='$name' /> şeklinde bir form elemanı oluşturmak için kullanılır.
     * @param type $type input için type parametresi belirtmek zorunludur. 
     * password, text veya submit olabilir
     * @param type $name
     * Form elemanına atayacağınız isimdir.
     * @param type $label
     * Form elemanının labelidir.
     * @param type $additionalParams
     * eklemek istediğiniz ek parametreleri key value çiftleri şeklinde
     * parametre olarak vermeniz gerekiyor. Ek attribute vermek istemiyorsanız boş bırakınız
     * @throws Exception 
     */
    public function addInput($type, $name, $label = "", $additionalParams = array()) {

        $result = "";

        if ($label != "" && $type != "submit") {
            $label.=": ";
            $label = "<td>" . $label . "</td>";
            $colspan = "";
        } else { //Button ise
            $additionalParams["value"] = $label;
            $label = "";
            $colspan = "colspan='2' align='right'";
        }

        $result.="$label <td $colspan ><input ";

        if (isset($type)) {
            $result.="type='" . $type . "' ";
        } else {
            throw new Exception("Input için type parametresi tanımlamalısınız!");
        }

        if (isset($name)) {
            $result.="name='" . $name . "' ";
        } else {
            throw new Exception("Input için name parametresi tanımlamalısınız!");
        }

        foreach ($additionalParams as $key => $value) {
            $result.=$key . "='" . $value . "' ";
        }

        $result.=" /></td><br />\n";

        $this->_formElementsArray[] = $result;
    }

    /**
     * textarea oluşturmak için kullanılır. 
     * cols ve rows değerlerini tırnaksız bir şekilde direk integer...
     * olarak vermeye dikkat ediniz.
     * @param type integer
     * @param type integer
     * @param type $label
     * @param type $optionalAttributes 
     */
    public function addTextArea($cols, $rows, $label, $optionalAttributes = array()) {
        $result = "";
        $attributes = "";

        if (is_integer($cols)) {
            $attributes.="cols='" . $cols . "' ";
        }
        else
        {
            $attributes.="cols='25' ";
        }

        if (is_integer($rows)) {
            $attributes.="rows='" . $rows . "' ";
        }
        else
        {
            $attributes.="rows='5' ";
        }
        
        foreach ($optionalAttributes as $key => $value)
        {
            $attributes.=$key."='".$value."'";
        }

        $result.="<td colspan='2' >$label:<br/><textarea $attributes >";
        $result.="</textarea></td>";

        $this->_formElementsArray[] = $result;
    }

    public function setTableAttributes($attributes = array()) {
        $result = "";
        foreach ($attributes as $key => $value) {
            $result.="$key='" . $value . "' ";
        }

        $this->_tableAttributes = $result;
    }
    
    /**
     *
     * @param type $name
     * @param type $value
     * @param type $label
     * @param type $additionalParams 
     */
    public function addCheckBox($name,$value,$label,$additionalParams=array())
    {
        //Kullanıcıdan alınan parametreleri ekliyoruz
        if(isset($name) && !empty($name) && isset($value) && !empty($value))
        $attributes=array(
            'type'=>'checkbox',
            'name'=>$name,
            'value'=>$value,
        );

        //ek parametreleri ekliyoruz
        foreach ($additionalParams as $attributeName=>$attributeValue)
        {
            $attributes[$attributeName]=$attributeValue;
        }
        
        $attributesString="";
        //Butun parametreleri tek bir string haline dönüştüreceğiz.
        foreach ($attributes as $attributeKey=>$val)
        {
            $attributesString.=$attributeKey."='".$val."' ";
        }
        
        $result="<td colspan='2' ><input $attributesString /> $label <br /></td>";
        
        $this->_formElementsArray[]=$result;
    }
    
    public function addRadioButton($name,$value,$label,$additionalParams=array())
    {
        //Kullanıcıdan alınan parametreleri ekliyoruz
        if(isset($name) && !empty($name) && isset($value) && !empty($value))
        $attributes=array(
            'type'=>'radio',
            'name'=>$name,
            'value'=>$value,
        );
        
        //ek parametreleri ekliyoruz
        foreach ($additionalParams as $attributeName=>$attributeValue)
        {
            $attributes[$attributeName]=$attributeValue;
        }
        
        
        
        $attributesString="";
        //Butun parametreleri tek bir string haline dönüştüreceğiz.
        foreach ($attributes as $attributeKey=>$val)
        {
            $attributesString.=$attributeKey."='".$val."' ";
        }
        
        $result="<td colspan='2' ><input $attributesString /> $label <br/></td>";
        
        $this->_formElementsArray[]=$result;
    }
    
    public function addLabel($text)
    {
        $result="<td colspan='2' >$text<br/></td>";
        
        $this->_formElementsArray[]=$result;
    }
    
}
?>