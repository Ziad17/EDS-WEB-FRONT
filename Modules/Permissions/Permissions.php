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

    public abstract function populatePermissionsArray(int $permissionSum);
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