<nav align="center" style="border: 1px solid ;border-radius: 20px" class="navbar navbar-expand-lg navbar-light bg-light">
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
             <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ol style="margin-left: 20px" class="navbar-nav mr-auto">
                  <li class="breadcrumb-item"><a href="Home.php">KfsDocs</a></li>
                    <?php
                       if (isset($name)) {
                          if ($name === 'KfsDocs') {
                            echo  '<li class="breadcrumb-item">....</li>';
                          }elseif($name==="Edit-profile"){
                            echo '<li class="breadcrumb-item"><a href="MyProfile.php">Profile</a></li>';
                            echo  '<li class="breadcrumb-item"><a href="'.$name.'.php">' .$name.'</a></li>';
                         }elseif($name ==="Add-New-Institution"){
                            echo '<li class="breadcrumb-item"><a href="Add-New-Person.php">Add-New-Person</a></li>';
                            echo  '<li class="breadcrumb-item"><a href="'.$name.'.php">' .$name.'</a></li>';
                         }elseif($name ==="Add-New-Position"){
                            echo '<li class="breadcrumb-item"><a href="Add-New-Person.php">Add-New-Person</a></li>';
                            echo  '<li class="breadcrumb-item"><a href="'.$name.'.php">' .$name.'</a></li>';
                         }else{
                          echo  '<li class="breadcrumb-item"><a href="'.$name.'.php">'.$name.'</a></li>';
                         } 
                       }
                   ?>
                </ol>
                 <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <!-- <button class="btn my-2 my-sm-0" type="submit"><i style="font-size: 20px" class="fas fa-search"></i></button> -->
    </form>
    <button class="btn my-2 my-sm-0" type="submit"><i style="font-size: 20px" class="fas fa-bookmark"></i></button><br>

      <div  class="dropdown mr-1">
    <button style="margin: auto;" type="button" class="btn btn-sm dropdown-toggle" id="dropdownNotif" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,20">
      <i style="font-size: 20px" class="fas fa-bell"></i>
    </button>
    <div  class="dropdown-menu" aria-labelledby="dropdownNotif">
      <a class="dropdown-item" href="#">Notification 1</a>
      <a class="dropdown-item" href="#">Notification 2</a>
      <a class="dropdown-item" href="#">Notification 3</a>
      <a class="dropdown-item" href="#">Notification 4</a>
    </div>
  </div>

  <div class="dropdown mr-1">
    <button style="margin: auto;" type="button" class="btn btn-sm dropdown-toggle" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,20">
      <i style="font-size: 20px" class="fas fa-ellipsis-v"></i>
    </button>
    <div align="center"  class="dropdown-menu" aria-labelledby="dropdownMenu">
      <a style="background-color: #f8b739;text-align: center; " class="dropdown-item" href="#">Logout <i class="fas fa-sign-out-alt"></i></a>
    </div>
  </div>

</div>
          
          </div>
        </nav>