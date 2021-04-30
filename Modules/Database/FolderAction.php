<?php

require_once 'Action.php';

class FolderAction extends Action
{

    private FolderPermissions $myFoldersPermissions;


    public function __construct( Person $myPersonRef)
    {
        parent::setConnection($this);
        $this->myPersonRef = $myPersonRef;
    }

    private function injectLog(int $actionPerformed,int $fileId,&$conn ):bool
    {
        $logSQL = "INSERT INTO FolderActionLogs(person_id,folder_id,action_date,folder_permission_action_performed) VALUES(?,?,GETDATE(),?);";
        $logParams = array($this->myPersonRef->getID(), $fileId,$actionPerformed);
        $logsStmt=$this->getParameterizedStatement($logSQL,$conn,$logParams);
        if ($logsStmt==false) {
            sqlsrv_rollback($conn);
            $this->closeConnection($conn);
            return false;
        }
        return true;
    }

    public function updateMyPersonFolderPermissions(int $FolderID)
    {

        //updates the permissions array
        $this->myFoldersPermissions=new FolderPermissions(0);
        $conn = $this->getDatabaseConnection();
        $sql = "SELECT folder_permissions_sum FROM PersonFolderRoles WHERE person_id=? AND folder_id=? AND exp_date<GETDATE()";
        $params = array($this->myPersonRef->getID(),$FolderID);
        $stmt = $this->getParameterizedStatement($sql, $conn, $params);
        if ($stmt == false) {
            $this->closeConnection($conn);
            throw new SQLStatmentException("Could not get details of the folder Permissions");
        }
        if (sqlsrv_has_rows($stmt)) {
            $rows = sqlsrv_fetch_array($stmt);
            $permissions = (int)$rows[0][0]; //permission_sum
            //Add checks for the EXP_DATE
            $this->myFoldersPermissions = new FolderPermissions($permissions);
            $this->closeConnection($conn);

        } else {
            $this->closeConnection($conn);
            throw new PersonHasNoRolesException("The Access To This File Or Folder Is Forbidden");
        }
    }


    public function showFolder(int $folderID) : Folder
    {
        $this->updateMyPersonFilePermissions($folderID);
        //Required Permission=VIEW_FOLDER=0
        if ($this->myFoldersPermissions->getPermissionsFromBitArray($this->myFoldersPermissions->VIEW_FOLDER)) {
            $permission_value=2**($this->myFoldersPermissions->VIEW_FOLDER);
            $con=$this->getDatabaseConnection();
            sqlsrv_begin_transaction($con);
            $folderSql="SELECT * FROM Folder WHERE ID=? AND active=1";
            $folderParams=array($folderID);
            $folderStmt=$this->getParameterizedStatement($folderSql,$con,$folderParams);
            $filesSql="SELECT ID FROM File WHERE parent_folder_id=? AND active=1";
            $filesParams=array($folderID);
            $filesStmt=$this->getParameterizedStatement($filesSql,$con,$filesParams);
            $foldersSql="SELECT ID FROM Folder WHERE parent_folder_id=? AND NOT ID=? AND  active=1";
            $foldersParams=array($folderID,$folderID);
            $foldersStmt=$this->getParameterizedStatement($foldersSql,$con,$foldersParams);

            if($foldersStmt==false || $filesStmt==false || $folderStmt==false || !sqlsrv_has_rows($folderStmt) || $this->injectLog($permission_value,$folderID,$con))
            {
                sqlsrv_rollback($con);
                $this->closeConnection($con);
                throw new FileNotFoundException("Could not find the data of this folder");
            }
            else
            {
                $folderRow=sqlsrv_fetch_array($folderStmt)[0];

                $folderID=$folderRow[0];
                $folderParentFolderID=$folderRow[1];
                $folderDateCreated=$folderRow[2];
                $folderAuthorID=$folderRow[3];
                $folderCurrentFolderVersion=$folderRow[4];
                $folderActive=$folderRow[5];
                $filesArray=array();
                $foldersArray=array();
                while ($fileRow=sqlsrv_fetch_array($filesStmt))
                {
                    $filesArray[]=$fileRow[0];
                }
                while ($folderRow=sqlsrv_fetch_array($foldersStmt))
                {
                    $foldersArray[]=$folderRow[0];
                }

                $folder =new Folder($folderID,
                    $this->getEmailFromPersonId($folderAuthorID),
                    $folderDateCreated,
                    $folderParentFolderID,
                    $folderCurrentFolderVersion,
                    null,
                    $filesArray,
                    $foldersArray);
                sqlsrv_commit($con);
                $this->closeConnection($con);
                return $folder;
            }
        } else {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }

    }






    public function createFile(File $fileToCreate , int $parentFolderID, array $personsToShareWith,array $permissionSumForEachPerson,$fileContent) : bool
    {
        /*
         * TODO: Steps
         * [1]check both folder and file permissions xx
         * [2]insert to blob storage
         * [3]insert to fileContent
         * [4]insert to file
         * [5]insert to fileVersion
         * [6]update file version
         * [7]insert to filePersonRoles
         *
         */

        $this->updateMyPersonFilePermissions($parentFolderID);
        //Required Permission=MODIFY_FOLDER_ADDS_NEW_FILE=2
        if ($this->myFoldersPermissions->getPermissionsFromBitArray($this->myFoldersPermissions->MODIFY_FOLDER_ADDS_NEW_FILE)) {
            $permission_value = 2 ** ($this->myFoldersPermissions->MODIFY_FOLDER_ADDS_NEW_FILE);
            //[1]
            //TODO: Code for storage uploading
            //FIXME : change the following vars
            $fileSize=12;//get it from getting the file from the user ($fileContent)
            $fileHref="https://host/storage/file231"; //get it after uploading file
            //if fileHref=null then exit
            $isFileUploaded=true;
            if(!$isFileUploaded)
            {
                throw new FileHandlerException("Could not upload the file to the cloud");
            }

            $con = $this->getDatabaseConnection();
            sqlsrv_begin_transaction($con);

            //[2]
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

            //[3]
            $insertVersionSql="INSERT INTO FileVersion(version_name,
                        version_notes,
                        version_number,
                        date_created,
                        author_id,
                        file_content_id) VALUES (?,?,?,?,GETDATE(),?,?); SELECT SCOPE_IDENTITY()";
            $insertVersionParams=array($fileToCreate->getCurrentVersion()->getName(),
                $fileToCreate->getCurrentVersion()->getNote(),
                $fileToCreate->getCurrentVersion()->getNumber(),
                $this->myPersonRef->getID(),
                $fileContentID);
            $insertVersionStmt=$this->getParameterizedStatement($insertVersionSql,$con,$insertVersionParams);
            if($insertVersionStmt==false || !sqlsrv_has_rows($insertVersionStmt))
            {
                sqlsrv_rollback($con);
                $this->closeConnection($con);
                throw new FileUploadingSqlException("Could not upload the version of the file");
            }
            sqlsrv_next_result($insertVersionStmt);
            sqlsrv_fetch($insertVersionStmt);
            $fileVersionID= (int)sqlsrv_get_field($insertVersionStmt, 0);

            //[4]
            $insertFileSql="INSERT INTO File(parent_folder_id,
                 date_created,
                 author_id,
                 current_file_version,
                 active,
                 locked) VALUES (?,GETDATE(),?,?,1,0)";
            $insertFileParams=array($parentFolderID,
                $this->myPersonRef->getID(),
                $fileVersionID);
            $insertFileStmt=$this->getParameterizedStatement($insertFileSql,$con,$insertFileParams);
            if($insertFileStmt==false || !sqlsrv_has_rows($insertFileStmt) || $this->injectLog($permission_value,$parentFolderID,$con)
            )
            {
                sqlsrv_rollback($con);
                $this->closeConnection($con);
                throw new FileUploadingSqlException("Could not upload the reference of the file");
            }
            sqlsrv_next_result($insertFileStmt);
            sqlsrv_fetch($insertFileStmt);
            $fileID= (int)sqlsrv_get_field($insertFileStmt, 0);

            //[5]
            $updateVersionSql="UPDATE FileVersion SET file_id=? WHERE ID=?";
            $updateVersionParams=array($fileID,$fileVersionID);
            $updateVersionStmt=$this->getParameterizedStatement($updateVersionSql,$con,$updateVersionParams);
            if($updateVersionStmt==false || !sqlsrv_has_rows($updateVersionStmt))
            {
                sqlsrv_rollback($con);
                $this->closeConnection($con);
                throw new FileUploadingSqlException("Could not update the version of the file");
            }


            //[6]
            for($i=0;$i<count($personsToShareWith);$i++) {
                $insertRolesSql = "INSERT INTO PersonFileRoles(person_id,
                 file_id,
                 file_permissions_sum) VALUES (?,?,?); SELECT SCOPE_IDENTITY()";
                $insertRolesParams = array($personsToShareWith[$i],
                    $fileID,
                    $permissionSumForEachPerson[$i]);
                $insertRolesStmt = $this->getParameterizedStatement($insertRolesSql, $con, $insertRolesParams);
                if ($insertRolesStmt == false || !sqlsrv_has_rows($insertRolesStmt)) {
                    sqlsrv_rollback($con);
                    $this->closeConnection($con);
                    throw new FileUploadingSqlException("Could not upload the Roles of the file");
                }
            }

            sqlsrv_commit($con);
            $this->closeConnection($con);
            return true;


        }else {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }


    }


    public function createFolder(Folder $folderToCreate , int $parentFolderID, array $personsToShareWith,array $folderPermissionSumForEachPerson) : bool
    {
        /*
         * TODO: Steps
         * [1]insert to folderVersion
         * [2]insert to folder
         * [3]update folder version
         * [4]insert to folderPersonRoles
         *
         */

        $this->updateMyPersonFilePermissions($parentFolderID);
        //Required Permission=MODIFY_FOLDER_ADDS_NEW_FOLDER=3
        if ($this->myFoldersPermissions->getPermissionsFromBitArray($this->myFoldersPermissions->MODIFY_FOLDER_ADDS_NEW_FOLDER)) {
            $permission_value = 2 ** ($this->myFoldersPermissions->MODIFY_FOLDER_ADDS_NEW_FOLDER);

            $con = $this->getDatabaseConnection();
            sqlsrv_begin_transaction($con);

            //[1]
            $insertVersionSql="INSERT INTO FolderVersion(version_name,
                   version_notes,
                   version_number,
                   date_created,
                   author_id) VALUES (?,?,?,GETDATE(),?); SELECT SCOPE_IDENTITY()";
            $insertVersionParams=array($folderToCreate->getName(),
                $folderToCreate->getNotes(),
                0,
                $this->myPersonRef->getID());
            $insertVersionStmt=$this->getParameterizedStatement($insertVersionSql,$con,$insertVersionParams);
            if($insertVersionStmt==false || !sqlsrv_has_rows($insertVersionStmt))
            {
                sqlsrv_rollback($con);
                $this->closeConnection($con);
                throw new FolderUploadingSqlException("Could not upload the version of the folder");
            }
            sqlsrv_next_result($insertVersionStmt);
            sqlsrv_fetch($insertVersionStmt);
            $folderVersionID= (int)sqlsrv_get_field($insertVersionStmt, 0);

            //[2]
            $insertFolderSql="INSERT INTO Folder(parent_folder_id,
                   date_created,
                   author_id,
                   current_folder_version,
                   active) VALUES (?,GETDATE(),?,?,1); SELECT SCOPE_IDENTITY()";
            $insertFolderParams=array($parentFolderID,$this->myPersonRef->getID(),$folderVersionID);
            $insertFolderStmt=$this->getParameterizedStatement($insertFolderSql,$con,$insertFolderParams);
            if($insertFolderStmt==false || !sqlsrv_has_rows($insertFolderStmt) || $this->injectLog($permission_value,$parentFolderID,$con))
            {
                sqlsrv_rollback($con);
                $this->closeConnection($con);
                throw new FolderUploadingSqlException("Could not upload the reference of the folder");
            }
            sqlsrv_next_result($insertFolderStmt);
            sqlsrv_fetch($insertFolderStmt);
            $folderID= (int)sqlsrv_get_field($insertFolderStmt, 0);

            //[3]
            $updateVersionSql="UPDATE FolderVersion SET folder_id=? WHERE ID=?";
            $updateVersionParams=array($folderID,$folderVersionID);
            $updateVersionStmt=$this->getParameterizedStatement($updateVersionSql,$con,$updateVersionParams);
            if($updateVersionStmt==false || !sqlsrv_has_rows($updateVersionStmt) )
            {
                sqlsrv_rollback($con);
                $this->closeConnection($con);
                throw new FolderUploadingSqlException("Could not update the version of the folder");
            }


            //[4]
            for($i=0;$i<count($personsToShareWith);$i++) {
                $insertRolesSql = "INSERT INTO PersonFolderRoles(person_id,
                 folder_id,
                 folder_permissions_sum) VALUES (?,?,?); SELECT SCOPE_IDENTITY()";
                $insertRolesParams = array($personsToShareWith[$i],
                    $folderID,
                    $folderPermissionSumForEachPerson[$i]);
                $insertRolesStmt = $this->getParameterizedStatement($insertRolesSql, $con, $insertRolesParams);
                if ($insertRolesStmt == false || !sqlsrv_has_rows($insertRolesStmt)) {
                    sqlsrv_rollback($con);
                    $this->closeConnection($con);
                    throw new FolderUploadingSqlException("Could not upload the Roles of the folder");
                }
            }

            sqlsrv_commit($con);
            $this->closeConnection($con);
            return true;


        }else {
            throw new NoPermissionsGrantedException("User does not have the permissions required for this process");
        }


    }





    public function getMyFoldersPermissions() : FolderPermissions
    {
        return $this->myFoldersPermissions;
    }

}