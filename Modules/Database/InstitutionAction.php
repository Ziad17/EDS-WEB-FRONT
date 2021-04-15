<?php

require_once "./Modules/Database/Action.php";
require_once "./Modules/Exceptions/PermissionsCriticalFail.php";
require_once "./Modules/Exceptions/PersonHasNoRolesException.php";
require_once "./Modules/Permissions/InstitutionsPermissions.php";
require_once "./Modules/Exceptions/LogsError.php";
require_once "./Modules/Exceptions/InsertionError.php";


class InstitutionAction extends Action
{

    private string $institutionName;
    private InstitutionsPermissions $myInstitutionPermissions;
    private array $roleAndPermissionSum = array("PERMISSION_SUM" => 0);
    private int $institutionLevel;
    private bool $active;
    public function __construct(Person $myPersonRef,string $_institutionName)
    {
        parent::setConnection($this);
        try {

            $this->institutionName=$_institutionName;
            $this->myPersonRef = $myPersonRef;
            $this->updateMyInstitutionPermissions();
            $this->myInstitutionPermissions = new InstitutionsPermissions($this->roleAndPermissionSum["PERMISSION_SUM"]);
        } catch (Exception $e) {
            throw new PermissionsCriticalFail($e->getMessage());

        }
    }



    public function updateMyInstitutionPermissions()
    {
        //updates the permissions array
        $conn = $this->getDatabaseConnection();
        $sql = "SELECT institution_level,institutions_permissions_sum,active FROM PersonRolesAndPermissions_view WHERE contact_email=? 
";
        $params = array($this->myPersonRef->getEmail());
        $stmt = $this->getParameterizedStatement($sql, $conn, $params);
        if ($stmt == false) {

            //TODO :PRODUCTION UNCOMMENT THIS
            //$error="Could not get details of the person roles";
            $error=sqlsrv_errors()[0]['message'];
            $this->closeConnection($conn);
            throw new SQLStatmentException($error);


        }
        if (sqlsrv_has_rows($stmt)) {
            //FIXME: add logic if a person has more than one role

            $row = sqlsrv_fetch_object($stmt);
            $this->institutionLevel = $row->institution_level;
            $this->active = $row->active;
            if ($this->active == false) //check for active status
            {
                throw new PersonOrDeactivated("Your role has been deactivated by an admin");
            } else {
                $this->roleAndPermissionSum["PERMISSION_SUM"] = $row->institutions_permissions_sum;
                $this->closeConnection($conn);
            }
        } else {
            $this->closeConnection($conn);
            throw new PersonHasNoRolesException('asdasd');
        }



    }
    private function injectLog(int $actionPerformed, int $InstitutionID, &$conn ):bool
    {
        $logSQL = "INSERT INTO InstitutionActionLogs(person_id,institution_id,action_date,institution_permission_action_performed) VALUES(?,?,GETDATE(),?);";
        $logParams = array($this->myPersonRef->getID(), $InstitutionID,$actionPerformed);
        $logsStmt=$this->getParameterizedStatement($logSQL,$conn,$logParams);
        if ($logsStmt==false) {
            $this->closeConnection($conn);
            return false;
        }
        return true;
    }
/*    public function getPersonsOfInstitution():array//array of persons
    {
        //REQUIRED_PERMISSION=$ACTIVATE_PERSON_OUTSIDE_INSTITUTION=9
        if ($this->myPersonPermissions->getPermissionsFromBitArray($this->myPersonPermissions->ACTIVATE_PERSON_OUTSIDE_INSTITUTION)) {
            if ($this->compareRoleLevel($this->myPersonRef->getEmail(), $targetEmail)) {
                $permission=$this->myPersonPermissions->ACTIVATE_PERSON_OUTSIDE_INSTITUTION;
                return $this->setRoleActiveStatus(true, $targetEmail,2**$permission);
            } else {
                throw new LowRoleForSuchActionException("The targeted person has a higher role level");
            }
        } else {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }


    }*/
    public function createInstitution(Institution $institutionToCreate):bool
    {
        $con=$this->getDatabaseConnection();
        //REQUIRED_PERMISSION=$CREATE_INSTITUTION=1
        sqlsrv_begin_transaction($con);
        if ($this->myInstitutionPermissions->getPermissionsFromBitArray($this->myInstitutionPermissions->CREATE_INSTITUTION)) {
            $permission_value=2**($this->myInstitutionPermissions->CREATE_INSTITUTION);

            if($this->isInstitutionExists($institutionToCreate->getName()))
            {
                throw new DuplicateDataEntry("Institution Already Created");

            }

            $sql = "SET NOCOUNT ON;INSERT INTO Institution(institution_name,
                        institution_type,
                        institution_active,
                        institution_parent_id,
                        institution_website,
                        inside_campus,
                        primary_phone,
                        secondary_phone,
                        fax,
                        email
                        ) VALUES(?,?,?,?,?,?,?,?,?,?); SELECT SCOPE_IDENTITY()";
            $params = array(
                $institutionToCreate->getName(),
                $institutionToCreate->getType(),
                $institutionToCreate->isActive(),
                $institutionToCreate->getParent(),
                            $institutionToCreate->getWebsite(),
                1,
                $institutionToCreate->getPrimaryPhone(),
                $institutionToCreate->getSecondaryPhone(),
                $institutionToCreate->getFax(),
                $institutionToCreate->getEmail()

            );

            $stmt = $this->getParameterizedStatement($sql, $con, $params);

            if($stmt==false)
            {
                //TODO :PRODUCTION UNCOMMENT THIS
                //$error="Could not Insert Institution";
                $error=sqlsrv_errors()[0]['message'];
                sqlsrv_rollback($con);

                $this->closeConnection($conn);
                throw new InsertionError($error);

            }


            //ID THAT IS RETURNED
            $row=sqlsrv_fetch_array($stmt);
            $institution_created_ID=(int)$row[0];

            if ( $this->injectLog($permission_value,$institution_created_ID,$con)==false) {
                sqlsrv_rollback($con);
                $this->closeConnection($conn);
                throw new LogsError("Could Not Insert Institution Logs");
            }
            else{return true;}
        } else {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }

    }
    public function deleteInstitution():bool
    {

        return false;
    }

    public function getSingleInstitutionInfo(string $name) :Institution
    {
        $con=$this->getDatabaseConnection();
        $sql = "SELECT * FROM Institution WHERE institution_name=?";
        $params = array($name);
        $stmt = $this->getParameterizedStatement($sql, $con, $params);
        if ($stmt == false || !sqlsrv_has_rows($stmt)) {
            $this->closeConnection($conn);
            throw new SQLStatmentException("Error fetching the required data");
        }
        else
            {
                $row=sqlsrv_fetch_object($stmt);
                return Institution::Builder()
                    ->setID($row->ID)
                    ->setName($row->institution_name)
                    ->setType($row->institution_type)
                    ->setActive($row->institution_active)
                    ->setParent($this->getInstitutionNameByID($row->institution_parent_id))
                    ->setLevel($row->institution_level)
                    ->setInsideCampus($row->inside_campus)
                    ->setPrimaryPhone($row->primary_phone)
                    ->setSecondaryPhone($row->secondary_phone)
                    ->setFax($row->fax)
                    ->setEmail($row->email)
                    ->setWebsite((string)$row->institution_website)
                    ->build();

            }

    }
    public function getInstitutionNameByID(int $id): String
    {
        $con=$this->getDatabaseConnection();
        $sql = "SELECT institution_name FROM Institution WHERE ID=?";
        $params = array($id);
        $stmt = $this->getParameterizedStatement($sql, $con, $params);
        if ($stmt == false || !sqlsrv_has_rows($stmt)) {
            $this->closeConnection($conn);
            throw new SQLStatmentException("Error fetching the required data");
        }
        else
        {
            $row=sqlsrv_fetch_object($stmt);
            return (string)$row->institution_name;
            }

    }

    public function isInstitutionExists(string $getName)
    {
        $con=$this->getDatabaseConnection();
        $sql="SELECT * FROM Institution WHERE Institution_name=?";
        $params=array($getName);
        $stmt=$this->getParameterizedStatement($sql,$con,$params);
        if($stmt==false)
        {
            $this->closeConnection($con);
            throw new SQLStatmentException("Could not find any result");
        }
        if(sqlsrv_has_rows($stmt))
        {
            $this->closeConnection($con);
            return true;
        }
        $this->closeConnection($con);
return false;

    }


}