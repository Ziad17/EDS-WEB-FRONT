<?php
declare(strict_types=1);

require_once "Validator.php";


class PersonValidator extends Validator
{
    private Person $personToValidate;

    public function __construct(Person $person)
    {
        $this->personToValidate = $person;
    }
    public function validate(): bool
    {
        $this->ERROR = $this->validateEmail();
        $this->ERROR = $this->validateSingleName();
        $this->ERROR = $this->validateNumber();
        $this->ERROR = $this->validateInstitution();
        $this->ERROR = $this->validateAcademicNumber();
        $this->ERROR = $this->validateGender();

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
    public function validateAcademicNumber(): string
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



