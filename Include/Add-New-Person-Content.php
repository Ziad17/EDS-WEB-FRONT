<?php

require_once VALIDATION_BASE_PATH."/PersonValidator.php";

require_once BUSINESS_BASE_PATH."/Person.php";
require_once DATABASE_BASE_PATH."/MainAction.php";
require_once EXCEPTIONS_BASE_PATH."/NoPermissionsGrantedException.php";

require_once SESSIONS_BASE_PATH."/SessionManager.php";
require_once DATABASE_BASE_PATH."/PersonAction.php";
require_once BUSINESS_BASE_PATH."/PersonRole.php";

/*
 * STEPS ON HOW THIS PAGE WORKS
 *
 *
 * (A) Fill Data
 * 1-LOAD Institutions
 * 2-LOAD Positions
 * 3-LOAD Gender
 * 4-LOAD Cities
 *
 *
 *
 * */



//TODO:: uncomment
//error_reporting(E_ERROR | E_PARSE);






try {
    $personRef = Person::Builder()->setID(SessionManager::getID())->setEmail(SessionManager::getEmail())->build();
    $Action = new PersonAction($personRef);
    if(!$Action->canCreatePerson())
    {
        echo "You Don't Have The Permissions Required To View This Page";
        exit();

    }
    $mainAction = new MainAction();

    $faculties = $mainAction->getAllInstitutions();
    $cities = $mainAction->getAllCities();
    $positions=$mainAction->getAllAvailableRoles((int)SessionManager::USER_ID);


} catch(NoPermissionsGrantedException $e)
{
    echo "You Don't Have The Permissions Required To View This Page";
    exit();

}

catch (Exception $e) {
    //FIXME::HANDLE ERRORS
    echo $e->getMessage();
    $FormErrors[] = $e->getMessage();
    // header("HTTP/1.1 503 Not Found");
    //exit(503);
}




if($_SERVER['REQUEST_METHOD'] == 'POST')
{

    try {
        $name = $_POST['name'];
        $acadmic_number = $_POST['acadmic_number'];
        $email = $_POST['email'];
        $confirm_password = $phone = $_POST['confirm_password'];
        $password = $phone = $_POST['password'];
        $date_hired = $_POST['date_hired'];
        $job_title = $_POST['job_title'];
        $institution = $_POST['institution'];
        $job_role = $_POST['roles'];
        $city = $_POST['city'];
        $gender=$_POST['gender'];

        $personToCreate=Person::Builder()->setEmail($email)
            ->setFirstName($name)
            ->setAcadmicNumber($acadmic_number)
            ->setInstitution($institution)
            ->setCity($city)
            ->setGender($gender)
            ->build();

        $personValidator=new PersonValidator($personToCreate);
        if (!$personValidator->isValid()) {
            $FormErrors = $personValidator->getERRORSLIST();


        }
        else
            {
                if ($password == $confirm_password && strlen($password) >= 8) {
                    $roleToAttach = new PersonRole($job_role, 0, $job_title, $mainAction->getInstitutionNameByID($institution));


                    $creator = Person::Builder()->setID((int)SessionManager::getID())
                        ->setEmail(SessionManager::getEmail())
                        ->build();
                    $personAction = new PersonAction($creator);
                    $personAction->createPerson($personToCreate, $password, $date_hired, $roleToAttach);
                    echo 'succss';

                } else {
                    $FormErrors[] = 'Passwords Must Be Identical And Greater Than 8 Characters';
                }



        }



    }

    catch (Exception $e)
    {

        //TODO:: HANDLE EXCEPTIONS

        $FormErrors[]=$e->getMessage();

    }
    if(isset($FormErrors))
    {
        print_r(($FormErrors));
    }



}





?>



<div class="col-md-12">
  <form action="" method="POST">
    <div class="row">
      <div class="col-12">
        <input type="text" class="form-control mb-3" name="name" placeholder="Name" value="" required>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <input type="text" class="form-control mb-3" name="acadmic_number" placeholder="Academic Number" value="" required>
      </div>
      <div class="col-md-6">
        <input type="email" class="form-control mb-3" name="email" placeholder="Email" value="" required>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        
        <input type="password" class="form-control mb-3" name="password" placeholder="Password" value="" required>
      </div>
      <div class="col-md-6">
        
        <input type="password" class="form-control mb-3" name="confirm_password" placeholder="Confirm Password" value="" required>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <label>.</label>
        <input type="text" class="form-control mb-3" name="job_title" placeholder="Job Title" value="" required>
      </div>
      <div class="col-md-6">
        <label>Date-Hired</label>
        <input type="date" class="form-control mb-3" name="date_hired" placeholder="Date Hired" value="" required>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 mb-3">
        <h6>Institution  <a href="Add-New-Institution.php"><u><b> Add New Institution ?</b></u></a></h6>
        <select name="institution" class="form-control" required>
            <?php

            foreach ($faculties as $faculty) {
                $faculty_name = ucfirst($faculty->getName());
                echo "<option value=" . htmlspecialchars($faculty->getID()) . ">" . htmlspecialchars($faculty_name) . "</option>";
            }


            ?>
        </select>
      </div>
      <div class="col-md-6 mb-3">
        <h6>Position  <a href="Add-New-Position.php"><u><b> Add New Position ?</b></u></a></h6>
        <select name="roles" class="form-control" required>
            <?php

            foreach ($positions as $_position) {


                $title=$_position->getJobTitle();

                $role_name=$_position->getRoleName();
                echo "<option value=" . htmlspecialchars($role_name) . ">" . htmlspecialchars($title) . "</option>";
            }

            ?>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 mb-5">
        <h6>Gender</h6>
        <select name='gender' class="form-control" required>
          <option value="M">Male</option>
          <option value="F">Female</option>
        </select>
      </div>
      <div class="col-md-6 mb-5">
        <h6>City</h6>
        <select name ="city" class="form-control" required>

            <?php

            foreach ($cities as $city) {
                $city_name = ucfirst($city->getName());
                echo "<option value=" . htmlspecialchars($city->getShortcut()) . ">" . htmlspecialchars($city_name) . "</option>";
            }


            ?>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        
      </div>
      <div class="col-md-3 mb-5">
         <button class="w-100 btn btn-warning btn-lg text-light" type="submit">Reset</button>
       </div>
       <div class="col-md-3 mb-5">
         <button class="w-100 btn btn-warning btn-lg text-light" type="submit">Confirm</button>
       </div>
        <div class="col-md-3 mb-5">
      
      </div> 
    </div>
  </form>
  <br>
</div>