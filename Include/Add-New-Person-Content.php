<?php


require_once "./Modules/Validation/PersonValidator.php";
require_once "./Modules/Business/Person.php";
require_once "./Modules/Database/MainAction.php";
require_once "./Modules/Sessions/SessionManager.php";

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



$mainAction = new MainAction();



try {
    $faculties = $mainAction->getAllInstitutions();
    $cities = $mainAction->getAllCities();
   // $positions=array();
    $positions=$mainAction->getAllAvailableRoles((int)SessionManager::USER_ID);


} catch (Exception $e) {
    //FIXME::HANDLE ERRORS
    echo $e->getMessage();
    $FormErrors[] = $e->getMessage();
   // header("HTTP/1.1 503 Not Found");
    exit(503);
}
/*
if($_SERVER['REQUEST_METHOD'=='POST'])
{




}*/





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
        <input type="text" class="form-control mb-3" name="Academic-Number" placeholder="Academic Number" value="" required>
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
        
        <input type="password" class="form-control mb-3" name="Confirm-password" placeholder="Confirm Password" value="" required>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <label>.</label>
        <input type="text" class="form-control mb-3" name="Job-Title" placeholder="Job Title" value="" required>
      </div>
      <div class="col-md-6">
        <label>Date-Hired</label>
        <input type="date" class="form-control mb-3" name="Date-Hired" placeholder="Date Hired" value="" required>
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
                echo "<option value=" . htmlspecialchars($title) . ">" . htmlspecialchars($title) . "</option>";
            }

            ?>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 mb-5">
        <h6>Gender</h6>
        <select class="form-control" required>
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