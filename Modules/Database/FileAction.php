<?php
require_once './../Paths.php';


//TODO:ADD active file stats and see if the files should be permanently deleted or just deactivated
class FileAction extends Action
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

    private function injectLog(int $actionPerformed,int $fileId,&$conn ):bool
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
                sqlsrv_rollback($con);

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
                $file_active=$row[4];
                $file_locked=$row[5];
                $file_locked_until=$row[6];
                $current_file_version=$row[7];
                $version_name=$row[8];
                $version_notes=$row[9];
                $version_number=$row[10];
                $version_date_created=$row[11];
                $version_author_id=$row[12];
                $file_type_extension=$row[13];
                $file_content_id=$row[14];
                $file_size=$row[15];
                $file_version=new FileVersion($current_file_version,$fileID,$version_notes,$version_name,$this->getEmailFromPersonId($version_author_id),
                $file_content_id,$file_type_extension,$version_number,$version_date_created,$file_size);
                $file=new File($_fileID,$this->getEmailFromPersonId($author_id),$date_created,$parent_folder_id,$file_version,null,$file_locked,$file_locked_until,$file_active);
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
            $sql="SELECT * FROM FileVersions_Type_Content_view WHERE file_id=? ORDER BY date_created ASC";
            $params=array($fileID);
            $stmt=$this->getParameterizedStatement($sql,$con,$params);
            if($stmt==false || !sqlsrv_has_rows($stmt) || $this->injectLog($permission_value,$fileID,$con))
            {
                sqlsrv_rollback($con);

                $this->closeConnection($con);
                throw new FileNotFoundException("Could not find the data of this file");
            }
            else
            {
                $file=$this->getFile($fileID);
                $arrayOfVersions=array();
                while($row = sqlsrv_fetch_array($stmt)) {
                    $version_id = $row[0];
                    $file_id = $row[1];
                    $version_name = $row[2];
                    $version_notes = $row[3];
                    $version_number = $row[4];
                    $version_date_created = $row[5];
                    $version_author_id = $row[6];
                    $file_type_extension = $row[7];
                    $file_content_id = $row[8];
                    $file_size = $row[9];
                    $file_version=new FileVersion($version_id,$fileID,$version_notes,$version_name,$this->getEmailFromPersonId($version_author_id),
                        $file_content_id,$file_type_extension,$version_number,$version_date_created,$file_size);
                    $arrayOfVersions[]=$file_version;
                }
                $file=new File($file->getID(),$file->getAuthorEmail(),$file->getDateCreated(),$file->getParentFolderid(),$file->getCurrentVersion(),$arrayOfVersions,$file->isLocked(),$file->getLockedUntil(),$file->isActive());
                sqlsrv_commit($con);
                $this->closeConnection($con);
                return $file;
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

            $permission_value=2**($this->myFilesPermissions->LOCK_FILE);
            $con=$this->getDatabaseConnection();
            sqlsrv_begin_transaction($con);
            //TODO:Test this query to add time
            $sql="UPDATE File SET locked=true, locked_until=DATEADD(HOUR,2,GETDATE()) WHERE ID=?";
            $params=array($fileID);
            $stmt=$this->getParameterizedStatement($sql,$con,$params);
            if($stmt==false || !sqlsrv_has_rows($stmt) || $this->injectLog($permission_value,$fileID,$con))
            {
                sqlsrv_rollback($con);
                $this->closeConnection($con);
                throw new FileNotFoundException("Could not find the data of this file");
            }
            else
            {
                return true;
            }
        } else {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }

    }

    public function unlockFile($fileID) : bool
    {
        $this->updateMyPersonFilePermissions($fileID);
        //Required Permission=UNLOCK_FILE=3
        if ($this->myFilesPermissions->getPermissionsFromBitArray($this->myFilesPermissions->UNLOCK_FILE)) {
            $this->updateMyPersonFilePermissions($fileID);
            //Required Permission=LOCK_FILE=2
            if ($this->myFilesPermissions->getPermissionsFromBitArray($this->myFilesPermissions->UNLOCK_FILE)) {

                $permission_value=2**($this->myFilesPermissions->LOCK_FILE);
                $con=$this->getDatabaseConnection();
                sqlsrv_begin_transaction($con);
                //TODO:Test this query to add time
                $sql="UPDATE File SET locked=false, locked_until=null WHERE ID=?";
                $params=array($fileID);
                $stmt=$this->getParameterizedStatement($sql,$con,$params);
                if($stmt==false || !sqlsrv_has_rows($stmt) || $this->injectLog($permission_value,$fileID,$con))
                {
                    sqlsrv_rollback($con);
                    $this->closeConnection($con);
                    throw new FileNotFoundException("Could not find the data of this file");
                }
                else
                {
                    return true;
                }
            } else {
                throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
            }
        } else {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }

    }

    public function modifyFileAddNewVersion(int $fileID,FileVersion $newFileVersion) : bool
    {
        $this->updateMyPersonFilePermissions($fileID);
        //Required Permission=$MODIFY_FILE_ADDS_NEW_VERSION=4
        if ($this->myFilesPermissions->getPermissionsFromBitArray($this->myFilesPermissions->MODIFY_FILE_ADDS_NEW_VERSION)) {
            $permission_value=2**($this->myFilesPermissions->MODIFY_FILE_ADDS_NEW_VERSION);
            //TODO: Code for storage uploading
            //FIXME : change the following vars
            $fileSize=12;//get it from uploading file
            $fileHref="https://host/storage/file231"; //get it from uploading file
            //if fileHref=null then exit

            $con=$this->getDatabaseConnection();
            sqlsrv_begin_transaction($con);
            $insertContentSql="INSERT INTO FileContent(href,file_size) VALUES (?,?); SELECT SCOPE_IDENTITY()";
            $insertContentParams=array($fileHref,$fileSize);
            $insertContentStmt=$this->getParameterizedStatement($insertContentSql,$con,$insertContentParams);
            if($insertContentStmt==false || !sqlsrv_has_rows($insertContentStmt))
            {
                sqlsrv_rollback($con);
                $this->closeConnection($con);
                throw new FileUploadingSqlException("Could not upload the contents of the file");
            }
            sqlsrv_next_result($insertContentStmt);
            sqlsrv_fetch($insertContentStmt);
            $fileContentID= (int)sqlsrv_get_field($insertContentStmt, 0);
            $insertVersionSql="INSERT INTO FileVersion(file_id,version_name,version_notes,version_number,date_created,author_id,file_content_id) VALUES (?,?,?,?,GETDATE(),?,?)";
            $insertVersionParams=array($fileID,$newFileVersion->getName(),$newFileVersion->getNote(),$newFileVersion->getNumber(),$this->getIdFromPersonEmail($newFileVersion->getAuthorEmail()),$fileContentID);
            $insertVersionStmt=$this->getParameterizedStatement($insertVersionSql,$con,$insertVersionParams);
            if($insertVersionStmt==false || !sqlsrv_has_rows($insertVersionStmt) || $this->injectLog($permission_value,$fileID,$con))
            {
                sqlsrv_rollback($con);
                $this->closeConnection($con);
                throw new FileUploadingSqlException("Could not upload the version of the file");
            }
            else
            {
                sqlsrv_commit($con);
                $this->closeConnection($con);
                return true;
            }
        } else {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }
    }

    public function revertCurrentFileVersion(int $fileID,int $previousVersionId) : bool
    {
        $this->updateMyPersonFilePermissions($fileID);
        //REQUIRED_PERMISSION=$REVERT_CURRENT_FILE_VERSION=5
        if ($this->myFilesPermissions->getPermissionsFromBitArray($this->myFilesPermissions->REVERT_CURRENT_FILE_VERSION)) {
            $permission_value=2**($this->myFilesPermissions->REVERT_CURRENT_FILE_VERSION);
            $con=$this->getDatabaseConnection();
            sqlsrv_begin_transaction($con);
            //TODO:add a new function checkIfFileVersionExists(int $versionID)
            $sql="UPDATE File SET current_file_version=?  WHERE ID=?";
            $params=array($previousVersionId,$fileID);
            $stmt=$this->getParameterizedStatement($sql,$con,$params);
            if($stmt==false || !sqlsrv_has_rows($stmt) || $this->injectLog($permission_value,$fileID,$con))
            {
                sqlsrv_rollback($con);
                $this->closeConnection($con);
                throw new FileNotFoundException("Could not find the data of this file");
            }
            else
            {
                sqlsrv_commit($con);
                $this->closeConnection($con);
                return true;
            }
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
        return true;
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
        return $this->myFilesPermissions;
    }


    public function getMyFilesPermissions() : FilePermissions
    {
        return $this->myFilesPermissions;
    }



}