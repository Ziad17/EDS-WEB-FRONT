<?php

require_once 'Action.php';






class InstitutionAction extends Action
{

    private InstitutionsPermissions $myInstitutionPermissions;
    private bool $active;

    public function __construct(Person $myPersonRef)
    {
        parent::setConnection($this);


        $this->myPersonRef = $myPersonRef;
        $this->updateMyInstitutionPermissionsSum();

    }


    public function updateMyInstitutionPermissionsSum()
    {
        //updates the permissions array
        $conn = $this->getDatabaseConnection();
        $sql = "SELECT institutions_permissions_sum,active FROM PersonRolesAndPermissions_view WHERE contact_email=?";
        $params = array($this->myPersonRef->getEmail());
        $stmt = $this->getParameterizedStatement($sql, $conn, $params);
        if ($stmt == false) {

            //TODO :PRODUCTION UNCOMMENT THIS
            //$error="Could not get details of the person roles";
            $error = sqlsrv_errors()[0]['message'];
            $this->closeConnection($conn);
            throw new SQLStatmentException($error);


        }
        if (sqlsrv_has_rows($stmt)) {
            //FIXME: add logic if a person has more than one role

            $row = sqlsrv_fetch_object($stmt);
            $this->active = $row->active;
            if ($this->active == false) //check for active status
            {
                $this->closeConnection($conn);
                throw new PersonOrDeactivated("Your role has been deactivated by an admin");
            } else {

                $sum = (int)$row->institutions_permissions_sum;

                if ($sum >= 0) {
                    $this->closeConnection($conn);
                    $this->myInstitutionPermissions = new InstitutionsPermissions($sum);

                } else {
                    $this->closeConnection($conn);
                    throw new NoPermissionsGrantedException('Role Found But No Permissions Is Granted');
                }
            }
        } else {
            $this->closeConnection($conn);
            throw new PersonHasNoRolesException('No Roles Found');
        }


    }

    private function injectLog(int $actionPerformed, int $InstitutionID, &$conn): bool
    {
        $logSQL = "INSERT INTO InstitutionActionLogs(person_id,institution_id,action_date,institution_permission_action_performed) VALUES(?,?,GETDATE(),?);";
        $logParams = array($this->myPersonRef->getID(), $InstitutionID, $actionPerformed);
        $logsStmt = $this->getParameterizedStatement($logSQL, $conn, $logParams);

        if ($logsStmt == false) {
            $this->closeConnection($conn);
            return false;
        }
        return true;
    }


    public function getPersonsOfInstitution(int $institutionID): array//array of persons
    {
        if ($this->canViewPersonsOfInstitution()) {
            $permission = 2 ** $this->myInstitutionPermissions->VIEW_PERSONS_IN_INSTITUTION;
            $conn = $this->getDatabaseConnection();
            $sql = "SELECT contact_email,first_name,middle_name,last_name,image_ref,role_front_name FROM PersonsHierarchy_view WHERE institution_id=? ORDER BY role_priority_lvl;";
            $params = array($institutionID);
            $stmt = $this->getParameterizedStatement($sql, $conn, $params);
            if ($stmt == false) {
                //TODO :PRODUCTION UNCOMMENT THIS
                //$error="Could not View Details";
                $error = sqlsrv_errors()[0]['message'];
                $this->closeConnection($conn);
                throw new SQLStatmentException($error);
            }
            $persons = array();
            while ($row = sqlsrv_fetch_object($stmt)) {
                $role =  PersonRole::Builder()->setJobTitle($row->role_front_name);
                $personToAdd = Person::Builder()
                    ->setFirstName($row->first_name)
                    ->setMiddleName($row->middle_name)
                    ->setLastName($row->last_name)
                    ->setImgRef($row->image_ref)
                    ->setRoles(array($role))
                    ->setEmail($row->contact_email)
                    ->build();
                $persons[] = $personToAdd;

            }
            return $persons;

        } else {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }
    }

    public function canCreateInstitution(): bool
    {
        try {
            return $this->myInstitutionPermissions->getPermissionsFromBitArray($this->myInstitutionPermissions->CREATE_INSTITUTION);
        } catch (Exception $e) {
            throw new  NoPermissionsGrantedException('Institution Creation Permissions Is Not Granted');
        }
    }

    public function canCreateRole(): bool
    {
        try {
            return $this->myInstitutionPermissions->getPermissionsFromBitArray($this->myInstitutionPermissions->CREATE_ROLE);
        } catch (Exception $e) {
            throw new  NoPermissionsGrantedException('Role Creation Permissions Is Not Granted');
        }
    }

    public function canViewPersonsOfInstitution(): bool
    {
        try {
            return $this->myInstitutionPermissions->getPermissionsFromBitArray($this->myInstitutionPermissions->VIEW_PERSONS_IN_INSTITUTION);
        } catch (Exception $e) {
            throw new  NoPermissionsGrantedException('Institution View Permissions Is Not Granted');
        }
    }

    public function canEditInstitutionInfo(): bool
{
    try {
        return $this->myInstitutionPermissions->getPermissionsFromBitArray($this->myInstitutionPermissions->EDIT_INSTITUTION);
    } catch (Exception $e) {
        throw new  NoPermissionsGrantedException('Institution Edit Permissions Is Not Granted');
    }
}

    public function createInstitution(Institution $institutionToCreate): bool
    {

        //REQUIRED_PERMISSION=$CREATE_INSTITUTION=1

        if ($this->canCreateInstitution()) {
            $permission_value = 2 ** ($this->myInstitutionPermissions->CREATE_INSTITUTION);

            if ($this->isInstitutionExists($institutionToCreate->getName())) {
                throw new DuplicateDataEntry("Institution Already Created");

            }
            $con = $this->getDatabaseConnection();

            sqlsrv_begin_transaction($con);
            $sql = "SET NOCOUNT ON;INSERT INTO Institution(institution_name,
                        institution_type_id,
                        institution_active,
                        institution_parent_id,
                        institution_website,
                        inside_campus,
                        primary_phone,
                        secondary_phone,
                        fax,
                        email
                        ) VALUES(?,?,1,?,?,?,?,?,?,?); SELECT SCOPE_IDENTITY()";
            $params = array(
                $institutionToCreate->getName(),
                (int)$institutionToCreate->getType(),

                $institutionToCreate->getParent(),
                $institutionToCreate->getWebsite(),
                1,
                $institutionToCreate->getPrimaryPhone(),
                $institutionToCreate->getSecondaryPhone(),
                $institutionToCreate->getFax(),
                $institutionToCreate->getEmail()

            );

            $stmt = $this->getParameterizedStatement($sql, $con, $params);

            if ($stmt == false) {
                //TODO :PRODUCTION UNCOMMENT THIS
                //$error="Could not Insert Institution";
                $error = sqlsrv_errors()[0]['message'];
                sqlsrv_rollback($con);

                $this->closeConnection($con);
                throw new InsertionError($error);

            }
            //ID THAT IS RETURNED
            $row = sqlsrv_fetch_array($stmt);
            $institution_created_ID = (int)$row[0];

            if ($this->injectLog($permission_value, $institution_created_ID, $con) == false) {
                sqlsrv_rollback($con);
                $this->closeConnection($con);
                throw new LogsError("Could Not Insert Institution Logs");
            }

            sqlsrv_commit($con);
            $this->closeConnection($con);
            return true;

        } else {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }

    }

    public function deleteInstitution(): bool
    {

        return false;
    }

    public function editInstitutionInfo(Institution $oldInstitutionInfo,Institution $newInstitutionInfo): bool
    {
        if($this->canEditInstitutionInfo() && $this->isEmployeeOfInstitution($oldInstitutionInfo->getID()))
        {
            if (!$this->isInstitutionExists($oldInstitutionInfo->getName())) {
                throw new DataNotFound("Could not get the institution info");

            }
            $permission_value = 2 ** ($this->myInstitutionPermissions->EDIT_INSTITUTION);
            $conn=$this->getDatabaseConnection();
            sqlsrv_begin_transaction($conn);

            $sql='UPDATE Institution SET institution_name=?,institution_type_id=?,institution_website=?,institution_img=?,primary_phone=?,secondary_phone=?,fax=?,email=? WHERE ID=?';
            $params=array($newInstitutionInfo->getName(),
                $newInstitutionInfo->getType(),
                $newInstitutionInfo->getWebsite(),
                $newInstitutionInfo->getInstitutionImg(),
                $newInstitutionInfo->getPrimaryPhone(),
                $newInstitutionInfo->getSecondaryPhone(),
                $newInstitutionInfo->getFax(),
                $newInstitutionInfo->getEmail(),
                $oldInstitutionInfo->getID());
            $stmt=$this->getParameterizedStatement($sql,$conn,$params);
            if ($stmt == false) {
                //TODO :PRODUCTION UNCOMMENT THIS
                //$error="Could not Update Institution";
                $error = sqlsrv_errors()[0]['message'];
                sqlsrv_rollback($conn);
                $this->closeConnection($conn);
                throw new InsertionError($error);
            }
            if ($this->injectLog($permission_value, $oldInstitutionInfo->getID(), $conn) == false) {
                //TODO :PRODUCTION UNCOMMENT THIS
                //$error="Could Not Insert Institution Logs";
                $error= sqlsrv_errors($conn)[0]['message'];
                sqlsrv_rollback($conn);

                $this->closeConnection($conn);
                throw new LogsError($error);
            }
            sqlsrv_commit($conn);
            $this->closeConnection($conn);
            return true;

        }
        else
        {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }




    }

    public function getSingleInstitutionInfo(string $name): Institution
    {
        $con = $this->getDatabaseConnection();
        //FIXME:: PRODUCTION UNCOMMENT
        //$sql = "SELECT * FROM Institution WHERE institution_name=? AND NOT institution_name='SYSTEM'";
        //FIXME:: PRODUCTION REMOVE
        $sql = "SELECT * FROM Institution WHERE institution_name=?";
        $params = array($name);
        $stmt = $this->getParameterizedStatement($sql, $con, $params);
        if ($stmt == false || !sqlsrv_has_rows($stmt)) {
            $this->closeConnection($conn);
            throw new DataNotFound("Error fetching the required data");
        } else {

            $row = sqlsrv_fetch_object($stmt);

            $institution= Institution::Builder()
                ->setID($row->ID)
                ->setName($row->institution_name)
                ->setTypeId($row->institution_type_id)
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

            $this->closeConnection($conn);
            return $institution;
        }

    }

    public function getInstitutionNameByID(int $id): string
    {
        $con = $this->getDatabaseConnection();
        $sql = "SELECT institution_name FROM Institution WHERE ID=?";
        $params = array($id);
        $stmt = $this->getParameterizedStatement($sql, $con, $params);
        if ($stmt == false || !sqlsrv_has_rows($stmt)) {
            $this->closeConnection($conn);
            throw new SQLStatmentException("Error fetching the required data");
        } else {
            $row = sqlsrv_fetch_object($stmt);
            return (string)$row->institution_name;
        }

    }

    public function isInstitutionExists(string $getName)
    {
        $con = $this->getDatabaseConnection();
        $sql = "SELECT * FROM Institution WHERE Institution_name=?";
        $params = array($getName);
        $stmt = $this->getParameterizedStatement($sql, $con, $params);
        if ($stmt == false) {
            $this->closeConnection($con);
            throw new SQLStatmentException("Could not find any result");
        }
        if (sqlsrv_has_rows($stmt)) {
            $this->closeConnection($con);
            return true;
        }
        $this->closeConnection($con);
        return false;

    }




    //TODO:: check whether it's needed or not
/*    Public function createNewRole(int $my_id,int $my_role_id,string $name,int $role_pri_level,int $files_permissions_sum,int $folders_permissions_sum,int $person_permissions_sum,int $institutions_permissions_sum)
    {
        if ($this->canCreateInstitution()) {
            $permission_value = 2 ** ($this->myInstitutionPermissions->CREATE_INSTITUTION);
            $conn=$this->getDatabaseConnection();
            $sql='';
            $params=array();
            $stmt=$this->getParameterizedStatement($sql,$conn,$params);
            if($stmt==false)
            {
                //TODO :PRODUCTION UNCOMMENT THIS
                //$error="Could not get the roles of this person";
                $error=sqlsrv_errors()[0]['message'];
                $this->closeConnection($conn);
                throw new PersonHasNoRolesException($error);

        }
        else
        {


        }

    }*/


}