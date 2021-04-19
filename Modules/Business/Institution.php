<?php

declare(strict_types=1);

class Institution
{
    //TODO:APPLY GENERICS
    private ?Int $ID;
    private ?String $name;
    private ?String $type;
    private ?bool $active;
    private ?Int $level;
    private ?String $parent;
    private ?bool $insideCampus;
    private ?String $fax;
    private ?String $primaryPhone;
    private ?String $secondaryPhone;
    private ?String $email;
    private ?String $website;

    private ?string $institution_img;

    /**
     * @return string
     */
    public function getInstitutionImg(): ?string
    {
        return $this->institution_img;
    }

    /**
     * @param string $institution_img
     */
    public function setInstitutionImg(?string $institution_img): void
    {
        $this->institution_img = $institution_img;
    }
    /**
     * @return String
     */
    public function getWebsite(): ?string
    {
        return $this->website;
    }

    /**
     * @param String $website
     */
    public function setWebsite(?string $website): void
    {
        $this->website = $website;
    }

    public function __construct(InstitutionBuilder $builder)
    {
        $this->setID($builder->getID());
        $this->setName($builder->getName());

        $this->setWebsite($builder->getWebsite());

        $this->setEmail($builder->getEmail());
        $this->setActive($builder->isActive());
        $this->setFax($builder->getFax());
        $this->setPrimaryPhone($builder->getPrimaryPhone());
        $this->setSecondaryPhone($builder->getSecondaryPhone());
        $this->setLevel($builder->getLevel());
        $this->setType($builder->getType());
        $this->setInstitutionImg($builder->getInstitutionImg());
        //FIXME:: ERROR HERE
        $this->setParent($builder->getParent());


    }
    public static function Builder() : InstitutionBuilder

    {return new InstitutionBuilder();}


    /**
     * @return Int
     */
    public function getID(): ?int
    {
        return $this->ID;
    }

    /**
     * @return String
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return String
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isActive(): ?bool
    {
        return $this->active;
    }

    /**
     * @return Int
     */
    public function getLevel(): ?int
    {
        return $this->level;
    }

    /**
     * @return Institution
     */
    public function getParent(): ?String
    {
        return $this->parent;
    }

    /**
     * @return bool
     */
    public function isInsideCampus(): ?bool
    {
        return $this->insideCampus;
    }

    /**
     * @return String
     */
    public function getFax(): ?string
    {
        return $this->fax;
    }

    /**
     * @return String
     */
    public function getPrimaryPhone(): ?string
    {
        return $this->primaryPhone;
    }

    /**
     * @return String
     */
    public function getSecondaryPhone(): ?string
    {
        return $this->secondaryPhone;
    }

    /**
     * @return String
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }



    /**
     * @param Int $ID
     */
    private function setID(?int $ID): void
    {
        $this->ID = $ID;
    }

    /**
     * @param String $name
     */
    private function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param String $type
     */
    private function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @param bool $active
     */
    private function setActive(?bool $active): void
    {
        $this->active = $active;
    }

    /**
     * @param Int $level
     */
    private function setLevel(?int $level): void
    {
        $this->level = $level;
    }

    /**
     * @param String $parent
     */
    private function setParent(?String $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @param bool $insideCampus
     */
    private function setInsideCampus(?bool $insideCampus): void
    {
        $this->insideCampus = $insideCampus;
    }

    /**
     * @param String $fax
     */
    private function setFax(?string $fax): void
    {
        $this->fax = $fax;
    }

    /**
     * @param String $primaryPhone
     */
    private function setPrimaryPhone(?string $primaryPhone): void
    {
        $this->primaryPhone = $primaryPhone;
    }

    /**
     * @param String $secondaryPhone
     */
    private function setSecondaryPhone(?string $secondaryPhone): void
    {
        $this->secondaryPhone = $secondaryPhone;
    }

    /**
     * @param String $email
     */
    private function setEmail(?string $email): void
    {
        $this->email = $email;
    }



}
class InstitutionBuilder
{
    private ?Int $ID=0;
    private ?String $name="";
    private ?String $type="";
    private ?bool $active=false;
    private ?Int $level=0;
    private ?String $parent="";
    private ?bool $insideCampus=false;
    private ?String $fax="";
    private ?String $primaryPhone="";
    private ?String $secondaryPhone="";
    private String $email="";
    private ?string $website="";
    private ?string $institution_img="";

    /**
     * @return string|null
     */
    public function getInstitutionImg(): ?string
    {
        return $this->institution_img;
    }

    /**
     * @param string|null $institution_img
     */
    public function setInstitutionImg(?string $institution_img): InstitutionBuilder
    {
        $this->institution_img = $institution_img;
        return $this;
    }

    /**
     * @return string
     */
    public function getWebsite(): ?string
    {
        return $this->website;
    }

    /**
     * @param string $website
     */
    public function setWebsite(?string $website): InstitutionBuilder
    {
        $this->website = $website;
        return $this;
    }

    public function build():Institution

{
    return new Institution($this);
}



    /**
     * @return int
     */
    public function getID(): ?int
    {
        return $this->ID;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isActive(): ?bool
    {
        return $this->active;
    }

    /**
     * @return int
     */
    public function getLevel(): ?int
    {
        return $this->level;
    }

    /**
     * @return string
     */
    public function getParent():?String
    {
        return $this->parent;
    }

    /**
     * @return bool
     */
    public function isInsideCampus(): ?bool
    {
        return $this->insideCampus;
    }

    /**
     * @return string
     */
    public function getFax(): ?string
    {
        return $this->fax;
    }

    /**
     * @return string
     */
    public function getPrimaryPhone(): ?string
    {
        return $this->primaryPhone;
    }

    /**
     * @return string
     */
    public function getSecondaryPhone(): ?string
    {
        return $this->secondaryPhone;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }


    /**
     * @param int $ID
     */
    public function setID(?int $ID): InstitutionBuilder
    {
        $this->ID = $ID;
        return $this;
    }

    /**
     * @param string $name
     */
    public function setName(?string $name): InstitutionBuilder
    {
        $this->name = $name;
        return $this;

    }

    /**
     * @param string $type
     */
    public function setType(?string $type): InstitutionBuilder
    {
        $this->type = $type;        return $this;

    }

    /**
     * @param bool $active
     */
    public function setActive(?bool $active): InstitutionBuilder
    {
        $this->active = $active;        return $this;

    }

    /**
     * @param int $level
     */
    public function setLevel(?int $level): InstitutionBuilder
    {
        $this->level = $level;        return $this;

    }

    /**
     * @param String $parent
     */
    public function setParent(?String $parent): InstitutionBuilder
    {
        $this->parent = $parent;        return $this;

    }

    /**
     * @param bool $insideCampus
     */
    public function setInsideCampus(?bool $insideCampus): InstitutionBuilder
    {
        $this->insideCampus = $insideCampus;        return $this;

    }

    /**
     * @param string $fax
     */
    public function setFax(?string $fax): InstitutionBuilder
    {
        $this->fax = $fax;        return $this;

    }

    /**
     * @param string $primaryPhone
     */
    public function setPrimaryPhone(?string $primaryPhone): InstitutionBuilder
    {
        $this->primaryPhone = $primaryPhone;        return $this;

    }

    /**
     * @param string $secondaryPhone
     */
    public function setSecondaryPhone(?string $secondaryPhone): InstitutionBuilder
    {
        $this->secondaryPhone = $secondaryPhone;
        return $this;}

    /**
     * @param string $email
     */
    public function setEmail(?string $email): InstitutionBuilder
    {
        $this->email = $email;
        return $this;
    }



}