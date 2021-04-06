<?php
require_once "Modules/Business/Person.php";
require_once "Modules/Database/Action.php";
require_once "Modules/Business/Institution.php";
require_once "Modules/Business/City.php";
require_once "Modules/Exceptions/SQLStatmentException.php";
require_once "Modules/Exceptions/DuplicateDataEntry.php";


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


    public function signIn(string $email, string $password): int
    {
        $con = $this->getDatabaseConnection();
        $sql = "SELECT ID FROM Person WHERE Person.academic_number=? OR Person.contact_email=? AND user_password=?";
        $params = array($email, $email, $password);
        $stmt = $this->getParameterizedStatement($sql, $con, $params);
        if ($stmt == false) {
            $this->closeConnection($con);
            throw new SQLStatmentException("Could not connect");
        }
        if(!sqlsrv_has_rows($stmt))
        {
            $this->closeConnection($con);
            return false;
        }

        $row=sqlsrv_fetch_object($stmt);
       $ID= $row->ID;

        $this->closeConnection($con);
        return $ID;


    }



}