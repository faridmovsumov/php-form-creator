<?php

require_once 'FormCreator/PhpValidation.php';
//Burada php doğrulamasını test betmeyi amaçlıyorum

$phpValidation = new PhpValidation();

foreach ($_POST as $key => $val) {
    echo "$key=$val<br/>";
}

//name pass yas

try {
    $phpValidation->set($_POST['name'], "string","name")->setMinLength(2)->setMaxLength(10);
    
    
    
    $phpValidation->set($_POST['yas'], "int","yas")->setMinValue(0)->setMaxValue(100);

    if ($phpValidation->isValid() == false) {
        echo $phpValidation->getMessage();
    }
    
    var_dump($phpValidation);
    
} catch (Exception $ex) {
      $ex->getMessage();
}

?>