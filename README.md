[![endorse](http://api.coderwall.com/feridmovsumov/endorsecount.png)](http://coderwall.com/feridmovsumov)

Örnek Kullanım aşağıdaki gibidir.

    $form = new Form("test.php");
    $form->setFormAttributes(array('id' => 'formId'));
    $form->setTableAttributes(array("class"=>"table"));
    $form->addInput("text", "name", "İsim")->setValidation(array("required"=>true,"min"=>3));
    $form->addInput("password", "pass", "Şifre")->setValidation(array("required"=>true,"min"=>8));
    $form->addLabel("Cinsiyet:");
    $form->addRadioButton("cinsiyet", "erkek", "Erkek",array("checked"=>"checked"));
    $form->addRadioButton("cinsiyet", "bayan", "Bayan");
    $form->addComboBox("carbrand","Arabanızın Markası", array('mercedes' => 'Mercedes', 'bmw' => 'BMW'));
    $form->addTextArea(32, 5, "adres","Adres");
    $form->addCheckBox("termofuse", "read", "Kullanmıcı Sözleşmesini okudum")->setValidation(array("mustBeChecked"=>true));
    $form->addInput("submit", "dugme", "Kaydet");
    echo $form->show();

Testleri topluca çalıştırmak amacıyla TestSuite.php çalıştırılmalıdır. 