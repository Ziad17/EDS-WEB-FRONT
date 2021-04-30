<?php
  $name = 'Edit-profile';
require_once '../Paths.php';

require_once '../Include/headtag.php';
require_once '../Modules/Database/MainAction.php';
require_once '../Modules/Database/FileAction.php';
require_once '../Modules/Database/PersonAction.php';
require_once '../Modules/Database/InstitutionAction.php';
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
error_reporting(E_ALL);

if(!SessionManager::validateSession())
{
    header("Location: index.php");
    header('Cache-Control: no-cache, must-revalidate');
    exit();
}



?>
  <body>
		<div  class="wrapper d-flex align-items-stretch">

      <!-- ----------------------------- start  sidebar ---------------------------------------------->

            <?php require_once( '../Include/sidebar.php');?>

      <!-- ----------------------------- End  sidebar ---------------------------------------------->

        <!-- Page Content  -->

  <div id="content" class="p-4 p-md-5">



    <!----------------------------------- Start nav N 2-------------- --------------------------->
      <?php require_once( '../Include/nav2.php'); ?>

    <!----------------------------------- End nav N 2-------------- --------------------------->

      <!----------------------------------- Start nav N 3-------------- --------------------------->

      <?php require_once('../Include/nav3.php'); ?>

    <!----------------------------------- End nav N 3-------------- --------------------------->

    <!----------------------------------- Content -------------- --------------------------->

		<div class="container">
			<div class="row">
        <?php require_once('../Include/Edit-profile_content.php'); ?>
			</div>					 

          <footer class="row">
            <div class="col-md-12 footer">
                  <p class="mb-3 text-muted">&copy; 2021 <a href="mailto:ahmedheshamesmail@gmail.com?subject=feedback">Ahmed hesham</a></p>
            </div>
          </footer>


	    </div>
      <?php
      require_once( '../Include/script.php');
      ?>
      </div>
		</div>
  </body>
</html>