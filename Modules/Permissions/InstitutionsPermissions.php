<?php
require_once "Modules/Permissions/Permissions.php";




class InstitutionsPermissions extends Permissions
{
    //these permissions imitates permissions in FilePermissions Table

    public int $VIEW_PERSONS_IN_INSTITUTION = 0; //2**0=1
    public int $CREATE_INSTITUTION = 1; //2**1=2
    public int $DELETE_INSTITUTION = 2; //2**2=4
    public int $CREATE_INSTITUTION_TYPE = 3;
    public int $EDIT_INSTITUTION = 4;
    public int $CREATE_ROLE = 5;
    public int $EDIT_ROLE = 6;

    public int $COUNT=7;

    public function __construct(int $permissionSum)
    {
        $this->permissions_bit_array = array();
        $this->populatePermissionsArray($permissionSum,$this->COUNT);


    }
}