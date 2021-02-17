<?php


class Folder
{


    private int $ID;
    private String $name;
    private String $notes;
    private string $authorEmail;
    private DateTime $dateCreated;
    private int $parentFolderID;
    private int $currentVersionID;
    private array $folderVersions;
    private array $filesInFolder; //array of files ids
    private array $foldersInFolder; //array of folders ids

    /**
* Folder constructor.
* @param int $ID
* @param String $name
* @param String $notes
* @param string $authorEmail
* @param DateTime $dateCreated
* @param int $parentFolderID
* @param int $currentVersionID
* @param array $folderVersions
* @param array $filesInFolder
* @param array $foldersInFolder
*/public function __construct(int $ID, string $name, string $notes, string $authorEmail, DateTime $dateCreated, int $parentFolderID, int $currentVersionID, array $folderVersions, array $filesInFolder, array $foldersInFolder)
{
    $this->ID = $ID;
    $this->name = $name;
    $this->notes = $notes;
    $this->authorEmail = $authorEmail;
    $this->dateCreated = $dateCreated;
    $this->parentFolderID = $parentFolderID;
    $this->currentVersionID = $currentVersionID;
    $this->folderVersions = $folderVersions;
    $this->filesInFolder = $filesInFolder;
    $this->foldersInFolder = $foldersInFolder;
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
    public function getNotes(): string
    {
        return $this->notes;
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
     * @return array
     */
    public function getFoldersInFolder(): array
    {
        return $this->foldersInFolder;
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

    /**
     * @return array
     */
    public function getFilesInFolder(): array
    {
        return $this->filesInFolder;
    }


}