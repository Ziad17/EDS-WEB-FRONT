<?php
  $name = 'KfsDocs';
  require_once('Include/headtag.php');
 ?>
  <body>
		<div  class="wrapper d-flex align-items-stretch">

      <!-- ----------------------------- start  sidebar ---------------------------------------------->

        <?php require_once('Include/sidebar.php');?>

      <!-- ----------------------------- End  sidebar ---------------------------------------------->

        <!-- Page Content  -->

  <div id="content" class="p-4 p-md-5">

    <!-- ----------------------------- start  nav N 1 ---------------------------------------------->

      <?php require_once('Include/nav1.php'); ?>

    <!----------------------------------- End nav N 1-------------- --------------------------->

    <!----------------------------------- Start nav N 2-------------- --------------------------->

      <?php require_once('Include/nav2.php'); ?>

    <!----------------------------------- End nav N 2-------------- --------------------------->

      <!----------------------------------- Start nav N 3-------------- --------------------------->
        
        <?php require_once('Include/nav3.php'); ?>

    <!----------------------------------- End nav N 3-------------- --------------------------->

    <!----------------------------------- Content -------------- --------------------------->

		<div class="container">
			<div class="row">
        <?php require_once('Include/content.php'); ?>
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
      </div>
		</div>
  </body>
</html>