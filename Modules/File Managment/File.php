<?php


class File
{
    private int $ID;
    private string $authorEmail;
    private DateTime $dateCreated;
    private Folder $parentFolder;
    private int $currentVersionID;
    private array $fileVersions; //of file versions

    /**
     * Folder constructor.
     * @param String $authorEmail
     * @param DateTime $dateCreated
     * @param Folder $parentFolder
     * @param Int $currentVersionID
     * @param array $fileVersions
     * @param int $ID
     */
    public function __construct(string $authorEmail, DateTime $dateCreated, Folder $parentFolder, int $currentVersionID, array $fileVersions, int $ID)
    {
        $this->authorEmail = $authorEmail;
        $this->dateCreated = $dateCreated;
        $this->parentFolder = $parentFolder;
        $this->currentVersionID = $currentVersionID;
        $this->fileVersions = $fileVersions;
        $this->ID = $ID;
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
     * @return Folder
     */
    public function getParentFolder(): Folder
    {
        return $this->parentFolder;
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
    public function getFileVersions(): array
    {
        return $this->fileVersions;
    }




    /**
     * @return int
     */
    public function getID(): int
    {
        return $this->ID;
    }
}


