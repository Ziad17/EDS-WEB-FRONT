<?php


class Person
{
    private int $ID;

    private string $Email;
    private string $acadmicNumber;
    private string $firstName;
    private string $middleName;
    private string $lastName;
    private string $Institution;
    private string $Gender;
    private string $phoneNumber;
    private string $bio;
    private string $phd;
    private string $city;
    private array $roles;
    private bool $hasMoreThanOneRole;


    public function __construct(PersonBuilder $builder)
    {

        $this->phoneNumber = $builder->getPhoneNumber();
        $this->city = $builder->getCity();
        $this->phd = $builder->getPhd();
        $this->bio = $builder->getBio();
        $this->Email = $builder->getEmail();
        $this->acadmicNumber = $builder->getAcadmicNumber();
        $this->firstName = $builder->getFirstName();
        $this->middleName = $builder->getMiddleName();
        $this->lastName = $builder->getLastName();
        $this->Institution = $builder->getInstitution();
        $this->roles = $builder->getRoles();
        $this->ID = $builder->getID();

        if (count($this->roles) > 1) {
            $this->hasMoreThanOneRole = true;
        } else {
            $this->hasMoreThanOneRole = false;
        }
        if ($builder->getGender() == "M") {
            $this->Gender = "Male";
        } else {
            $this->Gender = "Female";
        }
    }
    public static function Builder() : PersonBuilder

    {return new PersonBuilder();}


    /**
     * PersonRole constructor.
     * @param array $roles
     */

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return bool
     */
    public function isHasMoreThanOneRole(): bool
    {
        return $this->hasMoreThanOneRole;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }


    /**
     * @return String
     */
    public function getEmail(): string
    {
        return $this->Email;
    }

    /**
     * @return int
     */
    public function getID(): int
    {
        return $this->ID;
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

    /**
     * @return string
     */
    public function getBio(): string
    {
        return $this->bio;
    }

    /**
     * @return string
     */
    public function getPhd(): string
    {
        return $this->phd;
    }


}

class PersonBuilder
{
    private int $ID=0;
    private string $Email="";
    private string $acadmicNumber="";
    private string $firstName="";
    private string $middleName="";
    private string $lastName="";
    private string $Institution="";
    private string $Gender="";
    private string $phoneNumber="";
    private string $bio="";
    private string $phd="";
    private string $city="";
    private array $roles=array();

    /**
     * PersonBuilder constructor.
     */
    public function build(): Person
    {
        return new Person($this);
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->Email;
    }

    /**
     * @param string $Email
     */
    public function setEmail(string $Email): PersonBuilder
    {
        $this->Email = $Email;
        return $this;
    }

    /**
     * @return string
     */
    public function getAcadmicNumber(): string
    {
        return $this->acadmicNumber;
    }

    /**
     * @param string $acadmicNumber
     */
    public function setAcadmicNumber(string $acadmicNumber): PersonBuilder
    {
        $this->acadmicNumber = $acadmicNumber;
        return $this;

    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): PersonBuilder
    {
        $this->firstName = $firstName;
        return $this;

    }

    /**
     * @return string
     */
    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    /**
     * @param string $middleName
     */
    public function setMiddleName(string $middleName): PersonBuilder
    {
        $this->middleName = $middleName;
        return $this;

    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return int
     */
    public function getID(): int
    {
        return $this->ID;
    }

    /**
     * @param int $ID
     */
    public function setID(int $ID): PersonBuilder
    {
        $this->ID = $ID;
        return $this;

    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): PersonBuilder
    {
        $this->lastName = $lastName;
        return $this;

    }

    /**
     * @return string
     */
    public function getInstitution(): string
    {
        return $this->Institution;
    }

    /**
     * @param string $Institution
     */
    public function setInstitution(string $Institution): PersonBuilder
    {
        $this->Institution = $Institution;
        return $this;

    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->Gender;
    }

    /**
     * @param string $Gender
     */
    public function setGender(string $Gender): PersonBuilder
    {
        $this->Gender = $Gender;
        return $this;

    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): PersonBuilder
    {
        $this->phoneNumber = $phoneNumber;
        return $this;

    }

    /**
     * @return string
     */
    public function getBio(): string
    {
        return $this->bio;
    }

    /**
     * @param string $bio
     */
    public function setBio(string $bio): PersonBuilder
    {
        $this->bio = $bio;
        return $this;

    }

    /**
     * @return string
     */
    public function getPhd(): string
    {
        return $this->phd;
    }

    /**
     * @param string $phd
     */
    public function setPhd(string $phd): PersonBuilder
    {
        $this->phd = $phd;
        return $this;

    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): PersonBuilder
    {
        $this->city = $city;
        return $this;

    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): PersonBuilder
    {
        $this->roles = $roles;
        return $this;

    }


}