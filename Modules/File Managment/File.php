<?php


class File
{
    private int $ID;
    private string $authorEmail;
    private DateTime $dateCreated;
    private int $parentFolderid;
    private FileVersion $currentVersion;
    private array $fileVersions; //of file versions

    /**
     * Folder constructor.
     * @param String $authorEmail
     * @param DateTime $dateCreated
     * @param int $parentFolder
     * @param FileVersion $currentVersion
     * @param array $fileVersions
     * @param int $ID
     */
    public function __construct(string $authorEmail, DateTime $dateCreated, int $parentFolder, FileVersion $currentVersion, array $fileVersions, int $ID)
    {
        $this->authorEmail = $authorEmail;
        $this->dateCreated = $dateCreated;
        $this->parentFolderid = $parentFolder;
        $this->currentVersion = $currentVersion;
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
     * @return int
     */
    public function getParentFolderid(): int
    {
        return $this->parentFolderid;
    }

    /**
     * @return FileVersion
     */
    public function getCurrentVersion(): FileVersion
    {
        return $this->currentVersion;
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


