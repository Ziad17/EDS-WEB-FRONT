
<?php


require_once VALIDATION_BASE_PATH."/PersonValidator.php";
require_once BUSINESS_BASE_PATH."/Person.php";
require_once DATABASE_BASE_PATH."/MainAction.php";
require_once SESSIONS_BASE_PATH."/SessionManager.php";
require_once DATABASE_BASE_PATH."/InstitutionAction.php";

/*
 * STEPS ON HOW THIS PAGE WORKS
 *
 * (A) Fill Data
 * 1-LOAD Institutions
 * 2-LOAD InstitutionTypes
 *
 *
 *
 * */


//TODO:: uncomment
//error_reporting(E_ERROR | E_PARSE);





try {
    $personRef = Person::Builder()->setID(SessionManager::getID())->setEmail(SessionManager::getEmail())->build();
    $institutionAction = new InstitutionAction($personRef);
    if(!$institutionAction->canCreateInstitution())
    {
        echo "You Don't Have The Permissions Required To View This Page";
        exit();

    }
    $mainAction = new MainAction();
    $faculties = $mainAction->getAllInstitutions();
    $types=$mainAction->getInstitutionTypes();


}catch(NoPermissionsGrantedException $e)
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

if($_SERVER['REQUEST_METHOD']=='POST')
{

    try {
        $name = $_POST['name'];
        $phone_number = $_POST['phone_number'];
        $sec_num = $_POST['sec_num'];
        $fax = $_POST['fax'];
        $email = $_POST['email'];
        $website = $_POST['website'];
        $institution_sup = $_POST['institution_sup'];
        $institution_type = $_POST['institution_type'];
        //TODO:: CHECK WHETHER THE SESSION IS VALID
        unset($personRef);
        unset($institutionAction);
        unset($personRef);
        $personRef = Person::Builder()->setID(SessionManager::getID())->setEmail(SessionManager::getEmail())->build();
        $institutionAction = new InstitutionAction($personRef);
        $institutionToCreate = Institution::Builder()
            ->setName($name)
            ->setPrimaryPhone($phone_number)
            ->setSecondaryPhone($sec_num)
            ->setFax($fax)
            ->setEmail($email)
            ->setWebsite($website)
            ->setParent($institution_sup)
            ->setType($institution_type)
            ->build();

        if($institutionAction->createInstitution($institutionToCreate))
        {
            echo 'success';
            $mainAction = new MainAction();
            $faculties = $mainAction->getAllInstitutions();
            $types=$mainAction->getInstitutionTypes();
        }


    }
    catch (Exception $e)
    {

        //TODO:: HANDLE EXCEPTIONS
        echo $e->getMessage();
        $FormErrors[]=$e->getMessage();
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
        <input type="text" class="form-control mb-3" name="phone_number" placeholder="Phone Number(Optional)" value="" >
      </div>
      <div class="col-md-6">
        <input type="text" class="form-control mb-3" name="sec_num" placeholder="Secondary Number(Optional)" value="" >
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        
        <input type="text" class="form-control mb-3" name="fax" placeholder="Fax(Optional)" value="" >
      </div>
      <div class="col-md-6">
        
        <input type="Email" class="form-control mb-3" name="email" placeholder="Email (Optional)" value="" required>
      </div>
    </div>
      <div class="row">
          <div class="col-12">
              <input type="text" class="form-control mb-3" name="website" placeholder="Website(Optional)" value="" required>
          </div>
      </div>
    <div class="row">
      <div class="col-md-6 mb-5">
        <h6>Supervisor Institution</h6>
        <select name="institution_sup" class="form-control" required>


            <?php

            foreach ($faculties as $faculty) {
                $faculty_name = ucfirst($faculty->getName());
                echo "<option value=" . htmlspecialchars($faculty->getID()) . ">" . htmlspecialchars($faculty_name) . "</option>";
            }


            ?>

        </select>
      </div>
      <div class="col-md-6 mb-5">
        <h6>Institution Type</h6>
        <select name="institution_type" class="form-control" required>

            <?php

            foreach ($types as $type) {


                $title=(string)$type;
                echo "<option value=" . htmlspecialchars($title) . ">" . htmlspecialchars($title) . "</option>";
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