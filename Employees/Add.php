<?php
  $name = 'Add-New-Person';
require_once "../Paths.php";

require_once INCLUDE_BASE_PATH."/headtag.php";

require_once SESSIONS_BASE_PATH."/SessionManager.php";

/*
 * STEPS ON HOW THIS PAGE WORKS
 * (A)
 *  1-check whether the person has the permission to add new Person
 * */

//TODO:: REMOVE
//SessionManager::sessionSignIn('admin@gmail.com',2);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!SessionManager::validateSession())
{
    header("Location: index.php");
    header('Cache-Control: no-cache, must-revalidate');
    exit();
}


 ?>
 <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
  <body>
		<div  class="wrapper d-flex align-items-stretch">

      <!-- ----------------------------- start  sidebar ---------------------------------------------->

        <?php require_once INCLUDE_BASE_PATH.'/sidebar.php';?>

      <!-- ----------------------------- End  sidebar ---------------------------------------------->

        <!-- Page Content  -->

  <div id="content" class="p-4 p-md-3">
      <!----------------------------------- Start nav N 3-------------- --------------------------->
        
        <?php require_once INCLUDE_BASE_PATH.'/nav3.php'; ?>

    <!----------------------------------- End nav N 3-------------- --------------------------->

    <!----------------------------------- Content -------------- --------------------------->

		<div class="container">
			<div class="row m-auto d-block">
        <?php
        try {
            require_once(INCLUDE_BASE_PATH.'/Add-New-Person-Content.php');
        }
        catch ( Exception $exception){echo $exception->getMessage(); }?>
			</div>

          <footer class="row">
            <div class="col-md-12 footer">
                  <p class="mb-3 text-muted">&copy; 2021 <a href="mailto:ahmedheshamesmail@gmail.com?subject=feedback">Ahmed hesham</a></p>
            </div>
          </footer>


	    </div>
      <?php 
        require_once(INCLUDE_BASE_PATH.'/script.php');
      ?>
      <script src="../js/jquery.dataTables.js"></script>
    <script type = "text/javascript">
    $(document).ready(function(){
      $('#table').DataTable();
      $('#table2').DataTable();
    });
  </script>
      </div>
		</div>
  </body>
</html>