<?php


abstract class Permissions
{
    //TODO: pull the permissions dynamically from the db
    protected array $permissions_bit_array;

    /**
     * @return array
     */
    public function getPermissionsBitArray(): array
    {
        return $this->permissions_bit_array;
    }
    public function getPermissionsFromBitArray(int $index): bool
    {
        return $this->permissions_bit_array[$index];
    }
    public  function initAllFalse()
    {
        foreach ($this->permissions_bit_array as $member)
        {
            $this->permissions_bit_array[$member]=false;
        }
    }

    public function getReversedBinaryForm(int $permissionSum) : String
    {
        return strrev(decbin($permissionSum));
    }

    public function populatePermissionsArray(int $permissionSum)
    {
        $this->initAllFalse();
        $this->mapBinaryFormToArray($this->getReversedBinaryForm($permissionSum),$this->permissions_bit_array);


    }

    public function mapBinaryFormToArray(String $binaryForm,array &$array)
    {
        for($i=0;$i<strlen($binaryForm);$i++)
        {
            if($binaryForm[$i]=="1")
            $array[2**$i]="true";
            else
            {
                $array[2**$i]="false";
            }

        }

    }



}