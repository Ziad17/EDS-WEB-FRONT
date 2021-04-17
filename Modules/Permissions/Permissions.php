<?php


abstract class Permissions
{
    //TODO: pull the permissions dynamically from the db
    public array $permissions_bit_array;

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
    public  function initAllFalse(int $COUNT)
    {
        for ( $i=0;$i<$COUNT;$i++)
        {
            $this->permissions_bit_array[]=false;
        }
    }

    public function getReversedBinaryForm(int $permissionSum) : String
    {
        return strrev(decbin($permissionSum));
    }

    public function populatePermissionsArray(int $permissionSum,int $COUNT)
    {
        $this->initAllFalse($COUNT);
        $this->mapBinaryFormToArray($this->getReversedBinaryForm($permissionSum),$this->permissions_bit_array);


    }

    public function mapBinaryFormToArray(String $binaryForm,array &$array)
    {
        for($i=0;$i<strlen($binaryForm);$i++)
        {
            if($binaryForm[$i]=="1")
            $array[$i]=true;
            else
            {
                $array[$i]=false;
            }

        }

    }



}