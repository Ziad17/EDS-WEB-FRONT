<?php
  $name = 'MyProfile';
require_once '../Paths.php';

require_once(INCLUDE_BASE_PATH.'/headtag.php');
require_once SESSIONS_BASE_PATH."/SessionManager.php";

error_reporting(E_ALL);
SessionManager::sessionSignIn('admin@gmail.com',2);
if(!SessionManager::validateSession())
{
    header("Location: index.php");
    header('Cache-Control: no-cache, must-revalidate');
    exit();
}

?>
  <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
  <body style="padding-right: 15px">
		<div  class="wrapper d-flex align-items-stretch">


      <!-- ----------------------------- start  sidebar ---------------------------------------------->

        <?php require_once(INCLUDE_BASE_PATH.'/sidebar.php');?>

      <!-- ----------------------------- End  sidebar ---------------------------------------------->

        <!-- Page Content  -->

  <div id="content" class="p-4 p-md-5">


    <!----------------------------------- Start nav N 2-------------- --------------------------->

      <?php require_once(INCLUDE_BASE_PATH.'/nav2.php'); ?>

    <!----------------------------------- End nav N 2-------------- --------------------------->

      <!----------------------------------- Start nav N 3-------------- --------------------------->
        
        <?php require_once(INCLUDE_BASE_PATH.'/nav3.php'); ?>

    <!----------------------------------- End nav N 3-------------- --------------------------->
        <!-- Page Content  -->



    <!----------------------------------- Content -------------- --------------------------->

		<div class="container-fluid">
			<div class="row mt-5">
        <?php require_once(INCLUDE_BASE_PATH.'/MyProfile_content.php'); ?>
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
      $('#table3').DataTable();
    });
  </script>
      </div>
		</div>
  </body>
</html>