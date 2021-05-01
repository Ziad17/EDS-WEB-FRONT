<?php


class InstitutionType
{
    private int $id;
    private string $type;
    private string $description;

    /**
     * InstitutionType constructor.
     * @param int $id
     * @param string $type
     * @param string $description
     */
    public function __construct(int $id, string $type, string $description)
    {
        $this->id = $id;
        $this->type = $type;
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

}