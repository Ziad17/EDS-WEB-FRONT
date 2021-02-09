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


    // public function getMyPersonFolderPermissions()
    // {}



    public function createFile(File $fileToCreate,FileVersion $fileVersion, int $parentFolderID, array $personsToShareWith) : bool
    {
        /*
         * TODO: Steps
         * [1]check both folder and file permissions xx
         * [2]prepare quires
         * [3]
         *
         *
         *
         *
         * */
        $conn=$this->getDatabaseConnection();
        $sql="SELECT file_permissions_sum  FROM PesonFileRoles WHERE file_id=? AND person_id=?";
        $params=array("$fileID","$personID");
        $stmt=$this->getParameterizedStatement($sql,$conn,$params);
        if($stmt==false)
        {
            throw new PermissionsCriticalFail("Couldn't load the permissions on this file");
        }
        if(sqlsrv_has_rows($stmt))
        {
            return sqlsrv_fetch_array($stmt)[0];
        }
        else{
            throw new NoPermissionsGrantedException("Couldn't find the permissions on this file");
        }

    }


    public function getFilesInFolder()
    {



    }

}