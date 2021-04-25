<?php

require_once PERMISSIONS_BASE_PATH."/Permissions.php";


class FilePermissions extends Permissions
{


    //these permissions imitates permissions in FilePermissions Table
    public int $VIEW_FILE=                               0; //2**0=1
    public int $SHOW_VERSIONS_OF_A_FILE=                 1; //2**1=2
    public int $LOCK_FILE=                               2; //2**2=4
    public int $UNLOCK_FILE=                             3; //2**3=8
    public int $MODIFY_FILE_ADDS_NEW_VERSION=            4; //2**4=16
    public int $REVERT_CURRENT_FILE_VERSION=             5; //2**5=32
    public int $DELETE_FILE=                             6; //2**6=64


    public function __construct(int $permissionSum)
    {
        $this->permissions_bit_array=array();
        $this->populatePermissionsArray($permissionSum);

    }




}