<?php


class City
{
    private String $name;
    private String $shortcut;
    private int $postalCode;

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
    public function getShortcut(): string
    {
        return $this->shortcut;
    }

    /**
     * @return int
     */
    public function getPostalCode(): int
    {
        return $this->postalCode;
    }

    /**
     * City constructor.
     * @param String $name
     * @param String $shortcut
     * @param int $postalCode
     */
    public function __construct( string $shortcut,string $name, int $postalCode)
    {
        $this->name = $name;
        $this->shortcut = $shortcut;
        $this->postalCode = $postalCode;
    }

}