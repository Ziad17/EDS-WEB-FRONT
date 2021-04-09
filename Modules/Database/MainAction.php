<?php
require_once "Modules/Business/Person.php";
require_once "Modules/Business/PersonRole.php";

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
        $stmt = $this->getSingleStatement("SELECT * FROM Institution", $conn);
        $array_of_institutions = array();

        if($stmt!=null) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $array_of_institutions[] = Institution::Builder()->setID((string)$row['ID'])
                    ->setName((string)$row['institution_name'])
                    ->setActive((string)$row['institution_active'])
                    ->setLevel((string)$row['institution_level'])
                    ->setInsideCampus((string)$row['inside_campus'])
                    ->setSecondaryPhone((string)$row['secondary_phone'])
                    ->build();


            }

            $this->closeConnection($conn);
            return $array_of_institutions;

        }
        else{
            $this->closeConnection($conn);

            throw  new ConnectionException("Empty Set Of Results");}
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

    public function getAllAvailableRoles(int $priorit_lvl)
    {
        $conn = $this->getDatabaseConnection();
        //FIXME::make the roles < prioritylevel
        $sql="SELECT role_name FROM Roles   ";
        $params=array($priorit_lvl);
        $stmt = $this->getParameterizedStatement($sql, $conn, $params);
        if ($stmt == false) {
            $error=sqlsrv_errors()[0];
            $this->closeConnection($conn);

            throw new SQLStatmentException($error['message']);
        }
        else {
            $array_of_roles = array();
            while ($row = sqlsrv_fetch_array($stmt)) {
                $array_of_roles[] = new PersonRole($row[0],0,'','');

            }
        }
        $this->closeConnection($conn);
        return $array_of_roles;
    }

    public function getInstitutionTypes()
    {

        $conn = $this->getDatabaseConnection();
        $sql="SELECT institution_type FROM InstitutionType   ";
        $stmt = $this->getSingleStatement($sql, $conn);
        if ($stmt == false) {
            $error=sqlsrv_errors()[0];
            $this->closeConnection($conn);

            throw new SQLStatmentException($error['message']);
        }
        else {
            $array_of_types = array();
            while ($row = sqlsrv_fetch_array($stmt)) {
                $array_of_types[] = (string)$row[0];

            }
        }
        $this->closeConnection($conn);
        return $array_of_types;


    }


}