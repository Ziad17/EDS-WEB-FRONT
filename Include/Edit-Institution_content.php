<?php



error_reporting(E_ALL);
$name=$_GET['institution'];
if(!isset($name) || trim($name)=="")
{
    echo 'Nothing To Show';
    exit();
}
try {
    $person=Person::Builder()->setID((int)SessionManager::getID())->setEmail(SessionManager::getEmail())->build();
    $institutionAction = new InstitutionAction($person);
    $institution=$institutionAction->getSingleInstitutionInfo($name);
    $id=$institutionAction->getInstitutionIDByName($name);
    $bool1=$institutionAction->canEditInstitutionInfo();
    $bool2=$institutionAction->isEmployeeOfInstitution($id);
    $canEdit=$bool1 && $bool2;
    if(!$canEdit)
    {
        echo "You Don't Have The Permissions To Edit This Institution";
        exit();
    }
    $fileAction = new FileAction($person);
    $handler = new FileRepoHandler($fileAction);
    $institutionName=$institution->getName();
    $primaryPhone=$institution->getPrimaryPhone();
    $secondaryPhone=$institution->getSecondaryPhone();
    $fax=$institution->getFax();
    $email=$institution->getEmail();
    $website=$institution->getWebsite();
    $image=$institution->getInstitutionImg();
    $mainAction = new MainAction();
    $types=$mainAction->getInstitutionTypes();
    $institution_type_id=$institution->getType();





    if($_SERVER['REQUEST_METHOD']=='POST')
    {

        $institutionOld=Institution::Builder()
            ->setName($institutionName)
            ->setPrimaryPhone($primaryPhone)
            ->setSecondaryPhone($secondaryPhone)
            ->setFax($fax)
            ->setEmail($email)
            ->setWebsite($website)
            ->setTypeId($institution_type_id)
            ->setID($id)
            ->build();


        $institutionName=$_POST['institution_name'];
        $primaryPhone=$_POST['primary_phone'];
        $secondaryPhone=$_POST['secondary_phone'];
        $fax=$_POST['fax'];
        $email=$_POST['email'];
        $website=$_POST['website'];
        $institution_type_id=$_POST['institution_type_id'];

        $institutionUpdate=Institution::Builder()
            ->setName($institutionName)
            ->setPrimaryPhone($primaryPhone)
            ->setSecondaryPhone($secondaryPhone)
            ->setFax($fax)
            ->setEmail($email)
            ->setWebsite($website)
            ->setTypeId($institution_type_id)
            ->setID($id)
            ->build();

        if($institutionAction->editInstitutionInfo($institutionOld,$institutionUpdate))
        {
            echo 'success';
        }
        else{echo 'fail';}








    }



}
catch (DataNotFound $Ee)
{
    echo 'Nothing To Show Wrong Institution';
    exit();
}

catch (Exception $e) {
    //FIXME::HANDLE ERRORS
    echo $e->getMessage();
    $FormErrors[] = $e->getMessage();

}


?>







<div align="center" class="col-md-4">


</div>


<div align="center" class="col-md-8">
    <form class="form-style" action="" method="POST" accept-charset="utf-8">
        <h1>General</h1>


        <div class="form-group row">
            <label for="Name" class="col-sm-3 col-form-label">Name</label>
            <div class="col-sm-9">
                <input class="form-control" id="Name" type="text" name="institution_name" placeholder="Enter The Institution Name" value="<?php if (isset($institutionName)) {echo htmlspecialchars($institutionName);};?>" required/>
            </div>
        </div>

        <div class="form-group row">
            <label for="Phone" class="col-sm-3 col-form-label">Primary Phone</label>
            <div class="col-sm-9">
                <input class="form-control" id="PrimaryPhone" type="tel" name="primary_phone" placeholder="Enter The Primary Phone Number" value="<?php if (isset($primaryPhone)) {echo htmlspecialchars($primaryPhone);};?>" pattern="[0-9]*" />
            </div>
        </div>

        <div class="form-group row">
            <label for="Phone" class="col-sm-3 col-form-label">Secondary Phone</label>
            <div class="col-sm-9">
                <input class="form-control" id="SecondaryPhone" type="tel" name="secondary_phone" placeholder="Enter The Secondary Phone" value="<?php if (isset($secondaryPhone)) {echo htmlspecialchars($secondaryPhone);};?>" pattern="[0-9]*" />
            </div>
        </div>
        <div class="form-group row">
            <label for="Phone" class="col-sm-3 col-form-label">Website</label>
            <div class="col-sm-9">
                <input class="form-control" id="Website" type="text" name="website" placeholder="Enter The Website" value="<?php if (isset($website)) {echo htmlspecialchars($website);};?>"  />
            </div>
        </div>

        <div class="form-group row">
            <label for="Phone" class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-9">
                <input class="form-control" id="Email" type="text" name="email" placeholder="Enter The Email" value="<?php if (isset($email)) {echo htmlspecialchars($email);};?>"  />
            </div>
        </div>

        <div class="form-group row">
            <label for="Phone" class="col-sm-3 col-form-label">Fax</label>
            <div class="col-sm-9">
                <input class="form-control" id="Fax" type="text" name="fax" placeholder="Enter The Fax" value="<?php if (isset($fax)) {echo htmlspecialchars($fax);};?>"  />
            </div>
        </div>

        <div class="form-group row">
            <label for="Phone" class="col-sm-3 col-form-label">Institution Type</label>
            <div class="col-sm-9">
            <select name="institution_type_id" class="form-control" required>

                <?php

                foreach ($types as $type) {

                    $Typeid=(int)$type->getId();
                    $title=(string)$type->getType();
                    if($Typeid==institution_type_id)
                    {
                        echo "<option value=" . htmlspecialchars($Typeid) . "selected>" . htmlspecialchars($title) . "</option>";

                    }
                    else
                    {
                        echo "<option value=" . htmlspecialchars($Typeid) . ">" . htmlspecialchars($title) . "</option>";

                    }
                }

                ?>
            </select>
            </div>

        </div>

        <div class="form-group row">
            <div class="col-sm-12">
                <button type="submit" name="save_info"  value='save_info' class=" col-sm-12 btn btn-primary ">Save</button>
            </div>
        </div>
    </form>




</div>
