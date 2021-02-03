<?php
require_once "./Database/MainAction.php";
require_once './Business/Person.php';
try {
    $person = new Person("yh00@gmail.com",
        "1234567891234506",
        "ziad",
        "mohamed",
        "fathy",
        "Computer and Information",
        "Female",
        "01286725073","", "", "ALEX");
    $mainAction = new MainAction();
    $arr = $mainAction->SignUp($person, "123456", $person->getAcadmicNumber());
    if ($arr != false) {
        echo 'true';

    } else {
        echo "failed";
    }
} catch (Exception $e) {
    echo $e->getMessage();

}
