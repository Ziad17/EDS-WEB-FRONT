<?php


class PersonRole
{

    private ?int $ID;


    private ?String $jobTitle;
    private ?int $priorityLevel;
    private ?String $jobDesc;
    private ?String $institution_name;
    private ?int $filesPermissionsSum;
    private ?int $personsPermissionsSum;
    private ?int $foldersPermissionsSum;
    private ?int $institutionsPermissionsSum;

    /**
     * @return int|null
     */
    public function getFilesPermissionsSum(): ?int
    {
        return $this->filesPermissionsSum;
    }

    /**
     * @param int|null $filesPermissionsSum
     */
    public function setFilesPermissionsSum(?int $filesPermissionsSum): void
    {
        $this->filesPermissionsSum = $filesPermissionsSum;
    }

    /**
     * @return int|null
     */
    public function getPersonsPermissionsSum(): ?int
    {
        return $this->personsPermissionsSum;
    }

    /**
     * @param int|null $personsPermissionsSum
     */
    public function setPersonsPermissionsSum(?int $personsPermissionsSum): void
    {
        $this->personsPermissionsSum = $personsPermissionsSum;
    }

    /**
     * @return int|null
     */
    public function getFoldersPermissionsSum(): ?int
    {
        return $this->foldersPermissionsSum;
    }

    /**
     * @param int|null $foldersPermissionsSum
     */
    public function setFoldersPermissionsSum(?int $foldersPermissionsSum): void
    {
        $this->foldersPermissionsSum = $foldersPermissionsSum;
    }

    /**
     * @return int|null
     */
    public function getInstitutionsPermissionsSum(): ?int
    {
        return $this->institutionsPermissionsSum;
    }

    /**
     * @param int|null $institutionsPermissionsSum
     */
    public function setInstitutionsPermissionsSum(?int $institutionsPermissionsSum): void
    {
        $this->institutionsPermissionsSum = $institutionsPermissionsSum;
    }

    public function __construct(PersonRoleBuilder $builder)
    {
        $this->setInstitutionName($builder->getInstitutionName());
        $this->setID($builder->getID());
        $this->setJobTitle($builder->getJobTitle());
        $this->setJobDesc($builder->getJobDesc());
        $this->setPriorityLevel($builder->getPriorityLevel());
        $this->setFilesPermissionsSum($builder->getFilesPermissionsSum());
        $this->setFoldersPermissionsSum($builder->getFoldersPermissionsSum());
        $this->setInstitutionsPermissionsSum($builder->getInstitutionsPermissionsSum());
        $this->setPersonsPermissionsSum($builder->getPersonsPermissionsSum());

    }
    public static function Builder() : PersonRoleBuilder

    {return new PersonRoleBuilder();}



    /**
     * @return int|null
     */
    public function getID(): ?int
    {
        return $this->ID;
    }

    /**
     * @param int|null $ID
     */
    public function setID(?int $ID): void
    {
        $this->ID = $ID;
    }

    /**
     * @return String|null
     */
    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    /**
     * @param String|null $jobTitle
     */
    public function setJobTitle(?string $jobTitle): void
    {
        $this->jobTitle = $jobTitle;
    }

    /**
     * @return int|null
     */
    public function getPriorityLevel(): ?int
    {
        return $this->priorityLevel;
    }

    /**
     * @param int|null $priorityLevel
     */
    public function setPriorityLevel(?int $priorityLevel): void
    {
        $this->priorityLevel = $priorityLevel;
    }

    /**
     * @return String|null
     */
    public function getJobDesc(): ?string
    {
        return $this->jobDesc;
    }

    /**
     * @param String|null $jobDesc
     */
    public function setJobDesc(?string $jobDesc): void
    {
        $this->jobDesc = $jobDesc;
    }

    /**
     * @return String|null
     */
    public function getInstitutionName(): ?string
    {
        return $this->institution_name;
    }

    /**
     * @param String|null $institution_name
     */
    public function setInstitutionName(?string $institution_name): void
    {
        $this->institution_name = $institution_name;
    }




}
class PersonRoleBuilder
{


    private ?int $ID=0;
    private ?String $jobTitle="";
    private ?int $priorityLevel=0;
    private ?String $jobDesc="";
    private ?int $filesPermissionsSum=0;
    private ?int $personsPermissionsSum=0;
    private ?int $foldersPermissionsSum=0;
    private ?int $institutionsPermissionsSum=0;

    /**
     * @return int|null
     */
    public function getFilesPermissionsSum(): ?int
    {
        return $this->filesPermissionsSum;
    }

    /**
     * @param int|null $filesPermissionsSum
     */
    public function setFilesPermissionsSum(?int $filesPermissionsSum): PersonRoleBuilder
    {
        $this->filesPermissionsSum = $filesPermissionsSum;
        return $this;

    }

    /**
     * @return int|null
     */
    public function getPersonsPermissionsSum(): ?int
    {
        return $this->personsPermissionsSum;
    }

    /**
     * @param int|null $personsPermissionsSum
     */
    public function setPersonsPermissionsSum(?int $personsPermissionsSum): PersonRoleBuilder
    {
        $this->personsPermissionsSum = $personsPermissionsSum;
        return $this;

    }

    /**
     * @return int|null
     */
    public function getFoldersPermissionsSum(): ?int
    {
        return $this->foldersPermissionsSum;
    }

    /**
     * @param int|null $foldersPermissionsSum
     */
    public function setFoldersPermissionsSum(?int $foldersPermissionsSum): PersonRoleBuilder
    {
        $this->foldersPermissionsSum = $foldersPermissionsSum;
        return $this;

    }

    /**
     * @return int|null
     */
    public function getInstitutionsPermissionsSum(): ?int
    {
        return $this->institutionsPermissionsSum;
    }

    /**
     * @param int|null $institutionsPermissionsSum
     */
    public function setInstitutionsPermissionsSum(?int $institutionsPermissionsSum): PersonRoleBuilder
    {
        $this->institutionsPermissionsSum = $institutionsPermissionsSum;
        return $this;

    }
    private ?String $institution_name="";

    public function build():PersonRole
    {return new PersonRole($this);}


    /**
     * @return int|null
     */
    public function getID(): ?int
    {
        return $this->ID;
    }

    /**
     * @param int|null $ID
     */
    public function setID(?int $ID): PersonRoleBuilder
    {
        $this->ID = $ID;
        return $this;
    }

    /**
     * @return String|null
     */
    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    /**
     * @param String|null $jobTitle
     */
    public function setJobTitle(?string $jobTitle): PersonRoleBuilder
    {
        $this->jobTitle = $jobTitle;
        return $this;

    }

    /**
     * @return int|null
     */
    public function getPriorityLevel(): ?int
    {
        return $this->priorityLevel;
    }

    /**
     * @param int|null $priorityLevel
     */
    public function setPriorityLevel(?int $priorityLevel): PersonRoleBuilder
    {
        $this->priorityLevel = $priorityLevel;
        return $this;

    }

    /**
     * @return String|null
     */
    public function getJobDesc(): ?string
    {
        return $this->jobDesc;
    }

    /**
     * @param String|null $jobDesc
     */
    public function setJobDesc(?string $jobDesc): PersonRoleBuilder
    {
        $this->jobDesc = $jobDesc;
        return $this;

    }

    /**
     * @return String|null
     */
    public function getInstitutionName(): ?string
    {
        return $this->institution_name;
    }

    /**
     * @param String|null $institution_name
     */
    public function setInstitutionName(?string $institution_name): PersonRoleBuilder
    {
        $this->institution_name = $institution_name;
        return $this;

    }

}