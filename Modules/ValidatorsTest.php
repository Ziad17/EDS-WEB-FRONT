<?php

require_once "Validation/PersonValidator.php";
require_once "Business/Person.php";
$FormErrors[] =array();

$personValidator = new PersonValidator(Person::Builder()->setFirstName("username")
    ->setEmail("")
    ->setAcadmicNumber("acd_number")
    ->setPhoneNumber("")
    ->setInstitution("")
    ->setCity("")
    ->build());

if (!$personValidator->isValid()) {
    print_r($personValidator->getERRORSLIST());


}

