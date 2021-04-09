<?php
  $name = 'Add-New-Person';
  require_once('Include/headtag.php');
require_once "./Modules/Sessions/SessionManager.php";

/*
 * STEPS ON HOW THIS PAGE WORKS
 * (A)
 *  1-check whether the person has the permission to add new Person
 * */

//TODO:: REMOVE
SessionManager::sessionSignIn('super@gmail.com',1);

if(!SessionManager::validateSession())
{
    header("Location: index.php");
    header('Cache-Control: no-cache, must-revalidate');
    exit();
}


 ?>
 <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
  <body>
		<div  class="wrapper d-flex align-items-stretch">

      <!-- ----------------------------- start  sidebar ---------------------------------------------->

        <?php require_once('Include/sidebar.php');?>

      <!-- ----------------------------- End  sidebar ---------------------------------------------->

        <!-- Page Content  -->

  <div id="content" class="p-4 p-md-3">
      <!----------------------------------- Start nav N 3-------------- --------------------------->
        
        <?php require_once('Include/nav3.php'); ?>

    <!----------------------------------- End nav N 3-------------- --------------------------->

    <!----------------------------------- Content -------------- --------------------------->

		<div class="container">
			<div class="row m-auto d-block">
        <?php
        try {
            require_once('Include/Add-New-Person-Content.php');
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
        require_once('Include/script.php');
      ?>
      <script src="js/jquery.dataTables.js"></script>
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