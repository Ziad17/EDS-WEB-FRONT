<?php


class PersonRole
{

    private String $jobTitle;
    private int $priorityLevel;
    private String $jobDesc;
    private String $institution_name;

    /**
     * @return String
     */
    public function getInstitutionName(): string
    {
        return $this->institution_name;
    }

    /**
     * PersonRole constructor.
     * @param String $jobTitle
     * @param int $priorityLevel
     * @param String $jobDesc
     * @param String $institution_name
     */
    public function __construct(string $jobTitle, int $priorityLevel, string $jobDesc, string $institution_name)
    {
        $this->jobTitle = $jobTitle;
        $this->priorityLevel = $priorityLevel;
        $this->jobDesc = $jobDesc;
        $this->institution_name = $institution_name;
    }


    /**
     * @return String
     */
    public function getJobTitle(): string
    {
        return $this->jobTitle;
    }

    /**
     * @return int
     */
    public function getPriorityLevel(): int
    {
        return $this->priorityLevel;
    }

    /**
     * @return String
     */
    public function getJobDesc(): string
    {
        return $this->jobDesc;
    }




}