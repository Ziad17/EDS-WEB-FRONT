<?php
require_once "Modules/Validation/PersonValidator.php";
require_once "Modules/Business/Person.php";

//check if user coming From A Request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //if No Error Send The Email [mail(To ,subject,massage Headers Parameters)]$username =$_POST['username'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $Confirm_password = $_POST['Confirm_password'];
    $acd_number = $_POST['acd_number'];
    $personValidator = new PersonValidator(Person::Builder()->setFirstName($username)
        ->setEmail($email)
        ->setAcadmicNumber($acd_number)
        ->setPhoneNumber("")
        ->setInstitution("")
        ->setCity("")
        ->build());
    $personValidator->validate();
    if ($personValidator->isErrorPresent()) {
        $FormErrors[] = $personValidator->getError();
    }
    if ($password == $Confirm_password) {
        if (strlen($password) < 8) {
            $FormErrors[] = 'Password Must Be <strong> 8 </strong> Chararcter';
        }
    }
    else {
        $FormErrors[] = 'Password Must Be <strong> Equal </strong> Confirm_password';
    }

    $headers = 'From: ' . $email . '\r\n';
    if (empty($FormErrors)) {
        $username = '';
        $email = '';
        $password = '';
        $Confirm_password = '';
        $acd_number = '';
        $success = '<div class="alert alert-success" role="alert">We Have Recieved Your Massage </div>';
        //code for sign up
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
    <link rel="icon" type="image/png" href="img/favicon.png"/>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/all.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/register.css"/>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,400;0,700;0,900;1,900&display=swap">
    <!-- Animate css -->
    <link rel="stylesheet" type="text/css" href="css/animate.min.css">
</head>
<body style="background-image: url(img/bg.jfif);">
<!--  Start Form  -->
<div class="container">
    <form class="main contact-form card card-outline card-primary" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
        <img class="mb-4 animate__animated animate__zoomIn img" src="img/logo (1).png" alt="" width="200" height="80">
        <?php if (!empty($FormErrors)) { ?>
            <div class="alert alert-danger " role="alert"><span type="button" class="close" data-dismiss="alert"
                                                                aria-label="Close"><span
                            aria-hidden="true">&times;</span></span>
                <?php
                $i = 1;
                foreach ($FormErrors as $error) {
                    echo '<strong>(' . $i . ')</strong>  ' . $error . '<br>';
                    $i++;
                }


                ?>
            </div>
        <?php } ?>
        <?php if (isset($success)) {
            echo $success;
        } ?>
        <div class="form-group">
            <input class="form-control username" type="text" name="username" placeholder="Enter Your User Name"
                   value="<?php if (isset($username)) {
                       echo $username;
                   }; ?>" required/>
            <i class="fa fa-user fa-fw icon"></i>
            <div class="alert alert-danger custum-alert">
                This input Must Be<strong> 4 </strong>char or More
            </div>
        </div>

        <div class="form-group">
            <input class="form-control email" type="email" name="email" placeholder="Enter Your User Email"
                   value="<?php if (isset($email)) {
                       echo $email;
                   }; ?>" required/>
            <i class="fa fa-envelope fa-fw icon"></i>
            <div class="alert alert-danger custum-alert">
                This input Cant not Be Empty
            </div>
        </div>

        <div class="form-group">
            <input class="form-control phone" type="password" name="password" placeholder="Enter Password"
                   value="<?php if (isset($password)) {
                       echo $password;
                   }; ?>" required/>
            <i class="fas fa-key fa-fw icon"></i>
            <div class="alert alert-danger custum-alert">
                This input Must Be <strong>11</strong> Number
            </div>
        </div>

        <div class="form-group">
            <input class="form-control phone" type="password" name="Confirm_password" placeholder="Confirm password"
                   value="<?php if (isset($Confirm_password)) {
                       echo $Confirm_password;
                   }; ?>" required/>
            <i class="fas fa-lock fa-fw icon"></i>
            <div class="alert alert-danger custum-alert">
                This input Must Be <strong>11</strong> Number
            </div>
        </div>

        <div class="form-group">
            <input class="form-control phone" type="number" name="acd_number" placeholder="Academic Number"
                   value="<?php if (isset($acd_number)) {
                       echo $acd_number;
                   }; ?>" required/>
            <i class="far fa-address-card fa-fw icon"></i>
            <div class="alert alert-danger custum-alert">
                This input Must Be <strong>11</strong> Number
            </div>
        </div>

        <div style="text-align: left;margin-top: -23px; " class="form-row">
            <div class="form-group col-md-4">
                <label for="inputCity">City:</label>
                <select name="City" id="inputCity" class="form-control" required>
                    <option value="" selected>Choose...</option>
                    <option value="Cairo">Cairo</option>
                    <option value="Alexandria">Alexandria</option>
                    <option value="Gizeh">Gizeh</option>
                    <option value="Shubra El-Kheima">Shubra El-Kheima</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="inputState">facalty:</label>
                <select name="facalty" id="inputfacalty" class="form-control" required>
                    <option value="" selected>Choose...</option>
                    <option value="Science">Science</option>
                    <option value="Medicine">Medicine</option>
                    <option value="commerce">commerce</option>
                    <option value="engineering">engineering</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="inputZip">Grnder:</label>
                <select name="Grnder" id="inputGrnder" class="form-control" required>
                    <option value="" selected>Choose...</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
        </div>

        <div style="   margin-bottom: 0rem;" class="form-group">
            <input style="background-color: #0274b4;" class="w-100 btn btn-primary btn-block" type="submit"
                   name="submit" value="Register">
            <br>
            <div class="text-center">
                <a href="index.php" class="text-center"> I already have an account</a>
                <p class="mt-3 text-muted">© <?php echo date('Y-n-j') . ' '; ?><a
                            href="mailto:ahmedheshamesmail@gmail.com?subject=feedback">Ahmed hesham</a></p>
            </div>
    </form>
</div>
<!--  End   Form  -->
<script src="js/jQuery.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/all.min.js"></script>
<!--  <script src="js/custmeError.js"></script> -->
</body>
</html>