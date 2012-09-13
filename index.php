<html>
    <head>
    <title>Form.php Örnek Kullanım</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
</head>
<body>
    <?php
    include_once 'Form.php';

    try {
        $form = new Form("index.php");
        $form->setFormAttributes(array('id' => 'ornekId'));
        $form->setTableAttributes(array("cellspacing" => "2", "cellpadding" => "1"));
        $form->addInput("text", "name", "İsim");
        $form->addInput("password", "pass", "Şifre");
        $form->addLabel("Cinsiyet:");
        $form->addRadioButton("cinsiyet", "erkek", "Erkek",array('br'=>false));
        $form->addRadioButton("cinsiyet", "bayan", "Bayan");
        $form->addTextArea(25, 5, "Adres");
        $form->addCheckBox("termofuse", "read", "Kullanmıcı Sözleşmesini okudum");
        $form->addInput("submit", "dugme", "Gönder");
        echo $form->show();
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
    ?>
</body>
</html>