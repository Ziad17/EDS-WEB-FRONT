<?php


require_once "./Modules/Validation/PersonValidator.php";
require_once "./Modules/Business/Person.php";
require_once "./Modules/Business/Institution.php";
require_once "./Modules/Database/InstitutionAction.php";

require_once "./Modules/Database/MainAction.php";
require_once "./Modules/Sessions/SessionManager.php";

/*
 * STEPS ON HOW THIS PAGE WORKS
 *
 *
 * (A) Fill Data
 * 1-LOAD Institution info

 *
 *
 *
 * */

//TODO:: uncomment
//error_reporting(E_ERROR | E_PARSE);





try {


    $person=Person::Builder()->setID((int)SessionManager::getID())->setEmail(SessionManager::getEmail())->build();
    $institutionAction = new InstitutionAction($person,$name);
     $institution=$institutionAction->getSingleInstitutionInfo($name);

    // $positions=array();

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




<div  class="col-md-4">
<div class="card" style="width: 18rem;">
  <img src="img/logo (1).png" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">  <?php
        if (isset($institution))
    {
        echo $institution->getName();
    }?></h5>
  </div>
  <div class="card-body">
    <ul>
      <li class="cardli">
        <a href="#" class="card-text"><i class="fas fa-globe"></i> <?php
            if (isset($institution))
            {
                echo $institution->getWebsite();
            }?></a>
      </li>
      <li class="cardli">
        <a href="#cardSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> 
          <i class="fas fa-phone-alt"></i>  
          InstitutionPhones  
        </a>
        <ul class="collapse list-unstyled" id="cardSubmenu">
          <li class="subli">
            <P><?php
                if (isset($institution))
                {
                    echo $institution->getPrimaryPhone();
                }?></P>
            <P><?php
                if (isset($institution))
                {
                    echo $institution->getSecondaryPhone();
                }?></P>
          </li>
        </ul>
      </li>
      <li class="cardli">
        <a href="#cardSubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> 
          <i class="far fa-envelope"></i>
          InstitutionEmails 
        </a>
        <ul class="collapse list-unstyled" id="cardSubmenu1">
          <li class="subli" >
            <p><?php
                if (isset($institution))
                {
                    echo $institution->getEmail();
                }?></p>
            <p><?php
                if (isset($institution))
                {
                    echo $institution->getFax();
                }?></p>
          </li>
        </ul>
      </li>   
    </ul>
    <br />
    <br />
    <br />
  </div>
</div>
</div>


<div align="center" class="col-md-8">
<ul class="nav nav-tabs m-auto" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Folder</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Employees</a>
  </li>


</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    
    <table id="table" border='2' class="table table-responsive mt-3">
  <thead>
    <tr>
      <th scope="col">NO</th>
      <th scope="col">Folder_Name</th>
      <th scope="col">Folder_Type</th>
      <th scope="col">Folder_Size</th>
      <th scope="col">Data_Created</th>
      <th scope="col">Author_Name</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>1.pdf</td>
      <td>Pdf</td>
      <td>1kb</td>
      <td>12/8/2012</td>
      <td>Ahmed</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Security.docx</td>
      <td>Word</td>
      <td>16kb</td>
      <td>24/9/2020</td>
      <td>Yousef</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>1.pdf</td>
      <td>Pdf</td>
      <td>1kb</td>
      <td>12/8/2012</td>
      <td>Ahmed</td>
    </tr>
    <tr>
      <th scope="row">1</th>
      <td>1.pdf</td>
      <td>Pdf</td>
      <td>1kb</td>
      <td>12/8/2012</td>
      <td>Ahmed</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Security.docx</td>
      <td>Word</td>
      <td>16kb</td>
      <td>24/9/2020</td>
      <td>Yousef</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>1.pdf</td>
      <td>Pdf</td>
      <td>1kb</td>
      <td>12/8/2012</td>
      <td>Ahmed</td>
    </tr>
    <tr>
      <th scope="row">1</th>
      <td>1.pdf</td>
      <td>Pdf</td>
      <td>1kb</td>
      <td>12/8/2012</td>
      <td>Ahmed</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Security.docx</td>
      <td>Word</td>
      <td>16kb</td>
      <td>24/9/2020</td>
      <td>Yousef</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>1.pdf</td>
      <td>Pdf</td>
      <td>1kb</td>
      <td>12/8/2012</td>
      <td>Ahmed</td>
    </tr>
    <tr>
      <th scope="row">1</th>
      <td>1.pdf</td>
      <td>Pdf</td>
      <td>1kb</td>
      <td>12/8/2012</td>
      <td>Ahmed</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Security.docx</td>
      <td>Word</td>
      <td>16kb</td>
      <td>24/9/2020</td>
      <td>Yousef</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>1.pdf</td>
      <td>Pdf</td>
      <td>1kb</td>
      <td>12/8/2012</td>
      <td>Ahmed</td>
    </tr>
  </tbody>
</table>

  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    <table id="table2" border='2' class="table table-hover table-responsive mt-3">
  <thead>
    <tr>
      <th scope="col">NO</th>
      <th scope="col">Employee_Name</th>
      <th scope="col">Employee_Email</th>
      <th scope="col">Employee_Number</th>
      <th scope="col">Employee_Birthday</th>
      <th scope="col">Employee_Department</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>1.pdf</td>
      <td>Pdf</td>
      <td>1kb</td>
      <td>12/8/2012</td>
      <td>Ahmed</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Security.docx</td>
      <td>Word</td>
      <td>16kb</td>
      <td>24/9/2020</td>
      <td>Yousef</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>1.pdf</td>
      <td>Pdf</td>
      <td>1kb</td>
      <td>12/8/2012</td>
      <td>Ahmed</td>
    </tr>
    <tr>
      <th scope="row">1</th>
      <td>1.pdf</td>
      <td>Pdf</td>
      <td>1kb</td>
      <td>12/8/2012</td>
      <td>Ahmed</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Security.docx</td>
      <td>Word</td>
      <td>16kb</td>
      <td>24/9/2020</td>
      <td>Yousef</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>1.pdf</td>
      <td>Pdf</td>
      <td>1kb</td>
      <td>12/8/2012</td>
      <td>Ahmed</td>
    </tr>
    <tr>
      <th scope="row">1</th>
      <td>1.pdf</td>
      <td>Pdf</td>
      <td>1kb</td>
      <td>12/8/2012</td>
      <td>Ahmed</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Security.docx</td>
      <td>Word</td>
      <td>16kb</td>
      <td>24/9/2020</td>
      <td>Yousef</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>1.pdf</td>
      <td>Pdf</td>
      <td>1kb</td>
      <td>12/8/2012</td>
      <td>Ahmed</td>
    </tr>
    <tr>
      <th scope="row">1</th>
      <td>1.pdf</td>
      <td>Pdf</td>
      <td>1kb</td>
      <td>12/8/2012</td>
      <td>Ahmed</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Security.docx</td>
      <td>Word</td>
      <td>16kb</td>
      <td>24/9/2020</td>
      <td>Yousef</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>1.pdf</td>
      <td>Pdf</td>
      <td>1kb</td>
      <td>12/8/2012</td>
      <td>Ahmed</td>
    </tr>
  </tbody>
</table>
  </div>
</div>
<br>
<br>
</div>
