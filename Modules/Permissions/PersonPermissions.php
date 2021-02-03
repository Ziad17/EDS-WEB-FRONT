<?php

require 'Permissions.php';
class PersonPermissions extends Permissions
{

    private Int $ROLE_ORDER;
    //FIXME: put all of these in db table
    private int $VIEW_PERSON_PROFILE=                        1;
    private int $VIEW_ALL_PERSONS_IN_INSTITUTION=            2;
    private int $VIEW_ALL_PERSONS_HIERARCHY=                 4;
    private int $VIEW_ALL_FILES_FOLDERS_IN_INSTITUTION=      8;
    private int $DEACTIVATE_PERSON_WITHIN_INSTITUTION=       16;
    private int $ACTIVATE_PERSON_WITHIN_INSTITUTION=         32;
    private int $DELETE_FILES_FOLDERS_IN_INSTITUTION=        64;
    private int $VIEW_ALL_FILES_FOLDERS_OUTSIDE_INSTITUTION= 128;
    private int $DEACTIVATE_PERSON_OUTSIDE_INSTITUTION=      256;
    private int $ACTIVATE_PERSON_OUTSIDE_INSTITUTION=        512;
    private int $DELETE_FILES_FOLDERS_OUTSIDE_INSTITUTION=   1024;
    private int $CHANGE_PERSON_ROLE=                         2048;
    //private int $CREATE_REPO=                           4096;
    //private int $CREATE_REPO=                           8192;
    //private int $CREATE_REPO=                           16384;
    //private int $CREATE_REPO=                           32768;
    //private int $CREATE_REPO=                           65536;
    public function __construct(int $permissionSum)
    {
        $this->permissions_bit_array=array(
            $this->VIEW_PERSON_PROFILE=>false,
            $this->VIEW_ALL_PERSONS_IN_INSTITUTION=>false,
            $this->VIEW_ALL_PERSONS_HIERARCHY=>false,
            $this->VIEW_ALL_FILES_FOLDERS_IN_INSTITUTION=>false,
            $this->DEACTIVATE_PERSON_WITHIN_INSTITUTION=>false,
            $this->ACTIVATE_PERSON_WITHIN_INSTITUTION=>false,
            $this->DELETE_FILES_FOLDERS_IN_INSTITUTION=>false,
            $this->VIEW_ALL_FILES_FOLDERS_OUTSIDE_INSTITUTION=>false,
            $this->DEACTIVATE_PERSON_OUTSIDE_INSTITUTION=>false,
            $this->ACTIVATE_PERSON_OUTSIDE_INSTITUTION=>false,
            $this->DELETE_FILES_FOLDERS_OUTSIDE_INSTITUTION=>false,
            $this->CHANGE_PERSON_ROLE=>false,
        );
        $this->populatePermissionsArray($permissionSum);

    }




    public function populatePermissionsArray(int $permissionSum)
    {
        $this->initAllFalse();
        $this->mapBinaryFormToArray($this->getReversedBinaryForm($permissionSum),$this->permissions_bit_array);


    }


}
$p=new PersonPermissions(200);
print_r($p->getPermissionsBitArray());
