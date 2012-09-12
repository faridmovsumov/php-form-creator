<?php
include_once 'Form.php';


try
{
$form=new Form("index.php");

$form->setMethod("post");

echo $form->show();

var_dump($form);

}
catch (Exception $ex)
{
    echo $ex->getMessage();
}
?>