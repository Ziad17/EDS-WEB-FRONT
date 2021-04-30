
<?php

require_once "./Modules/Database/PersonAction.php";
require_once "./Modules/Sessions/SessionManager.php";
require_once "./Modules/Business/Person.php";
require_once "./Modules/File Managment/FileRepoHandler.php";
require_once "./Modules/Database/FileAction.php";
function signOut(){
    header("Location: index.php");
    header('Cache-Control: no-cache, must-revalidate');
    exit();
}



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
              <a href="Home.php"><i class="fas fa-home"></i> Home</a>
	          <li  <?php if ($name === 'Activity') {echo 'class="active"';};?>>
	              <a href="Activity.php"><i class="fas fa-chart-line"></i> Activity</a>
	          </li>
	          <li>
              <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i class="fab fa-wpexplorer"></i> Institutions </a>
              <ul class="collapse list-unstyled" id="pageSubmenu">

                  <li >

                      <?php if (isset($myRoles))
                      {
                          for($i=0;$i<count($myRoles);$i++)
                          {
                                  echo '<a class="drobli" href="institutions.php?institution='.htmlspecialchars($myRoles[$i]->getInstitutionName()).'"><i class="fas fa-university"></i>'.htmlspecialchars($myRoles[$i]->getInstitutionName()).'</a>';
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
              <a href="MyProfile.php"><i class="far fa-user"></i> My Profile</a>
	          </li>
	          <li>
              <a  href="#">
                <button onMouseOver="this.style.color='#f8b739'" onMouseOut="this.style.color='#f8b739'" type="button" class="btn " data-toggle="modal" data-target="#section">
                  <i class="fas fa-stream"></i>
                   Create new section
                </button>
              </a>
	          </li>
	        </ul>
	      </div>
    	</nav>