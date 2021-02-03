<?php


class FileVersion
{


    private Int $ID;
    private Int $FileID;
    private String $Note;
    private String $Name;
    private String $authorEmail;
    private String $fileContentURL;
    private FileType $fileExtension;
    private Int $Number;
    private DateTime $dateCreated;
    private Int $sizeInBytes;

    /**
     * FileVersion constructor.
     * @param Int $ID
     * @param Int $FileID
     * @param String $Note
     * @param String $Name
     * @param String $authorEmail
     * @param String $fileContent
     * @param String $fileExtension
     * @param Int $Number
     * @param DateTime $dateCreated
     * @param Int $Size
     */
    public function __construct(int $ID, int $FileID, string $Note, string $Name, string $authorEmail, string $fileContent, FileType $fileExtension, int $Number, DateTime $dateCreated, int $Size)
    {
        $this->ID = $ID;
        $this->FileID = $FileID;
        $this->Note = $Note;
        $this->Name = $Name;
        $this->authorEmail = $authorEmail;
        $this->fileContentURL = $fileContent;
        $this->fileExtension = $fileExtension;
        $this->Number = $Number;
        $this->dateCreated = $dateCreated;
        $this->sizeInBytes = $Size;
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
    public function getFileID(): int
    {
        return $this->FileID;
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
     * @return String
     */
    public function getFileContentURL(): string
    {
        return $this->fileContentURL;
    }

    /**
     * @return String
     */
    public function getFileExtension(): FileType
    {
        return $this->fileExtension;
    }

    /**
     * @return Int
     */
    public function getNumber(): int
    {
        return $this->Number;
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
    public function getSizeInBytes(): int
    {
        return $this->sizeInBytes;
    }





}