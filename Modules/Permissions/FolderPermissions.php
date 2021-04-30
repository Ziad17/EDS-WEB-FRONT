<?php
require_once 'Permissions.php';


class FolderPermissions extends Permissions
{
    //these permissions imitates permissions in FilePermissions Table
    public int $VIEW_FOLDER=                               0; //2**0=1
    public int $SHOW_VERSIONS_OF_A_FOLDER=                 1; //2**1=2
    public int $MODIFY_FOLDER_ADDS_NEW_FILE=               2; //2**2=4
    public int $MODIFY_FOLDER_ADDS_NEW_FOLDER=             3; //2**3=8




    public function __construct(int $permissionSum)
    {
        $this->permissions_bit_array=array();
        $this->populatePermissionsArray($permissionSum);

    }



}