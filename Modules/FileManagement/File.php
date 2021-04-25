<?php


class File
{
    private int $ID;

    private string $authorEmail;
    private DateTime $dateCreated;
    private int $parentFolderid;
    private FileVersion $currentVersion;
    private array $fileVersions; //of file versions

    private bool $locked;
    private DateTime $lockedUntil;
    private bool $active;

    /**
     * File constructor.
     * @param int $ID
     * @param string $authorEmail
     * @param DateTime $dateCreated
     * @param int $parentFolderid
     * @param FileVersion $currentVersion
     * @param array $fileVersions
     * @param bool $locked
     * @param DateTime $lockedUntil
     * @param bool $active
     */
    public function __construct(int $ID, string $authorEmail, DateTime $dateCreated, int $parentFolderid, FileVersion $currentVersion, array $fileVersions, bool $locked, DateTime $lockedUntil, bool $active)
    {
        $this->ID = $ID;
        $this->authorEmail = $authorEmail;
        $this->dateCreated = $dateCreated;
        $this->parentFolderid = $parentFolderid;
        $this->currentVersion = $currentVersion;
        $this->fileVersions = $fileVersions;
        $this->locked = $locked;
        $this->lockedUntil = $lockedUntil;
        $this->active = $active;
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

    /**
     * @return bool
     */
    public function isLocked(): bool
    {
        return $this->locked;
    }

    /**
     * @return DateTime
     */
    public function getLockedUntil(): DateTime
    {
        return $this->lockedUntil;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }
}


