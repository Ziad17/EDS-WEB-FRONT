<?php


class FileAction extends Action
{
    private FilePermissions $myFilesPermissions;


    public function getMyFilesPermissions() : FilePermissions
    {
        return $this->myFilesPermissions;
    }



    public function __construct(FilePermissions $myFilesPermissions, Person $myPersonRef)
    {
        parent::setConnection($this);
        //TODO throw exceptions
        $this->myFilesPermissions = $myFilesPermissions;
        $this->myPersonRef = $myPersonRef;
    }

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

    public function getFile(String $fileID): File
    {

    }

    public function modifyFile(String $oldFileID,File $newFIle) : bool
    {}

    public function deleteFile(String $fileID) : bool
    {

    }


    public function getFilesInFolder()
    {



    }
    private function getFilePermissionsOnSpecifiedFile(int $fileID,int $personID):int
    {
        $conn=$this->getDatabaseConnection();
        $sql="SELECT file_permissions_sum  FROM PesonFileRoles WHERE file_id=? AND person_id=?";
        $params=array("$fileID","$personID");
        $stmt=$this->getParameterizedStatement($sql,$conn,$params);
        if($stmt==false)
        {
            $this->closeConnection($conn);

            throw new PermissionsCriticalFail("Couldn't load the permissions on this file");
        }
        if(sqlsrv_has_rows($stmt))
        {
            $sum=sqlsrv_fetch_array($stmt)[0];
            $this->closeConnection($conn);
            return $sum;
        }
        else{
            $this->closeConnection($conn);

            throw new NoPermissionsGrantedException("Couldn't find the permissions on this file");
        }

    }
    public function getAvailableFileTypes():array
    {
        $conn=$this->getDatabaseConnection();
        $sql="SELECT *  FROM FileType";
        $stmt=$this->getSingleStatement($sql,$conn);
        if($stmt==false)
        {
            $this->closeConnection($conn);

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
}