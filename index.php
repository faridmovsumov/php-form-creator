<?php
include_once 'Form.php';

try
{
$form=new Form("index.php");

$params=array(
    "id"=>"iddegeri",
    "class"=>"style",
);

$form->setAdditionalParams($params);
$form->addInput("text", "name","Name");
$form->addInput("password", "pass","Password");
$form->addInput("submit", "dugme","Send");
$form->setTableAttributes(array("border"=>"1"));
echo $form->show();

//var_dump($form);

}
catch (Exception $ex)
{
    echo $ex->getMessage();
}
?>