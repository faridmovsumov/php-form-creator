<?php

include_once 'Form.php';

try {
    $form = new Form("index.php");
    $form->setFormAttributes(array('id' => 'ornekId'));
    $form->setTableAttributes(array("cellspacing" => "2", "cellpadding" => "1"));
    $form->addInput("text", "name", "Name");
    $form->addInput("password", "pass", "Password");
    $form->addTextArea(25, 5, "Adres");
    $form->addInput("submit", "dugme", "Send");
    echo $form->show();
    
} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>