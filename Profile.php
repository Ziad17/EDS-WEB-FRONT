<?php
  $name = 'User Profile';
  require_once('Include/headtag.php');
require_once "./Modules/Encryption/EncryptionManager.php";
require_once "./Modules/Sessions/SessionManager.php";
require_once "./Modules/Business/Person.php";

require_once "./Modules/Database/MainAction.php";

if(!SessionManager::validateSession())
{
    header("Location: index.php");
    header('Cache-Control: no-cache, must-revalidate');
    exit();
}
if(isset($_GET['user']))
{
try {
    $personRef = Person::Builder()->setID(SessionManager::getID())->setEmail(SessionManager::getEmail())->build();

    $mainAction = new MainAction();
    $email = EncryptionManager::Decrypt($_GET['user']);
    if ($email == $personRef->getEmail()) {

        header('Location: MyProfile.php');
    }
}
catch (Exception $e){
    echo $e->getMessage();
}
}
else{
    header("HTTP/1.1 503 Not Found");
    exit(503);
}


 ?>
  <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
  <body style="padding-right: 15px">
		<div  class="wrapper d-flex align-items-stretch">


     <!-- ----------------------------- start  sidebar ---------------------------------------------->

        <?php require_once('Include/sidebar.php');?>

      <!-- ----------------------------- End  sidebar ---------------------------------------------->

        <!-- Page Content  -->

  <div id="content" class="p-4 p-md-5">


    <!----------------------------------- Start nav N 2-------------- --------------------------->

      <?php require_once('Include/nav2.php'); ?>

    <!----------------------------------- End nav N 2-------------- --------------------------->

      <!----------------------------------- Start nav N 3-------------- --------------------------->
        
        <?php require_once('Include/nav3.php'); ?>

    <!----------------------------------- End nav N 3-------------- --------------------------->
        <!-- Page Content  -->



    <!----------------------------------- Content -------------- --------------------------->

		<div class="container-fluid">
			<div class="row mt-5">

        <?php
        if(isset($_GET['user']))
        {

            $mainAction=new MainAction();
            $email=EncryptionManager::Decrypt($_GET['user']);

            if($mainAction->isUserExists($email))
            {
                require_once('Include/VistedProfile_content.php');

            }
            else{echo "Not Found";}

        }
        else{
            header("HTTP/1.1 503 Not Found");
            exit(503);
        }
        ?>
			</div>					 

          <footer class="row">
            <div class="col-md-12 footer">
                  <p class="mb-3 text-muted">&copy; 2021 <a href="mailto:ahmedheshamesmail@gmail.com?subject=feedback">Ahmed hesham</a></p>
            </div>
          </footer>


	    </div>
      <?php 
        require_once('Include/script.php');
      ?>
       <script src="js/jquery.dataTables.js"></script>
    <script type = "text/javascript">
    $(document).ready(function(){
      $('#table').DataTable();
      $('#table2').DataTable();
      $('#table3').DataTable();
    });
  </script>
      </div>
		</div>
  </body>
</html>