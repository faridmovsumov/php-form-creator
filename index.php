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

echo $form->show();

//var_dump($form);

}
catch (Exception $ex)
{
    echo $ex->getMessage();
}
?>