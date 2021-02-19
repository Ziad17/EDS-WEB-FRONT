<?php 
  //check if user coming From A Requset
require_once "Modules/Database/MainAction.php";
require_once "Modules/Sessions/SessionManager.php";
error_reporting(E_ERROR | E_PARSE);

if(SessionManager::validateSession())
{
    header("Location: Home.php");
    header('Cache-Control: no-cache, must-revalidate');
    exit();
}
if ($_SERVER['REQUEST_METHOD']== 'POST') {

  $email =filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
  $password =filter_var($_POST['password'],FILTER_SANITIZE_STRING);

  //Creating Array Of Errors

  $FormErrors = array();
////////////////////////////////////////////////////

  if (!empty($email)) 
  {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
     {
       $FormErrors[]='Email Address Is Considered <strong> Invalid </strong>';
     }
  }else
  {
    $FormErrors[]='Email Address Is  <strong> Empty </strong>';
  }
////////////////////////////////////////////////////

    

      if(strlen($password) < 8 ){
      $FormErrors[]='Password Must Be <strong> 8 </strong> Chararcter';
       }
  

//////////////////////////////////
  if(empty($FormErrors)){

      try {
          $validEmail=$email;
          $validPassword=$password;
          $mainAction=new MainAction();
          if($mainAction->isUserExists($validEmail,$validEmail))
          {
              $id=$mainAction->signIn($validEmail,$validPassword);
              if($id)
              {
                  $email = '';
                  $password = '';
                  $success = '<div class="alert alert-success" role="alert">Successful</div>';
                  SessionManager::sessionSignIn($validEmail,$id);

                  header("Location: Home.php");
                  header('Cache-Control: no-cache, must-revalidate');

                  exit();
              }
              else{$FormErrors[]="Wrong Password";}


          }
          else{
              $FormErrors[]="These credentials doesn't exist, please sign up";
          }
      } catch (Exception  $e )
      {
          $FormErrors[]=$e->getMessage();
          header("HTTP/1.1 503 Not Found");
exit();

      }
  }
  }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login form</title>
      <!-- logo  -->
  <link rel="icon" type="image/png" href="img/favicon.png" />
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="css/all.min.css" />
  <link rel="stylesheet" type="text/css" href="css/register.css" />
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,400;0,700;0,900;1,900&display=swap" >
      <!-- Animate css -->
    <link rel="stylesheet" type="text/css" href="css/animate.min.css">
</head>
<body style="background-image: url(img/bg.jfif);"> 
  <!--  Start Form  -->
  <div class="container">
    <form  class="main contact-form card card-outline card-primary" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
      <img  class="mb-4 animate__animated animate__zoomIn img" src="img/logo (1).png" alt="" width="200" height="80">
      <?php if (!empty($FormErrors)) { ?>
        <div class="alert alert-danger " role="alert"> <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
        <?php 
          $i=1;
            foreach ($FormErrors as $error) {
              echo '<strong>('.$i.')</strong>  '.  $error.'<br>';
              $i++;
            }
          
          
         ?>
         </div>
         <?php } ?>
         <?php if(isset($success)){echo $success;} ?>
 
      <div class="form-group">
        <input class="form-control email" type="email" name="email"   placeholder="Enter Your User Email"
        value="<?php if (isset($email)){echo $email;  }?>"  required/>
        <i class="fa fa-envelope fa-fw icon"></i>
        <div class="alert alert-danger custum-alert">
          This input  Cant not Be Empty
        </div>
      </div>

      <div class="form-group">
        <input class="form-control phone" type="password" name="password"    placeholder="Enter Password"
        value="<?php if (isset($password)){echo $password;  }?>" required/>
        <i class="fas fa-key fa-fw icon"></i>
        <div class="alert alert-danger custum-alert">
          This input Must Be <strong>11</strong> Number 
        </div>
      </div>

    
      <div  style="   margin-bottom: 0rem;" class="form-group">
      <input style="background-color: #0274b4;" class="w-100 btn btn-primary btn-block" type="submit" name="submit" value="Login">
      <br>
      <div class="text-center">
               <a href="register.php" class="text-center"> I dont have an account </a>
    <p class="mt-3 text-muted">© <?php echo date('Y-n-j').' '; ?><a href="mailto:ahmedheshamesmail@gmail.com?subject=feedback">Ahmed hesham</a></p>
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