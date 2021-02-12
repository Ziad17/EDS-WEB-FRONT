<?php
  $name = 'KfsDocs';
  require_once('Include/headtag.php');
 ?>
  <body>
		<div  class="wrapper d-flex align-items-stretch">
			<nav  id="sidebar">
				<div class="p-4  sidch">
		  		<a href="img/undraw_male_avatar_323b.svg"><img style="border-radius: 50%;padding: 5px" src="img/undraw_male_avatar_323b.svg" width="100px" height="100px" alt=""></a>
					<h6  style="color: #fff;text-shadow: 5px 5px 5px #fff">Eng:Ahmed Hesham</h6>
					<span class="country">Web Designer</span>
					<hr style="color: #fff;background-color: #fff;">
	        <ul  class="list-unstyled components mb-5">
	          <li class="active">
	            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-home"></i> Home &nbsp &nbsp </a>
	            <ul class="collapse list-unstyled" id="homeSubmenu">
                <li>
                    <a class="drobli" href="#">Home 1</a>
                </li>
                <li>
                    <a class="drobli" href="#">Home 2</a>
                </li>
                <li>
                    <a class="drobli" href="#">Home 3</a>
                </li>
	            </ul>
	          </li>
	          <li>
	              <a href="#"><i class="fas fa-project-diagram"></i> Project</a>
	          </li>
	          <li>
              <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i class="fas fa-university"></i> Colleges </a>
              <ul class="collapse list-unstyled" id="pageSubmenu">
                <li>
                    <a class="drobli" href="#"><i class="fas fa-vials"></i> Science and Engineering</a>
                </li>
                <li>
                    <a class="drobli" href="#"><i class="fas fa-hand-holding-medical"></i> Medical colleges</a>
                </li>
                <li>
                    <a class="drobli" href="#"><i class="far fa-building"></i> Humanitarian and educational</a>
                </li>
              </ul>
	          </li>
	          <li>
              <a href="#">Portfolio</a>
	          </li>
	          <li>
              <a  href="#">
                <button onMouseOver="this.style.color='#f8b739'" onMouseOut="this.style.color='#f8b739'" type="button" class="btn " data-toggle="modal" data-target="#section">
                  <i class="fas fa-stream"></i>
                   Create new section
                </button>
              </a>
	          </li>
	        </ul>
	      </div>
    	</nav>

        <!-- Page Content  -->
  <div id="content" class="p-4 p-md-5">
  <!-- ----------------------------- start  nav N 1 ---------------------------------------------->
    <div>
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <!-- Button Create new section modal -->
          <button type="button" class="btn " data-toggle="modal" data-target="#section">
          <i class="fas fa-stream"></i> Create new section
          </button> 
            <!-- Modal Create new section -->
          <div class="modal fade" id="section" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content ">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-stream"></i> New Section</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="form-group">
                      <label for="formGroupExampleInput">Create new section</label>
                      <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Section Name">
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-warning">Creat</button>
                </div>
              </div>
            </div>
          </div>
          <!--End Modal section -->
        </li>
          <li class="nav-item" role="presentation">
          <!--   Button Create new Folder modal -->
        <button type="button" class="btn " data-toggle="modal" data-target="#Folder">
          <i class="fas fa-folder-plus"></i> Create new Folder
        </button> 
          <!-- Modal Create new Folder -->
        <div class="modal fade" id="Folder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content ">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-folder-plus"></i> New Folder</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form>
                  <div class="form-group">
                    <label for="formGroupExampleInput">Create new Folder</label>
                    <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Section Name">
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning">Create</button>
              </div>
            </div>
          </div>
        </div>
        <!--End ModalCreate new Folder -->
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
          </li>
        </ul>
      </div>
      <!----------------------------------- End nav N 1-------------- --------------------------->
      <!----------------------------------- Start nav N 2-------------- --------------------------->
      <nav aria-label="breadcrumb">
        <ol style="background-color: #f8f9fa;margin-top: 15px;    box-shadow: 1px 1px 3px rgb(0 0 0 / 10%)" class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Library</a></li>
          <li class="breadcrumb-item active" aria-current="page">Data</li>
        </ol>
      </nav>
      <!----------------------------------- End nav N 2-------------- --------------------------->
      <!----------------------------------- Start nav N 3-------------- --------------------------->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">
            <button  type="button" id="sidebarCollapse" class="btn btn-outline-dark">
              <i  class="fas fa-chevron-right"></i>
              <span class="sr-only">Toggle Menu</span>
            </button>
            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" 
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" 
            aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <div align="center" class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="nav navbar-nav ml-auto ">
                <li class="nav-item active">
                    <a class="nav-link active" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Portfolio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <!----------------------------------- End nav N 3-------------- --------------------------->
		<div class="container">
			<div class="row">
			  <div align="center" class="col-md-12">
            <form action="" method="POST" accept-charset="utf-8">
              <div class="file-drop-area">
                <i style="color: orange;font-size: 22px" class="fas fa-cloud-upload-alt"></i>
                <span class="file-msg">
                Folder is empty.<br>
                Click, or drag your first file here!
                </span>
                <input class="file-input" type="file" multiple required="">
              </div>
              <input class="btn w-25 btn-md btn-warning float-lg-right" type="submit" name="submit" value="uplode">
            </form>
              <table class="float-lg-left">
                <thead>
                  <tr>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>File Name :</td>
                  </tr>
                  <tr>
                    <td>File Size :</td>
                  </tr>
                  <tr>
                    <td>File Extantion :</td>
                  </tr>
                </tbody>
              </table>
				</div>
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