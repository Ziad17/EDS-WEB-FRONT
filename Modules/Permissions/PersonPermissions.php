<?php

require 'Permissions.php';
class PersonPermissions extends Permissions
{


    //FIXME: put all of these in db table
    public int $VIEW_PERSON_PROFILE=                        0; //2**0
    public int $VIEW_ALL_PERSONS_IN_INSTITUTION=            1; //2**1
    public int $VIEW_ALL_PERSONS_HIERARCHY=                 2; //2**2
    public int $VIEW_ALL_FILES_FOLDERS_IN_INSTITUTION=      3; //2**n and so on
    public int $DEACTIVATE_PERSON_WITHIN_INSTITUTION=       4;
    public int $ACTIVATE_PERSON_WITHIN_INSTITUTION=         5;
    public int $DELETE_FILES_FOLDERS_IN_INSTITUTION=        6;
    public int $VIEW_ALL_FILES_FOLDERS_OUTSIDE_INSTITUTION= 7;
    public int $DEACTIVATE_PERSON_OUTSIDE_INSTITUTION=      8;
    public int $ACTIVATE_PERSON_OUTSIDE_INSTITUTION=        9;
    public int $DELETE_FILES_FOLDERS_OUTSIDE_INSTITUTION=   10;
    public int $CHANGE_PERSON_ROLE=                         11;

    public function __construct(int $permissionSum)
    {
        $this->permissions_bit_array=array(

        );
        $this->populatePermissionsArray($permissionSum);

    }




    public function populatePermissionsArray(int $permissionSum)
    {
        $this->initAllFalse();
        $this->mapBinaryFormToArray($this->getReversedBinaryForm($permissionSum),$this->permissions_bit_array);


    }


}

