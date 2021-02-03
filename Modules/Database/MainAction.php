<?php
require_once './Business/Person.php';
require_once './Database/Action.php';
require_once './Business/Institution.php';
require_once './Business/City.php';
require_once './Exceptions/SQLStatmentException.php';
require_once './Exceptions/DuplicateDataEntry.php';


class MainAction extends Action
{

    //TODO: improvements
    // [1] add both isCityExists() and isInstitutionsExists()

    /**
     * MainAction constructor.
     */
    public function __construct()
    {

        parent::setConnection($this);

    }

    public function getAllInstitutions(): array //of Institutions
    {
        $conn = $this->getDatabaseConnection();
        //FIXME: fix the typo in institutuion_view
        $stmt = $this->getSingleStatement("SELECT * FROM Institutuion_view", $conn);
        $array_of_institutions = array();
        while ($row = sqlsrv_fetch_array($stmt)) {
            $array_of_institutions[] = new Institution((string)$row[0], //name
                (string)$row[1], //website
                (bool)$row[2], //insideCampus
                array((string)$row[3], (string)$row[4]), //phones
                array((string)$row[5]) //emails
            );
        }
        $this->closeConnection($conn);
        return $array_of_institutions;

    }

    public function getAllCities(): array //of Cities
    {
        $conn = $this->getDatabaseConnection();
        $stmt = $this->getSingleStatement("SELECT * FROM City", $conn);
        $array_of_cities = array();
        while ($row = sqlsrv_fetch_array($stmt)) {
            $array_of_cities[] = new City((string)$row[0], //shortcut
                (string)$row[1], //name
                (int)$row[2] //postalCode
            );
        }
        $this->closeConnection($conn);
        return $array_of_cities;
    }

    public function SignUp(Person $person,String $password,String $academicNumber)
    {

        //check if email exists
        if($this->isUserExists($academicNumber,$person->getEmail()))
        {
            throw new DuplicateDataEntry("The Email or AcademicNumber already exists");
        }
        /*
         * Steps
         * 1-upload personContacts record
         * 2-upload Person record
         * */

        $conn = $this->getDatabaseConnection();
        sqlsrv_begin_transaction($conn);
        //PersonContacts
        $sql1="INSERT INTO PersonContacts(email,phone_number,phd_certificate) VALUES(?,?,?)";
        $params1=array("{$person->getEmail()}",
            "{$person->getPhoneNumber()}",
            "{$person->getPhd()}");
        $stmt1 = $this->getParameterizedStatement($sql1, $conn,$params1);

        $sql2="INSERT INTO Person(first_name,
                   middle_name,
                   last_name,
                   user_password,
                   contact_email,
                   acadmeic_number,
                   gender,
                   city_shortcut) VALUES(?,?,?,?,?,?,?,?)";
        $params2=array("{$person->getFirstName()}",
            "{$person->getMiddleName()}",
            "{$person->getLastName()}",
            "{$password}",
            "{$person->getEmail()}",
            "{$academicNumber}",
            "{$person->getGender()[0]}",//the first char of gender M or F
            "{$person->getCity()}");
        $stmt2 = $this->getParameterizedStatement($sql2, $conn,$params2);
        if($stmt2==false || $stmt1==false)
        {
            sqlsrv_rollback($conn);
            $this->closeConnection($conn);
            throw new SQLStatmentException("Couldn't execute this statement");

        }
        sqlsrv_commit($conn);
        $this->closeConnection($conn);
        return true;

    }

    private function isUserExists(string $academicNumber, string $getEmail):bool
    {
        $conn=$this->getDatabaseConnection();
        $sql="SELECT * FROM Person WHERE Person.acadmeic_number=? OR Person.contact_email=?";
        $params=array("{$academicNumber}",
            "{$getEmail}");
        $stmt=$this->getParameterizedStatement($sql,$conn,$params);
        if($stmt==false)
        {
            throw new SQLStatmentException("Couldn't execute this statement");
        }
        if(sqlsrv_has_rows($stmt))
        {
            return true;
        }
        return false;
    }


}