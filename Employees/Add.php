<?php
  $name = 'Add-New-Person';

require_once '../Include/headtag.php';
require_once '../Modules/Sessions/SessionManager.php';
require_once '../Modules/Exceptions/' . 'CannotCreateHigherEmployeeException.php';
require_once '../Modules/Exceptions/' . 'ConnectionException.php';
require_once '../Modules/Exceptions/' . 'DataNotFound.php';
require_once '../Modules/Exceptions/' . 'DuplicateDataEntry.php';
require_once '../Modules/Exceptions/' . 'FileHandlerException.php';
require_once '../Modules/Exceptions/' . 'FileNotFoundException.php';
require_once '../Modules/Exceptions/' . 'FolderUploadingSqlException.php';
require_once '../Modules/Exceptions/' . 'InsertionError.php';
require_once '../Modules/Exceptions/' . 'LogsError.php';
require_once '../Modules/Exceptions/' . 'LowRoleForSuchActionException.php';
require_once '../Modules/Exceptions/' . 'NoNotificationsFoundException.php';
require_once '../Modules/Exceptions/' . 'NoPermissionsGrantedException.php';
require_once '../Modules/Exceptions/' . 'PermissionsCriticalFail.php';
require_once '../Modules/Exceptions/' . 'PersonHasNoRolesException.php';
require_once '../Modules/Exceptions/' . 'PersonOrDeactivated.php';
require_once '../Modules/Exceptions/' . 'SearchQueryInsuffecient.php';
require_once '../Modules/Exceptions/' . 'SQLStatmentException.php';
require_once '../Modules/FileManagement/'."FileRepoHandler.php";
require_once '../Modules/Validation/'."PersonValidator.php";
require_once '../Modules/Encryption/'."EncryptionManager.php";
require_once '../Modules/Permissions/'."PersonPermissions.php";
require_once '../Modules/Permissions/'."InstitutionsPermissions.php";
require_once '../Modules/Business/'."Institution.php";
require_once '../Modules/Business/'."Person.php";
require_once '../Modules/Business/'."PersonRole.php";
require_once '../Modules/Business/'."City.php";



/*
 * STEPS ON HOW THIS PAGE WORKS
 * (A)
 *  1-check whether the person has the permission to add new Person
 * */

//TODO:: REMOVE

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!SessionManager::validateSession())
{
    header("Location: index.php");
    header('Cache-Control: no-cache, must-revalidate');
    exit();
}


 ?>
 <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
  <body>
		<div  class="wrapper d-flex align-items-stretch">

      <!-- ----------------------------- start  sidebar ---------------------------------------------->

        <?php require_once INCLUDE_BASE_PATH.'/sidebar.php';?>

      <!-- ----------------------------- End  sidebar ---------------------------------------------->

        <!-- Page Content  -->

  <div id="content" class="p-4 p-md-3">
      <!----------------------------------- Start nav N 3-------------- --------------------------->
        
        <?php require_once INCLUDE_BASE_PATH.'/nav3.php'; ?>

    <!----------------------------------- End nav N 3-------------- --------------------------->

    <!----------------------------------- Content -------------- --------------------------->

		<div class="container">
			<div class="row m-auto d-block">
        <?php
        try {
            require_once(INCLUDE_BASE_PATH.'/Add-New-Person-Content.php');
        }
        catch ( Exception $exception){echo $exception->getMessage(); }?>
			</div>

          <footer class="row">
            <div class="col-md-12 footer">
                  <p class="mb-3 text-muted">&copy; 2021 <a href="mailto:ahmedheshamesmail@gmail.com?subject=feedback">Ahmed hesham</a></p>
            </div>
          </footer>


	    </div>
      <?php 
        require_once(INCLUDE_BASE_PATH.'/script.php');
      ?>
      <script src="../js/jquery.dataTables.js"></script>
    <script type = "text/javascript">
    $(document).ready(function(){
      $('#table').DataTable();
      $('#table2').DataTable();
    });
  </script>
      </div>
		</div>
  </body>
</html>