<?php
declare(strict_types=1);
require 'Action.php';
class PersonAction extends Action
{
    private PersonPermissions $myPersonPermissions;
    private PersonRef $myPersonRef;

    /**
     * PersonAction constructor.
     * @param PersonPermissions $myPersonPermissions
     * @param PersonRef $myPersonRef
     */
    public function __construct(PersonPermissions $myPersonPermissions, PersonRef $myPersonRef,DatabaseConnection $db)
    {
        $this->databaseConnection=$db;
        $this->myPersonPermissions = $myPersonPermissions;
        $this->myPersonRef = $myPersonRef;
    }


    public function getPersonData(String $email):Person
    {}
    public function getPersonFiles(String $email):Person
    {}
    public function activatePerson(String $targetEmail):Person
    {}
    public function deactivatePerson(String $targetEmail):Person
    {}
    public function getAllPersonsHierarchy():Person
    {}
    public function getAllPersonInInstitution():Person
    {}



getPersonData	String Email	Person
getPersonFiles	String Email	collection of Files
activatePerson 	String targetEmail	Boolean
deactivatePerson	String targetEmail	Boolean
getAllPersonsHierarchy	-	Tree-Like structure represents all persons
getAllPersonInInstitution	Int InstitutionID	Tree-Like structure represents all persons






}