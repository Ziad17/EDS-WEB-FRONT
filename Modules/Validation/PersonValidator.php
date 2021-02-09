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
    public function isValid(): bool
    {
        $this->ERRORS_LIST[] = $this->validateEmail();
        $this->ERRORS_LIST[] = $this->validateSingleName();
     //  $this->ERRORS_LIST[] = $this->validateNumber();
        $this->ERRORS_LIST[] = $this->validateInstitution();
        $this->ERRORS_LIST[] = $this->validateAcademicNumber();
        $this->ERRORS_LIST[] = $this->validateGender();
        foreach ($this->ERRORS_LIST as $ERROR)
        {
            if($ERROR=="" || empty($ERROR))
            {
                unset($this->ERRORS_LIST[array_search($ERROR,$this->ERRORS_LIST)]);
            }
        }
        array_values($this->ERRORS_LIST);


        return !$this->isErrorPresent();


    }


    public function validateEmail(): string
    {

        if (filter_var($this->personToValidate->getEmail(), FILTER_VALIDATE_EMAIL)) {
            //empty string represent its error free

            return '';
        }

        $this->IS_ERROR_PRESENT=true;
        return 'Email is not properly formatted';
    }
    public function validateNumber(): string
    {
        if (filter_var($this->personToValidate->getPhoneNumber(), FILTER_SANITIZE_NUMBER_INT)) {
            if (strlen($this->personToValidate->getPhoneNumber()) == PHONE_NUMBER_LENGTH) {
                return '';
            }
            $this->IS_ERROR_PRESENT=true;

            return 'Phone number must be 11 digits';

        }
        $this->IS_ERROR_PRESENT=true;

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
        $this->IS_ERROR_PRESENT=true;

        return 'Email is not properly formatted';
    }
    public function validateGender(): string
    {
        return '';
    }
    public function validateAcademicNumber(): string
    {

        if (filter_var($this->personToValidate->getAcadmicNumber(), FILTER_SANITIZE_NUMBER_INT)) {
            if (strlen($this->personToValidate->getAcadmicNumber()) == ACADMIC_NUMBER_LENGTH) {
                return '';
            }
            $this->IS_ERROR_PRESENT=true;

            return 'Academic number must be 16 digits';
        }
        $this->IS_ERROR_PRESENT=true;

        return 'Academic number must only be numbers';
    }


}



