<?php

include_once 'Form.php';

try {
    $form = new Form("index.php");
    $form->setFormAttributes(array('id' => 'ornekId'));
    $form->addInput("text", "name", "Name");
    $form->addInput("password", "pass", "Password");
    $form->addTextArea(25, 5, "Adres");
    $form->addInput("submit", "dugme", "Send");
    $form->setTableAttributes(array("cellspacing" => "2", "cellpadding" => "1"));
    echo $form->show();
//var_dump($form);
} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>