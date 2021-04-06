<?php


class InstitutionAction extends Action
{

    private InstitutionsPermissions $myInstitutionPermissions;
    private array $roleAndPermissionSum = array("PERMISSION_SUM" => 0);
    private int $myInstitutionID;
    private int $institutionLevel;
    private bool $active;
    public function __construct(Person $myPersonRef,int $myInstitution_id)
    {
        parent::setConnection($this);
        try {

            $this->myInstitutionID=$myInstitution_id;
            $this->myPersonRef = $myPersonRef;
            $this->updateMyInstitutionPermissions();
            $this->myInstitutionPermissions = new InstitutionsPermissions($this->roleAndPermissionSum["PERMISSION_SUM"]);
        } catch (Exception $e) {
            throw new PermissionsCriticalFail("Could not fetch person action permissions");

        }
    }

    public function updateMyInstitutionPermissions()
    {
        //updates the permissions array
        $conn = $this->getDatabaseConnection();
        $sql = "SELECT institution_level,institution_permissions_sum,active FROM PersonRolesAndPermissions_view WHERE contact_email=? AND institution_id=?";
        $params = array($this->myPersonRef->getEmail());
        $stmt = $this->getParameterizedStatement($sql, $conn, $params);
        if ($stmt == false) {
            $this->closeConnection($conn);
            throw new SQLStatmentException("Could not get details of the person roles");
        }
        if (sqlsrv_has_rows($stmt)) {
            $row = sqlsrv_fetch_object($stmt);
            $this->institutionLevel = $row->institution_level;
            $this->active = $row->institution_level;
            if ($this->active == false) //check for active status
            {
                throw new PersonOrDeactivated("Your role has been deactivated by an admin");
            } else {
                $this->roleAndPermissionSum["PERMISSION_SUM"] = $row->institution_permissions_sum;
                $this->closeConnection($conn);
            }
        } else {
            $this->closeConnection($conn);
            throw new PersonHasNoRolesException();
        }



    }
    private function injectLog(int $actionPerformed, int $InstitutionID, &$conn ):bool
    {
        $logSQL = "INSERT INTO InstitutionActionLogs(person_id,institution_id,action_date,institution_permission_action_performed) VALUES(?,?,GETDATE(),?);";
        $logParams = array($this->myPersonRef->getID(), $InstitutionID,$actionPerformed);
        $logsStmt=$this->getParameterizedStatement($logSQL,$conn,$logParams);
        if ($logsStmt==false) {
            sqlsrv_rollback($conn);
            $this->closeConnection($conn);
            return false;
        }
        return true;
    }
    public function getPersonsOfInstitution():array//array of persons
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


    }
    public function createInstitution(Institution $institutionToCreate,int $parent_institution_id):bool
    {
        $con=$this->getDatabaseConnection();
        //REQUIRED_PERMISSION=$CREATE_INSTITUTION=1
        if ($this->myInstitutionPermissions->getPermissionsFromBitArray($this->myInstitutionPermissions->CREATE_INSTITUTION)) {
            $permission_value=2**($this->myInstitutionPermissions->CREATE_INSTITUTION);

            $sql = "INSERT INTO Institution(Institution.level,Institution.name,Institution.type,institutions_parent_id,active) VALUES(?,?,?,?,1)";
            $params = array($institutionToCreate->getLevel(),$institutionToCreate->getName(), $institutionToCreate->getType(),$parent_institution_id);
            $stmt = $this->getParameterizedStatement($sql, $con, $params);
            //ID THAT IS RETURNED
            $institution_created_ID=0;
            if ($stmt == false || !sqlsrv_has_rows($stmt) || $this->injectLog($permission_value,$institution_created_ID,$con)) {
                $this->closeConnection($conn);
                throw new SQLStatmentException("Error fetching the required data");
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

}