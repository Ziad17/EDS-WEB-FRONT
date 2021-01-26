<?php
declare(strict_types=1);
require './Business/Person.php';
require 'Validator.php';

class PersonValidator extends Validator
{
    private Person $personToValidate;

    public function _construct(Person $person)
    {
        $this->personToValidate = $person;
    }
    public function validate(): bool
    {
        $this->ERROR = validateEmail();
        $this->ERROR = validateSingleName();
        $this->ERROR = validateNumber();
        $this->ERROR = validateInstitusion();
        $this->ERROR = validateAcadmicNumber();
        $this->ERROR = validateGender();

        return $this->isErrorPresent();
    }


    public function validateEmail(): string
    {
        if (filter_var($this->personToValidate->getEmail(), FILTER_VALIDATE_EMAIL)) {
            //empty string represent its error free
            return '';
        }
        return 'Email is not properly formatted';
    }
    public function validateNumber(): string
    {
        if (filter_var($this->personToValidate->getPhoneNumber(), FILTER_SANITIZE_NUMBER_INT)) {
            if (strlen($this->personToValidate->getPhoneNumber()) == PHONE_NUMBER_LENGTH) {
                return '';
            }
            return 'Phone number must be '.PHONE_NUMBER_LENGTH." digits";

        }
        return 'Phone number must only be numbers';
    }
    public function validateSingleName(): string
    {
        return '';
        }
    public function validateInstitution(): string
    {
        if (filter_var($this->personToValidate->getEmail(), FILTER_VALIDATE_EMAIL)) {
            //empty string represent its error free
            return '';
        }
        return 'Email is not properly formatted';
    }
    public function validateGender(): string
    {
        return '';
    }
    public function validateAcadmicNumber(): string
    {

        if (filter_var($this->personToValidate->getAcadmicNumber(), FILTER_SANITIZE_NUMBER_INT)) {
            if (strlen($this->personToValidate->getAcadmicNumber()) == PHONE_NUMBER_LENGTH) {
                return '';
            }
            return 'Academic number must be '.ACADMIC_NUMBER_LENGTH." digits";
        }
        return 'Academic number must only be numbers';
    }


}



