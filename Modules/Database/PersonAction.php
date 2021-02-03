<?php
declare(strict_types=1);
require 'Action.php';
class PersonAction extends Action
{
    private PersonPermissions $myPersonPermissions;
    private array $roleAndPermissionSum=array("ROLE"=>0,"PERMISSION_SUM"=>0);

    /**
     * PersonAction constructor.
     * @param Person $myPersonRef
     */
    public function __construct(Person $myPersonRef)
    {
            parent::setConnection($this);
            //TODO throw exceptions
            $this->myPersonRef = $myPersonRef;
            $this->getPersonRoleAndPermissions();
            $this->myPersonPermissions=new PersonPermissions($this->roleAndPermissionSum["PERMISSION_SUM"]);

    }


    public function getPersonRoleAndPermissions()
    {
        //TODO:query to get both role and permission sum

        $this->roleAndPermissionSum["ROLE"]=1;
        $this->roleAndPermissionSum["PERMISSION_SUM"]=1024;

    }
    public function getPersonData(String $email):Person
    {}
    public function getPersonFiles(String $email):array //of files
    {}
    public function activatePerson(String $targetEmail):bool
    {}
    public function deactivatePerson(String $targetEmail):bool
    {}
    public function getAllPersonsHierarchy():array //of persons
    {}
    public function getAllPersonInInstitution(int $institutionID):array //of persons
    {}










}