<?php
require_once "Modules/Validation/PersonValidator.php";
require_once "Modules/Business/Person.php";
require_once "Modules/Database/MainAction.php";
require_once "Modules/Sessions/SessionManager.php";


error_reporting(E_ERROR | E_PARSE);
//check if user coming From A Request
//This file is deprecated///////////////////////////////////

$mainAction = new MainAction();
SessionManager::sessionLogOut();
if(!SessionManager::validateSession())
{
    header("Location: Home.php");
    header('Cache-Control: no-cache, must-revalidate');
    exit();
}
try {
    $faculties = $mainAction->getAllInstitutions();
    $cities = $mainAction->getAllCities();
    SessionManager::sessionLogOut();

} catch (Exception $e) {
    $FormErrors[] = $e->getMessage();
        header("HTTP/1.1 503 Not Found");
    exit(503);
}


//testing


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //if No Error Send The Email [mail(To ,subject,massage Headers Parameters)]$username =$_POST['username'];
    $phoneNumber = $_POST['phone'];
    $firstName = $_POST['first_name'];
    $middleName = $_POST['second_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $facultyID = $_POST['faculty'];
    $inputGender = $_POST['Gender'];
    $inputCity = $_POST['City'];
    $password = $_POST['password'];
    $Confirm_password = $_POST['Confirm_password'];
    $acd_number = $_POST['acd_number'];
    $personToValidate = Person::Builder()->setFirstName($firstName)
        ->setMiddleName($middleName)
        ->setLastName($lastName)
        ->setEmail($email)
        ->setAcadmicNumber($acd_number)
        ->setPhoneNumber($phoneNumber)
        ->setInstitution($facultyID)
        ->setCity($inputCity)
        ->setGender($inputGender)
        ->build();
    $personValidator = new PersonValidator($personToValidate);
    if (!$personValidator->isValid()) {
        $FormErrors = $personValidator->getERRORSLIST();

    }
    if ($password == $Confirm_password) {
        if (strlen($password) < 8) {
            $FormErrors[] = 'Password Must Be equal or greater than  8  Characters';
        }
    } else {
        $FormErrors[] = 'Passwords Must Be  Equal ';
    }

    $headers = 'From: ' . $email . '\r\n';
    if (empty($FormErrors)) {
        $validPassword = $password;
        $username = '';
        $email = '';
        $password = '';
        $Confirm_password = '';
        $acd_number = '';
        //code for sign up
        if (isset($personToValidate)) {
            try {


                if ($mainAction->SignUp($personToValidate, $validPassword)) {
                    $success = 'Signed Up Successfully';
                    SessionManager::sessionSignIn($personToValidate->getEmail(),$personToValidate->getID());
                    header('Location: index.php,Cache-Control: no-cache, must-revalidate');
                    exit();

                } else {
                    $FormErrors[] = "Could not be registered";
                }
            } catch (SQLStatmentException | DuplicateDataEntry $e) {
                if (strpos($e->getMessage(), "duplicate")) {
                    $FormErrors[] = "Phone Number Is Already Used";}
                else {
                    $FormErrors[]=$e->getMessage();
                }


            }
        }

         else {
            $FormErrors[] = "Could not validate this form";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register form</title>
    <!-- logo  -->
    <link rel="icon" type="image/png" href="../img/favicon.png"/>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="../css/all.min.css"/>
    <link rel="stylesheet" type="text/css" href="../css/register.css"/>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,400;0,700;0,900;1,900&display=swap">
    <!-- Animate css -->
    <link rel="stylesheet" type="text/css" href="../css/animate.min.css">
</head>
<body style="background-image: url(../img/bg.jfif);">
<!--  Start Form  -->
<div class="container">
    <form class="main contact-form card card-outline card-primary" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
        <img class="mb-4 animate__animated animate__zoomIn img" src="../img/logo%20(1).png" alt="" width="200" height="80">
        <?php if (!empty($FormErrors)) { ?>
            <div class="alert alert-danger " role="alert"><span type="button" class="close" data-dismiss="alert"
                                                                aria-label="Close"><span
                            aria-hidden="true">&times;</span></span>
                <?php
                $i = 1;
                foreach ($FormErrors as $error) {
                    echo '<strong>(' . htmlspecialchars($i) . ')</strong>  ' . htmlspecialchars($error) . '<br>';
                    $i++;
                }


                ?>
            </div>
        <?php } ?>
        <?php if (isset($success)) {
            echo '<div class="alert alert-success" role="alert">' . htmlspecialchars($success) . '</div>';
        } ?>
        <div class="form-group">
            <input class="form-control username" type="text" name="first_name" placeholder="First Name"
                   value="<?php if (isset($firstName)) {
                       echo htmlspecialchars($firstName);
                   }; ?>" required/>
            <i class="fa fa-user fa-fw icon"></i>
            <div class="alert alert-danger custum-alert">
                This input Must Be<strong> 4 </strong>chars or More
            </div>
        </div>
        <div class="form-group">
            <input class="form-control username" type="text" name="second_name" placeholder="Middle Name"
                   value="<?php if (isset($middleName)) {
                       echo htmlspecialchars($middleName);
                   } ?>" required/>
            <i class="fa fa-user fa-fw icon"></i>
            <div class="alert alert-danger custum-alert">
                This input Must Be<strong> 4 </strong>char or More
            </div>
        </div>
        <div class="form-group">
            <input class="form-control username" type="text" name="last_name" placeholder="Last Name"
                   value="<?php if (isset($lastName)) {
                       echo htmlspecialchars($lastName);
                   } ?>" required/>
            <i class="fa fa-user fa-fw icon"></i>
            <div class="alert alert-danger custum-alert">
                This input Must Be<strong> 4 </strong>char or More
            </div>
        </div>

        <div class="form-group">
            <input class="form-control email" type="email" name="email" placeholder="Enter Your User Email"
                   value="<?php if (isset($email)) {
                       echo htmlspecialchars($email);
                   } ?>" required/>
            <i class="fa fa-envelope fa-fw icon"></i>
            <div class="alert alert-danger custum-alert">
                This input Cant not Be Empty
            </div>
        </div>

        <div class="form-group">
            <input class="form-control email" type="tel" name="phone" placeholder="Enter Your Phone Number"
                   value="<?php if (isset($phoneNumber)) {
                       echo htmlspecialchars($phoneNumber);
                   } ?>" pattern="[0-9]{11}" required/>
            <i class="fas fa-phone-alt fa-fw icon"></i>
            <div class="alert alert-danger custum-alert">
                This input Cant not Be Empty
            </div>
        </div>

        <div class="form-group">
            <input class="form-control phone" type="password" name="password" placeholder="Enter Password"
                   value="<?php if (isset($password))
                       echo htmlspecialchars($password); ?>" required/>
            <i class="fas fa-key fa-fw icon"></i>
            <div class="alert alert-danger custum-alert">
                This input Must Be <strong>11</strong> Number
            </div>
        </div>

        <div class="form-group">
            <input class="form-control phone" type="password" name="Confirm_password" placeholder="Confirm password"
                   value="<?php if (isset($Confirm_password)) {
                       echo htmlspecialchars($Confirm_password);
                   } ?>" required/>
            <i class="fas fa-lock fa-fw icon"></i>
            <div class="alert alert-danger custum-alert">
                This input Must Be <strong>11</strong> Number
            </div>
        </div>

        <div class="form-group">
            <input class="form-control phone" type="number" name="acd_number" placeholder="Academic Number"
                   value="<?php if (isset($acd_number)) {
                       echo htmlspecialchars($acd_number);
                   } ?>" required/>
            <i class="far fa-address-card fa-fw icon"></i>
            <div class="alert alert-danger custum-alert">
                This input Must Be <strong>11</strong> Number
            </div>
        </div>

        <div style="text-align: left;margin-top: -23px; " class="form-row">
            <div class="form-group col-md-4">
                <label for="inputCity">City:</label>
                <select name="City" id="inputCity" class="form-control" required>

                    <?php

                    foreach ($cities as $city) {
                        $city_name = ucfirst($city->getName());
                        echo "<option value=" . htmlspecialchars($city->getShortcut()) . ">" . htmlspecialchars($city_name) . "</option>";
                    }


                    ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="inputState">Faculty:</label>
                <select name="faculty" id="inputfaculty" class="form-control" required>
                    <?php

                    foreach ($faculties as $faculty) {

                        $faculty_name = htmlspecialchars($faculty->getName());

                        echo '<option value=' . '"' . $faculty->getName() . '"' . '>' . $faculty_name . '</option>';

                    }

                    ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="inputZip">Gender:</label>
                <select name="Gender" id="inputGender" class="form-control" required>
                    <option value="F">Female</option>
                    <option value="M">Male</option>
                </select>
            </div>
        </div>

        <div style="   margin-bottom: 0rem;" class="form-group">
            <input style="background-color: #0274b4;" class="w-100 btn btn-primary btn-block" type="submit"
                   name="submit" value="Register">
            <br>
            <div class="text-center">
                <a href="../General/index.php" class="text-center"> I already have an account</a>
                <p class="mt-3 text-muted">© <?php echo htmlspecialchars(date('Y-n-j') . ' '); ?><a
                            href="mailto:ahmedheshamesmail@gmail.com?subject=feedback">Ahmed hesham</a></p>
            </div>
    </form>
</div>
<!--  End   Form  -->
<script src="../js/jQuery.js"></script>
<script src="../js/popper.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/all.min.js"></script>
<!--  <script src="js/custmeError.js"></script> -->
</body>
</html>