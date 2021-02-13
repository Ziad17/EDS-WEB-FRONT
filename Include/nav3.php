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
                <li class="nav-item">
                    <a class="nav-link <?php if ($name === 'KfsDocs') {echo ' active"';} ?>" href="Home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($name === 'About') {echo ' active"';} ?>" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($name === 'Profile') {echo ' active"';} ?>" href="profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($name === 'Contact') {echo ' active"';} ?>" href="#">Contact</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>