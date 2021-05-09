
<?php

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
function signOut(){
    header("Location: index.php");
    header('Cache-Control: no-cache, must-revalidate');
    exit();
}

error_reporting(0);

try
{

    if(!SessionManager::validateSession())
    {
        signOut();
    }
    $personRef = Person::Builder()->setID(SessionManager::getID())->setEmail(SessionManager::getEmail())->build();
    $Action = new PersonAction($personRef);
    $fileAction = new FileAction($personRef);
    $handler = new FileRepoHandler($fileAction);

    //fill Info
    $detailedPersonRef=$Action->getMyDetails();
    $phoneNumber=$detailedPersonRef->getPhoneNumber();
    $myName=trim($detailedPersonRef->getFirstName().' '.$detailedPersonRef->getMiddleName().' '.$detailedPersonRef->getLastName());
    $bio=$detailedPersonRef->getBio();
    $phd=$detailedPersonRef->getPhd();
    $image=$detailedPersonRef->getImgRef();
    $base_faculty=$detailedPersonRef->getInstitution();

    $image=$detailedPersonRef->getImgRef();


    $myRoles=$Action->getMyRoles($personRef->getID());


}
catch(Exception $e) {
    //FIXME::HANDLE ERRORS
    echo $e->getMessage();
    $FormErrors[] = $e->getMessage();
    // header("HTTP/1.1 503 Not Found");
    //exit(503);
}





if($_SERVER['REQUEST_METHOD']=='POST')
{
    if($_POST['sign_out']=='sign_out') {
        SessionManager::sessionLogOut();
        signOut();
    }
}

?>




















			<nav  id="sidebar">
				<div class="p-4  sidch">
		  		<div align="center">



                 <!--   TODO:: STYLE THIS BUTTON-->
                    <form   action="" id="sign_out" method="POST" accept-charset="utf-8">
                        <button type="submit" name="sign_out" value="sign_out" class=" col-sm-12 btn btn-primary ">SignOut</button>

                    </form>
            <img style="border-radius: 50%;padding: 5px" src="<?php  if(isset($image) )
            {

                echo $handler->getImagePrivateURI($image);
            }
            else{echo '../img/undraw_male_avatar_323b.svg';}?>" width="100px" height="100px" alt="Profile_Img">
            <h6  style="color: #fff;text-shadow: 5px 5px 5px #fff"><?php if (isset($myName)) {echo htmlspecialchars($myName);}
            else{
                //uncommentOnProd
                // signOut();
            }?></h6>
            <span class="country"><?php if (isset($base_faculty)) {echo htmlspecialchars($base_faculty);}
                else{
                    //uncommentOnProd
                    // signOut();
                }?></span>
            <hr style="color: #fff;background-color: #fff;font-size: 15px;  border-style: inset;
            border-width: 1px;">
          </div>
	        <ul  class="list-unstyled components mb-5">
	          <li <?php if ($name === 'KfsDocs') {echo 'class="active"';};?>>
<<<<<<< Updated upstream
              <a href="../General/Home.php"><i class="fas fa-home"></i> Home</a>
=======
<<<<<<< HEAD
<<<<<<< Updated upstream
              <a href="../Home.php"><i class="fas fa-home"></i> Home</a>
=======
              <a href="../General/Home.php"><i class="fas fa-home"></i> Home</a>
>>>>>>> 03e145f96d2ee3521755cd75fe625120fda6863c
>>>>>>> Stashed changes
	          <li  <?php if ($name === 'Activity') {echo 'class="active"';};?>>
	              <a href="Activity.php"><i class="fas fa-chart-line"></i> Activity</a>
	          </li>
=======
              <a href="Home.php"><i class="fas fa-home"></i> Home</a>
<!-- 	          <li  <?php if ($name === 'Activity') {echo 'class="active"';};?>>
	              <a href="Activity.php"><i class="fas fa-chart-line"></i> Activity</a>
	          </li> -->
>>>>>>> Stashed changes
	          <li>
              <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i class="fab fa-wpexplorer"></i> Institutions </a>
              <ul class="collapse list-unstyled" id="pageSubmenu">

                  <li >

                      <?php if (isset($myRoles))
                      {
                          for($i=0;$i<count($myRoles);$i++)
                          {
                                  echo '<a class="drobli" href="../institutions/View.php?institution='.htmlspecialchars($myRoles[$i]->getInstitutionName()).'"><i class="fas fa-university"></i>'.htmlspecialchars($myRoles[$i]->getInstitutionName()).'</a>';
                          }
                      }
                      else{
                          //uncommentOnProd
                         // signOut();
                      }?>
                </li>


             <!--   <li>
                    <a class="drobli" href="#"><i class="fas fa-users"></i>  Employees</a>
                </li>-->

              </ul>
	          </li>

	          <li <?php if ($name === 'MyProfile') {echo 'class="active"';};?>>
              <a href="../Employees/MyProfile.php"><i class="far fa-user"></i> My Profile</a>
	          </li>
            <li <?php if ($name === 'Add-New-Person') {echo 'class="active"';};?>>
              <a href="Add-New-Person.php"><i class="far fa-user"></i>  Add-New-Person</a>
            </li>
            </li>
            <li <?php if ($name === 'Folder') {echo 'class="active"';};?>>
              <a href="Folder.php"><i class="fas fa-folder-plus"></i>  Folder</a>
            </li>
<!-- 	          <li>
              <a  href="#">
                <button onMouseOver="this.style.color='#f8b739'" onMouseOut="this.style.color='#f8b739'" type="button" class="btn " data-toggle="modal" data-target="#section">
                  <i class="fas fa-stream"></i>
                   Create new section
                </button>
              </a>
	          </li> -->
	        </ul>
	      </div>
    	</nav>