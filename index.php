<html>
    <head>
    <title>Form.php Örnek Kullanım</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/validation.js"></script>
</head>
<body>
<div align='center'>
<?php
include_once 'FormCreator/Form.php';
//FormHelper ile amele işlerin yaptırılacağı bir class yazılabilir.

try {
    $form = new Form("test.php");
    $form->setFormAttributes(array('id' => 'formId'));
    $form->setTableAttributes(array("class"=>"table"));
    $form->addInput("text", "name", "Email")->setValidation(array("required"=>true,"min"=>3));
    $form->addInput("password", "pass", "Şifre")->setValidation(array("required"=>true,"min"=>8));
    $form->addInput("text", "yas","Yaş");
    $form->addLabel("Cinsiyet:");
    $form->addRadioButton("cinsiyet", "erkek", "Erkek",array("checked"=>"checked"));
    $form->addRadioButton("cinsiyet", "bayan", "Bayan");
    $form->addComboBox("carbrand","Arabanızın Markası", array('mercedes' => 'Mercedes', 'bmw' => 'BMW'));
    //$form->addTextArea(32, 5, "adres","Adres");
    //$form->addCheckBox("termofuse", "read", "Kullanmıcı Sözleşmesini okudum")->setValidation(array("mustBeChecked"=>true));
    $form->addTermsOfUse("files/file.txt",true);
    $form->addInput("submit", "dugme", "Kaydet");
    
    echo $form->show();
} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>
</div>
</body>
</html>