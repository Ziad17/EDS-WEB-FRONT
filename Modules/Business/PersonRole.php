<?php


class PersonRole
{

    private String $jobTitle;
    private int $priorityLevel;
    private String $jobDesc;

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

    /**
     * PersonRole constructor.
     * @param String $jobTitle
     * @param int $priorityLevel
     * @param String $institution
     */
    public function __construct(string $jobTitle, int $priorityLevel, string $institution)
    {
        $this->jobTitle = $jobTitle;
        $this->priorityLevel = $priorityLevel;
        $this->jobDesc = $institution;
    }


}