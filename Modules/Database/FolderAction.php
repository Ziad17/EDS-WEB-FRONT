<?php


class FolderAction extends Action
{

    private FolderPermissions $myFoldersPermissions;


    public function getMyFoldersPermissions() : FolderPermissions
    {
        return $this->myFoldersPermissions;
    }



    public function __construct(FolderPermissions $myFoldersPermission, Person $myPersonRef)
    {
        parent::setConnection($this);
        //TODO throw exceptions
        $this->myFoldersPermissions = $myFoldersPermission;
        $this->myPersonRef = $myPersonRef;
    }

}