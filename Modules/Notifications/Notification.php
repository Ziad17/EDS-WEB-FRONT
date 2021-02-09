<?php


class Notification
{
    private int $ID;

    /**
     * @return int
     */
    public function getID(): int
    {
        return $this->ID;
    }
    private String $notificationName;
    private String $senderEmail;
    private String $senderFirstName;
    private String $senderMiddleName;
    private String $senderLastName;
    private bool $seen;
    private DateTime $dateCreated;
    private int $fileID;

    /**
     * Notification constructor.
     * @param int $id
     * @param String $notificationName
     * @param String $senderEmail
     * @param String $senderFirstName
     * @param String $senderMiddleName
     * @param String $senderLastName
     * @param bool $seen
     * @param DateTime $dateCreated
     * @param int $fileID
     */
    public function __construct(int $id,string $notificationName, string $senderEmail, string $senderFirstName, string $senderMiddleName, string $senderLastName, bool $seen, DateTime $dateCreated, int $fileID)
    {
        $this->ID=$id;
        $this->notificationName = $notificationName;
        $this->senderEmail = $senderEmail;
        $this->senderFirstName = $senderFirstName;
        $this->senderMiddleName = $senderMiddleName;
        $this->senderLastName = $senderLastName;
        $this->seen = $seen;
        $this->dateCreated = $dateCreated;
        $this->fileID = $fileID;
    }

    /**
     * @return String
     */
    public function getNotificationName(): string
    {
        return $this->notificationName;
    }

    /**
     * @return String
     */
    public function getSenderEmail(): string
    {
        return $this->senderEmail;
    }

    /**
     * @return String
     */
    public function getSenderFirstName(): string
    {
        return $this->senderFirstName;
    }

    /**
     * @return String
     */
    public function getSenderMiddleName(): string
    {
        return $this->senderMiddleName;
    }

    /**
     * @return String
     */
    public function getSenderLastName(): string
    {
        return $this->senderLastName;
    }

    /**
     * @return bool
     */
    public function isSeen(): bool
    {
        return $this->seen;
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
    public function getFileID(): int
    {
        return $this->fileID;
    }




}