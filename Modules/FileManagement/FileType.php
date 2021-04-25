<?php


class FileType
{
    private String $typeName;
    private String $extension;

    /**
     * FileType constructor.
     * @param String $typeName
     * @param String $extension
     */
    public function __construct(string $typeName, string $extension)
    {
        $this->typeName = $typeName;
        $this->extension = $extension;
    }

    /**
     * @return String
     */
    public function getTypeName(): string
    {
        return $this->typeName;
    }

    /**
     * @return String
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

}