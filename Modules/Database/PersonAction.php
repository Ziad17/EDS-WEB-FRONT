<?php
declare(strict_types=1);
require 'Action.php';

class PersonAction extends Action
{
    private PersonPermissions $myPersonPermissions;
    private array $roleAndPermissionSum = array("ROLE" => 0, "PERMISSION_SUM" => 0);

    /**
     * PersonAction constructor.
     * @param Person $myPersonRef
     * @throws PermissionsCriticalFail
     */
    public function __construct(Person $myPersonRef)
    {
        parent::setConnection($this);
        try {

            $this->myPersonRef = $myPersonRef;
            $this->getMyPersonRoleAndPermissions();
            $this->myPersonPermissions = new PersonPermissions($this->roleAndPermissionSum["PERMISSION_SUM"]);
        } catch (Exception $e) {
            throw new PermissionsCriticalFail("Could not fetch person action permissions");

        }
    }


    public function getMyPersonRoleAndPermissions()
    {
        //updates the permissions array
        $conn = $this->getDatabaseConnection();
        $sql = "SELECT priority_lvl,permission_sum,active FROM PersonRolesAndPermissions_view WHERE contact_email=?";
        $params = array($this->myPersonRef->getEmail());
        $stmt = $this->getParameterizedStatement($sql, $conn, $params);
        if ($stmt == false) {
            $this->closeConnection($conn);
            throw new SQLStatmentException("Could not get details of the person roles");
        }
        if (sqlsrv_has_rows($stmt)) {
            //FIXME: add logic if a person has more than one role
            $rows = sqlsrv_fetch_array($stmt);
            $role = (int)$rows[0][0]; //priority_lvl
            $permissions = (int)$rows[0][1]; //permission_sum
            $active = (bool)$rows[0][2];
            if ($active == false) //check for active status
            {
                throw new PersonOrDeactivated("Your role has been deactivated by an admin");
            } else {
                $this->roleAndPermissionSum["ROLE"] = $role;
                $this->roleAndPermissionSum["PERMISSION_SUM"] = $permissions;
                $this->closeConnection($conn);
            }
        } else {
            $this->closeConnection($conn);
            throw new PersonHasNoRolesException();
        }

    }

    public function getPersonData(string $email): Person
    {

        //TODO: ADD PersonActionLogs
        //REQUIRED_PERMISSION=VIEW_PERSON_PROFILE=0
        if ($this->myPersonPermissions->getPermissionsFromBitArray($this->myPersonPermissions->VIEW_PERSON_PROFILE)) {
            $conn = $this->getDatabaseConnection();
            $sql = "SELECT * FROM Person_view WHERE contact_email=?";
            $params = array($email);
            $stmt = $this->getParameterizedStatement($sql, $conn, $params);
            if ($stmt == false || !sqlsrv_has_rows($stmt)) {
                $this->closeConnection($conn);
                throw new SQLStatmentException("Error fetching the required data");
            }
            $rows = sqlsrv_fetch_array($stmt);
            $fName = $rows[0][0];
            $mName = $rows[0][1];
            $lName = $rows[0][2];
            $_email = $rows[0][3];
            $gender = $rows[0][4];
            $city = $rows[0][5];
            $phone_number = $rows[0][6];
            $phd = $rows[0][7];
            $bio = $rows[0][8];

            $this->closeConnection($conn);
            return Person::Builder()->setFirstName($fName)
                ->setMiddleName($mName)
                ->setLastName($lName)
                ->setEmail($_email)
                ->setGender($gender)
                ->setCity($city)
                ->setPhoneNumber($phone_number)
                ->setPhd($phd)
                ->setBio($bio)
                ->build();

        } else {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }
    }

    public function getPersonFiles(string $email): array //of files
    {

        return array();
    }

    public function activatePerson(string $targetEmail): bool
    {
        if ($this->getPersonRoleInstitution($targetEmail) == $this->getPersonRoleInstitution($this->myPersonRef->getEmail())) {
            return $this->activatePersonWithinInstitution($targetEmail);
        } else {
            return $this->activatePersonOutsideInstitution($targetEmail);
        }
    }

    public function deactivatePerson(string $targetEmail): bool
    {
        if ($this->getPersonRoleInstitution($targetEmail) == $this->getPersonRoleInstitution($this->myPersonRef->getEmail())) {
            return $this->deactivatePersonWithinInstitution($targetEmail);
        } else {
            return $this->deactivatePersonOutsideInstitution($targetEmail);
        }
    }

    private function activatePersonWithinInstitution(string $targetEmail): bool
    {
        //REQUIRED_PERMISSION=$ACTIVATE_PERSON_WITHIN_INSTITUTION=5
        if ($this->myPersonPermissions->getPermissionsFromBitArray($this->myPersonPermissions->ACTIVATE_PERSON_WITHIN_INSTITUTION)) {
            if ($this->compareRoleLevel($this->myPersonRef->getEmail(), $targetEmail)) {
                $permission=$this->myPersonPermissions->ACTIVATE_PERSON_WITHIN_INSTITUTION;
                return $this->setRoleActiveStatus(true, $targetEmail,2**$permission);
            } else {
                throw new LowRoleForSuchActionException("The targeted person has a higher role level");
            }
        } else {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }
    }

    private function setRoleActiveStatus(bool $active, string $targetEmail, int $permission): bool
    {

        $conn = $this->getDatabaseConnection();
        sqlsrv_begin_transaction($conn);
        $sql = "UPDATE PersonRolesAndPermissions_view SET active=? WHERE email=?";
        $params = array($active, $targetEmail);
        $stmt = $this->getParameterizedStatement($sql, $conn, $params);
        $logSQL = "INSERT INTO PersonActionLogs(affecter_person_id,affected_person_id,action_date,permission_action_performed) VALUES(?,?,GETDATE(),?);";
        $logParams = array($this->myPersonRef->getID(), $this->getIdFromPersonEmail($targetEmail),$permission);
        $logsStmt=$this->getParameterizedStatement($logSQL,$conn,$logParams);
        if ($stmt == false || sqlsrv_rows_affected($stmt) == false || $logsStmt==false) {
            sqlsrv_rollback($conn);
            $this->closeConnection($conn);
            return false;
        } else {
            sqlsrv_commit($conn);
            $this->closeConnection($conn);
            return true;
        }
    }

    private function deactivatePersonWithinInstitution(string $targetEmail): bool
    {
        //REQUIRED_PERMISSION=$DEACTIVATE_PERSON_WITHIN_INSTITUTION=4
        if ($this->myPersonPermissions->getPermissionsFromBitArray($this->myPersonPermissions->DEACTIVATE_PERSON_WITHIN_INSTITUTION)) {
            if ($this->compareRoleLevel($this->myPersonRef->getEmail(), $targetEmail)) {
                $permission=$this->myPersonPermissions->DEACTIVATE_PERSON_WITHIN_INSTITUTION;
                return $this->setRoleActiveStatus(FALSE, $targetEmail,2**$permission);
            } else {
                throw new LowRoleForSuchActionException("The targeted person has a higher role level");
            }

        } else {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }
    }

    private function deactivatePersonOutsideInstitution(string $targetEmail): bool
    {
        //REQUIRED_PERMISSION=$DEACTIVATE_PERSON_OUTSIDE_INSTITUTION=8
        if ($this->myPersonPermissions->getPermissionsFromBitArray($this->myPersonPermissions->DEACTIVATE_PERSON_OUTSIDE_INSTITUTION)) {

            if ($this->compareRoleLevel($this->myPersonRef->getEmail(), $targetEmail)) {

                $permission=$this->myPersonPermissions->DEACTIVATE_PERSON_OUTSIDE_INSTITUTION;
                return $this->setRoleActiveStatus(false, $targetEmail,2**$permission);

            } else {
                throw new LowRoleForSuchActionException("The targeted person has a higher role level");
            }

        } else {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }

    }

    private function activatePersonOutsideInstitution(string $targetEmail): bool
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

    private function compareRoleLevel(string $actionMakerEmail, string $actionTargetEmail): bool
    {
        //the first has to always be >= the target
        $makerRoleLevel = $this->getRoleLevel($actionMakerEmail);
        $targetRoleLevel = $this->getRoleLevel($actionTargetEmail);
        if ($makerRoleLevel >= $targetRoleLevel) {
            return true;
        }
        return false;
    }

    private function getRoleLevel(string $email): int
    {
        $conn = $this->getDatabaseConnection();
        $sql = "SELECT priority_lvl FROM PersonsHierarchy_view WHERE contact_email=?";
        $params = array($email);
        $stmt = $this->getParameterizedStatement($sql, $conn, $params);
        if ($stmt == false || !sqlsrv_has_rows($stmt)) {

            $this->closeConnection($conn);
            throw new PersonHasNoRolesException("Could not get details of the person roles");
        }
        $lvl = sqlsrv_fetch_array($stmt)[0][0];
        $this->closeConnection($conn);
        return $lvl;
    }

    public function getAllPersonsHierarchy(): array //of persons nested array
    {
        //TODO: ADD PersonActionLogs
        //REQUIRED_PERMISSION=VIEW_ALL_PERSONS_HIERARCHY=2
        if ($this->myPersonPermissions->getPermissionsFromBitArray($this->myPersonPermissions->VIEW_ALL_PERSONS_HIERARCHY)) {
            $sql = "SELECT * FROM PersonsHierarchy_view WHERE gender=? OR gender=? GROUP BY priority_lvl ASC ";
            $params = array('M', 'F');
            return $this->structureBuilder($sql, $params);

        } else {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }

    }

    private function structureBuilder($sql, $params): array //of persons nested array
    {
        //TODO: ADD PersonActionLogs
        $conn = $this->getDatabaseConnection();
        $stmt = $this->getParameterizedStatement($sql, $conn, $params);
        if ($stmt == false || !sqlsrv_has_rows($stmt)) {
            $this->closeConnection($conn);
            throw new SQLStatmentException("Error fetching the required data");
        }
        $hierarchyArray = array();
        $singleArray = array();
        $current_priority = 1;
        while ($row = sqlsrv_fetch($stmt)) {
            $fName = $row[0];
            $mName = $row[1];
            $lName = $row[2];
            $_email = $row[3];
            $gender = $row[4];
            $city = $row[5];
            $phone_number = $row[6];
            $phd = $row[7];
            $bio = $row[8];
            $empTitle = $row[9];
            $priority_lvl = $row[10];
            $job_description = $row[11];
            if ($priority_lvl < $current_priority) {
                $this->closeConnection($conn);
                throw new SQLStatmentException("Bad arrangement of data");
            }
            $personRole = new PersonRole($empTitle, $priority_lvl, $job_description);
            $person = Person::Builder()
                ->setFirstName($fName)
                ->setMiddleName($mName)
                ->setLastName($lName)
                ->setEmail($_email)
                ->setGender($gender)
                ->setCity($city)
                ->setPhd($phd)
                ->setBio($bio)
                ->setRoles(array($personRole))
                ->build();
            if ($priority_lvl == $current_priority) {
                $singleArray[] = $person;
            } else if ($priority_lvl > $current_priority) {
                $hierarchyArray[] = $singleArray;
                $current_priority = $priority_lvl;
                $singleArray = array();
                $singleArray[] = $person;
            }
        }
        $this->closeConnection($conn);
        return $hierarchyArray;


    }

    public function getAllPersonInInstitution(int $institutionID): array //of persons
    {
        //TODO: ADD PersonActionLogs
        //REQUIRED_PERMISSION=VIEW_ALL_PERSONS_IN_INSTITUTION= 1
        if ($this->myPersonPermissions->getPermissionsFromBitArray($this->myPersonPermissions->VIEW_ALL_PERSONS_IN_INSTITUTION)) {
            $sql = "SELECT * FROM PersonsHierarchy_view  WHERE gender=? OR gender=? AND institution_id=? GROUP BY priority_lvl ASC";
            $params = array('M', 'F', $institutionID);
            return $this->structureBuilder($sql, $params);

        } else {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }

    }

    private function getPersonRoleInstitution(string $targetEmail): int //the id of the institution
    {

        $conn = $this->getDatabaseConnection();
        $sql = "SELECT institution_id FROM PersonsHierarchy_view WHERE contact_email=?";
        $params = array($targetEmail);
        $stmt = $this->getParameterizedStatement($sql, $conn, $params);
        if ($stmt == false || !sqlsrv_has_rows($stmt)) {
            $this->closeConnection($conn);
            throw new PersonHasNoRolesException("Could not get details of the person roles");
        }
        $id = sqlsrv_fetch_array($stmt)[0][0];
        $this->closeConnection($conn);
        return $id;


    }


}