<?php


class Folder
{


    private Int $ID;
    private String $authorEmail;
    private DateTime $dateCreated;
    private Int $parentFolderID;
    private Int $currentVersionID;
    private array $folderVersions;

    /**
     * Folder constructor.
     * @param Int $ID
     * @param String $authorEmail
     * @param DateTime $dateCreated
     * @param Int $parentFolderID
     * @param Int $currentVersionID
     * @param array $folderVersions
     */
    public function __construct(int $ID, string $authorEmail, DateTime $dateCreated, int $parentFolderID, int $currentVersionID, array $folderVersions)
    {
        $this->ID = $ID;
        $this->authorEmail = $authorEmail;
        $this->dateCreated = $dateCreated;
        $this->parentFolderID = $parentFolderID;
        $this->currentVersionID = $currentVersionID;
        $this->folderVersions = $folderVersions;
    }


    /**
     * @return Int
     */
    public function getID(): int
    {
        return $this->ID;
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
    public function getParentFolderID(): int
    {
        return $this->parentFolderID;
    }

    /**
     * @return Int
     */
    public function getCurrentVersionID(): int
    {
        return $this->currentVersionID;
    }

    /**
     * @return array
     */
    public function getFolderVersions(): array
    {
        return $this->folderVersions;
    }






}