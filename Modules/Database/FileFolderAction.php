<?php


class FileFolderAction extends Action
{
    private FilePermissions $myFilesPermissions;
   // private FolderPermissions $myFoldersPermissions;
    private array $filePermissions = array("FILE_PERMISSION_SUM" => 0);





    public function __construct(Person $myPersonRef)
    {

        //TODO throw exceptions
        parent::setConnection($this);
        try {
            $this->myPersonRef = $myPersonRef;
            $this->getMyPersonFilePermissions();
      //      $this->getMyPersonFolderPermissions();
            $this->myFilesPermissions = new FilePermissions($this->filePermissions["PERMISSION_SUM"]);
        } catch (Exception $e) {
            throw new PermissionsCriticalFail("Could not fetch file action permissions");

        }
    }



   // public function getMyPersonFolderPermissions()
   // {}

    public function getMyPersonFilePermissions(int $fileID)
    {
        //updates the permissions array
        $conn = $this->getDatabaseConnection();
        $sql = "SELECT file_permissions_sum FROM PersonFileRoles WHERE person_id=? AND file_id=? AND exp_date<GETDATE()";
        $params = array($this->myPersonRef->getID(),$fileID);
        $stmt = $this->getParameterizedStatement($sql, $conn, $params);
        if ($stmt == false) {
            $this->closeConnection($conn);
            throw new SQLStatmentException("Could not get details of the file Permissions");
        }
        if (sqlsrv_has_rows($stmt)) {
            $rows = sqlsrv_fetch_array($stmt);
            $permissions = (int)$rows[0][0]; //permission_sum
            //Add checks for the EXP_DATE
            $this->filePermissions["PERMISSION_SUM"] = $permissions;
            $this->closeConnection($conn);

        } else {
            $this->closeConnection($conn);
            throw new PersonHasNoRolesException("The Access To This File Or Folder Is Forbidden");
        }
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
        //REQUIRED_PERMISSION=$DELETE_FILE=6
        if ($this->myFilesPermissions->getPermissionsFromBitArray($this->myFilesPermissions->DELETE_FILE)) {
            if ($this->compareRoleLevel($this->myPersonRef->getEmail(), $targetEmail)) {
                return $this->setRoleActiveStatus(true, $targetEmail);
            } else {
                throw new LowRoleForSuchActionException("The targeted person has a higher role level");
            }
        } else {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }
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



    /**
     * @return array|int[]
     */
    public function getFilePermissions(): array
    {
        return $this->filePermissions;
    }


    public function getMyFilesPermissions() : FilePermissions
    {
        return $this->myFilesPermissions;
    }
}