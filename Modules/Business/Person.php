<?php


class Person
{

    private string $Email;
    private string $acadmicNumber;
    private string $firstName;
    private string $middleName;
    private string $lastName;
    private string $Institution;
    private string $Gender;
    private String $phoneNumber;


    /**
     * Person constructor.
     * @param String $Email
     * @param String $acadmicNumber
     * @param String $firstName
     * @param String $middleName
     * @param String $lastName
     * @param String $Institution
     * @param String $Gender
     */
    public function __construct(string $Email, string $acadmicNumber, string $firstName, string $middleName, string $lastName, string $Institution, string $Gender)
    {
        $this->Email = $Email;
        $this->acadmicNumber = $acadmicNumber;
        $this->firstName = $firstName;
        $this->middleName = $middleName;
        $this->lastName = $lastName;
        $this->Institution = $Institution;
        if ($Gender == "M") {
            $this->Gender = "Male";

        } else {
            $this->Gender = "Female";

        }
    }


    /**
     * @return String
     */
    public function getEmail(): string
    {
        return $this->Email;
    }

    /**
     * @return String
     */
    public function getAcadmicNumber(): string
    {
        return $this->acadmicNumber;
    }

    /**
     * @return String
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return String
     */
    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    /**
     * @return String
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return String
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }


    /**
     * @return String
     */
    public function getInstitution(): string
    {
        return $this->Institution;
    }

    /**
     * @return String
     */
    public function getGender(): string
    {
        return $this->Gender;
    }

}