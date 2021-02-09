<?php


class FileFolderAction extends Action
{
    private FilePermissions $myFilesPermissions;





    public function __construct(Person $myPersonRef)
    {

        parent::setConnection($this);

        $this->myPersonRef = $myPersonRef;

    }


    public function updateMyPersonFilePermissions(int $fileID)
    {

        //updates the permissions array
        $this->myFilesPermissions=new FilePermissions(0);
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
            $this->myFilesPermissions = new FilePermissions($permissions);
            $this->closeConnection($conn);

        } else {
            $this->closeConnection($conn);
            throw new PersonHasNoRolesException("The Access To This File Or Folder Is Forbidden");
        }
    }

    private function injectLog(int $actionPerformed,int $fileId,&$conn )
    {
        $logSQL = "INSERT INTO FileActionLogs(person_id,file_id,action_date,file_permission_action_performed) VALUES(?,?,GETDATE(),?);";
        $logParams = array($this->myPersonRef->getID(), $fileId,$actionPerformed);
        $logsStmt=$this->getParameterizedStatement($logSQL,$conn,$logParams);
        if ($logsStmt==false) {
            sqlsrv_rollback($conn);
            $this->closeConnection($conn);
            return false;
        }
        return true;
    }

    public function getFile(int $fileID): File //with only the current version
    {
        $this->updateMyPersonFilePermissions($fileID);
        //Required Permission=VIEW_FILE=0
        if ($this->myFilesPermissions->getPermissionsFromBitArray($this->myFilesPermissions->VIEW_FILE)) {
            $permission_value=2**($this->myFilesPermissions->VIEW_FILE);
            $con=$this->getDatabaseConnection();
            sqlsrv_begin_transaction($con);
            $sql="SELECT * FROM FileWithCurrentVersion_view WHERE ID=?";
            $params=array($fileID);
            $stmt=$this->getParameterizedStatement($sql,$con,$params);
            if($stmt==false || !sqlsrv_has_rows($stmt) || $this->injectLog($permission_value,$fileID,$con))
            {
                $this->closeConnection($con);
                throw new FileNotFoundException("Could not find the data of this file");
            }
            else
            {
                $row=sqlsrv_fetch_array($stmt)[0];
                $_fileID=$row[0];
                $parent_folder_id=$row[1];
                $date_created=$row[2];
                $author_id=$row[3];
                $current_file_version=$row[4];
                $version_name=$row[5];
                $version_notes=$row[6];
                $version_number=$row[7];
                $version_date_created=$row[8];
                $version_author_id=$row[9];
                $file_type_extension=$row[10];
                $file_content_id=$row[12];
                $file_size=$row[13];
                $file_version=new FileVersion($current_file_version,$fileID,$version_notes,$version_name,$this->getEmailFromPersonId($version_author_id),
                $file_content_id,$file_type_extension,$version_number,$version_date_created,$file_size);
                $file=new File($this->getEmailFromPersonId($author_id),$date_created,$parent_folder_id,$file_version,null,$_fileID);
                sqlsrv_commit($con);
                $this->closeConnection($con);
                return $file;
            }
        } else {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }
    }

    public function showVersionsOfFile($fileID):File //attached to it all file versions
    {
        $this->updateMyPersonFilePermissions($fileID);
        //Required Permission=$SHOW_VERSIONS_OF_A_FILE=1
        if ($this->myFilesPermissions->getPermissionsFromBitArray($this->myFilesPermissions->SHOW_VERSIONS_OF_A_FILE)) {
            $permission_value=2**($this->myFilesPermissions->SHOW_VERSIONS_OF_A_FILE);
            $con=$this->getDatabaseConnection();
            sqlsrv_begin_transaction($con);
            $sql="SELECT * FROM FileWithCurrentVersion_view WHERE ID=?";
            $params=array($fileID);
            $stmt=$this->getParameterizedStatement($sql,$con,$params);
            if($stmt==false || !sqlsrv_has_rows($stmt) || $this->injectLog($permission_value,$fileID,$con))
            {
                $this->closeConnection($con);
                throw new FileNotFoundException("Could not find the data of this file");
            }
            else
            {
                $file=$this->getFile($fileID);
                $arrayOfVersions=array();
                while($row=sqlsrv_fetch($stmt)) {
                    $row = sqlsrv_fetch_array($stmt)[0];
                    $version_name = $row[5];
                    $version_notes = $row[6];
                    $version_number = $row[7];
                    $version_date_created = $row[8];
                    $version_author_id = $row[9];
                    $file_type_extension = $row[10];
                    $file_content_id = $row[12];
                    $file_size = $row[13];
                    fghfsghfgh
                }

                sqlsrv_commit($con);
                $this->closeConnection($con);
                return new File($file->getAuthorEmail(),$file->getDateCreated(),$file->getParentFolderid(),$file->getCurrentVersion(),$arrayOfVersions,$file->getID());
            }
        } else {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }

    }

    public function lockFile($fileID) : bool
    {
        $this->updateMyPersonFilePermissions($fileID);
        //Required Permission=LOCK_FILE=2
        if ($this->myFilesPermissions->getPermissionsFromBitArray($this->myFilesPermissions->LOCK_FILE)) {
           //operations
        } else {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }

    }

    public function unlockFile($fileID) : bool
    {
        $this->updateMyPersonFilePermissions($fileID);
        //Required Permission=UNLOCK_FILE=3
        if ($this->myFilesPermissions->getPermissionsFromBitArray($this->myFilesPermissions->UNLOCK_FILE)) {
            //operations
        } else {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }

    }

    public function modifyFileAddNewVersion(int $fileID,FileVersion $newFIleVersion) : bool
    {
        $this->updateMyPersonFilePermissions($fileID);
        //Required Permission=$MODIFY_FILE_ADDS_NEW_VERSION=4
        if ($this->myFilesPermissions->getPermissionsFromBitArray($this->myFilesPermissions->MODIFY_FILE_ADDS_NEW_VERSION)) {
            //operations
        } else {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }
    }

    public function revertCurrentFileVersion(int $fileID,int $previousVersionId)
    {
        $this->updateMyPersonFilePermissions($fileID);
        //REQUIRED_PERMISSION=$REVERT_CURRENT_FILE_VERSION=5
        if ($this->myFilesPermissions->getPermissionsFromBitArray($this->myFilesPermissions->REVERT_CURRENT_FILE_VERSION)) {
            //operations
        } else {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }

    }

    public function deleteFile(String $fileID) : bool
    {
        $this->updateMyPersonFilePermissions($fileID);
        //REQUIRED_PERMISSION=$DELETE_FILE=6
        if ($this->myFilesPermissions->getPermissionsFromBitArray($this->myFilesPermissions->DELETE_FILE)) {
            //operations
        } else {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }
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

    private function setFileLock($fileID,bool $lock,int $permission) : bool
    {}

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