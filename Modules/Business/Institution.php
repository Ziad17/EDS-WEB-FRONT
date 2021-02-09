<?php

declare(strict_types=1);

class Institution
{
    //TODO:APPLY GENERICS
    private Int $ID;
    private String $name;
    private String $website;
    private bool $insideCampus;


    private array $emails;
    private array $phones;

    /**
     * Institution constructor.
     * @param Int $ID
     * @param String $name
     * @param String $website
     * @param array $emails
     * @param array $phones
     */
    public function __construct( string $name, string $website,bool $insideCampus, array $emails, array $phones)
    {
        $this->insideCampus=$insideCampus;
        $this->name = $name;
        $this->website = $website;
        $this->emails = $emails;
        $this->phones = $phones;
    }




    /**
     * @return Int
     */
    public function getID(): int
    {
        return $this->ID;
    }
    /**
     * @return bool
     */
    public function isInsideCampus(): bool
    {
        return $this->insideCampus;
    }

    /**
     * @return String
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return String
     */
    public function getWebsite(): string
    {
        return $this->website;
    }

    /**
     * @return array
     */
    public function getEmails(): array
    {
        return $this->emails;
    }

    /**
     * @return array
     */
    public function getPhones(): array
    {
        return $this->phones;
    }


}