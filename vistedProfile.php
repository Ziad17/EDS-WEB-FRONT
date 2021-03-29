<?php
  $name = 'VistedProfile';
  require_once('Include/headtag.php');
 ?>
  <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
  <body>
		<div  class="wrapper d-flex align-items-stretch">



        <!-- Page Content  -->

  <div id="content" class="p-4 p-md-5">



    <!----------------------------------- Start nav N 2-------------- --------------------------->

<nav style="border:1px solid;border-radius: 20px;padding: 10px" class="navbar navbar-light bg-light  mx-auto d-block w-25 border-dark">
  <div align="right">
   <button class="btn my-2 my-sm-0" type="submit"><i style="font-size: 30px" class="fas fa-lock"></i></button>
   <button class="btn my-2 my-sm-0" type="submit"><i style="font-size: 30px" class="fab fa-telegram-plane"></i></button>
  </div>
</nav>

    <!----------------------------------- Content -------------- --------------------------->

		<div class="container">
			<div class="row">
        <?php require_once('Include/VistedProfile_content.php'); ?>
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