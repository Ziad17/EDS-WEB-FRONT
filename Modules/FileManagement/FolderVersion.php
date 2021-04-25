<?php


class FolderVersion
{

    private Int $ID;
    private Int $folderID;
    private String $Note;
    private String $Name;
    private String $authorEmail;
    private DateTime $dateCreated;
    private Int $Number;

    /**
     * FolderVersion constructor.
     * @param Int $ID
     * @param Int $folderID
     * @param String $Note
     * @param String $Name
     * @param String $authorEmail
     * @param DateTime $dateCreated
     * @param Int $Number
     */
    public function __construct(int $ID, int $folderID, string $Note, string $Name, string $authorEmail, DateTime $dateCreated, int $Number)
    {
        $this->ID = $ID;
        $this->folderID = $folderID;
        $this->Note = $Note;
        $this->Name = $Name;
        $this->authorEmail = $authorEmail;
        $this->dateCreated = $dateCreated;
        $this->Number = $Number;
    }


    /**
     * @return Int
     */
    public function getID(): int
    {
        return $this->ID;
    }

    /**
     * @return Int
     */
    public function getFolderID(): int
    {
        return $this->folderID;
    }

    /**
     * @return String
     */
    public function getNote(): string
    {
        return $this->Note;
    }

    /**
     * @return String
     */
    public function getName(): string
    {
        return $this->Name;
    }

    /**
     * @return String
     */
    public function getAuthorEmail(): string
    {
        return $this->authorEmail;
    }

    /**
     * @return DateTime
     */
    public function getDateCreated(): DateTime
    {
        return $this->dateCreated;
    }

    /**
     * @return Int
     */
    public function getNumber(): int
    {
        return $this->Number;
    }








}