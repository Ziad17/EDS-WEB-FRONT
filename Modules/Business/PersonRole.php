<?php


class PersonRole
{

    private ?string $role_name;


    private ?String $jobTitle;
    private ?int $priorityLevel;
    private ?String $jobDesc;
    private ?String $institution_name;

    public function __construct(PersonRoleBuilder $builder)
    {
        $this->setInstitutionName($builder->getInstitutionName());
        $this->setRoleName($builder->getRoleName());
        $this->setJobTitle($builder->getJobTitle());
        $this->setJobDesc($builder->getJobDesc());
        $this->setPriorityLevel($builder->getPriorityLevel());

    }
    public static function Builder() : PersonRoleBuilder

    {return new PersonRoleBuilder();}



    /**
     * @return string|null
     */
    public function getRoleName(): ?string
    {
        return $this->role_name;
    }

    /**
     * @param string|null $role_name
     */
    public function setRoleName(?string $role_name): void
    {
        $this->role_name = $role_name;
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


    private ?string $role_name="";
    private ?String $jobTitle="";
    private ?int $priorityLevel=0;
    private ?String $jobDesc="";

    private ?String $institution_name="";

    public function build():PersonRole
    {return new PersonRole($this);}


    /**
     * @return string|null
     */
    public function getRoleName(): ?string
    {
        return $this->role_name;
    }

    /**
     * @param string|null $role_name
     */
    public function setRoleName(?string $role_name): PersonRoleBuilder
    {
        $this->role_name = $role_name;
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