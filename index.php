<html>
    <head>
    <title>Form.php Örnek Kullanım</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div align='center'>
<?php
include_once 'Form.php';

try {
    $form = new Form("index.php");
    $form->setFormAttributes(array('id' => 'ornekId'));
    $form->setTableAttributes(array("class"=>"table"));
    $form->addInput("text", "name", "İsim");
    $form->addInput("password", "pass", "Şifre");
    $form->addLabel("Cinsiyet:");
    $form->addRadioButton("cinsiyet", "erkek", "Erkek", array('br' => false));
    $form->addRadioButton("cinsiyet", "bayan", "Bayan");
    $form->addComboBox("Arabanızın Markası", array('mercedes' => 'Mercedes', 'bmw' => 'BMW'));
    $form->addTextArea(32, 5, "Adres");
    $form->addCheckBox("termofuse", "read", "Kullanmıcı Sözleşmesini okudum");
    $form->addInput("submit", "dugme", "Gönder");
    echo $form->show();
    
} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>
</div>
</body>
</html>