			<nav  id="sidebar">
				<div class="p-4  sidch">
		  		<div align="center">
            <img style="border-radius: 50%;padding: 5px" src="img/undraw_male_avatar_323b.svg" width="100px" height="100px" alt="Profile_Img">
            <h6  style="color: #fff;text-shadow: 5px 5px 5px #fff">Eng:Ahmed Hesham</h6>
            <span class="country">Web Designer</span>
            <hr style="color: #fff;background-color: #fff;font-size: 15px;  border-style: inset;
            border-width: 1px;">
          </div>
	        <ul  class="list-unstyled components mb-5">
	          <li <?php if ($name === 'KfsDocs') {echo 'class="active"';};?>>
              <a href="Home.php"><i class="fas fa-home"></i> Home</a>
	          <li  <?php if ($name === 'Project') {echo 'class="active"';};?>>
	              <a href="#"><i class="fas fa-project-diagram"></i> Project</a>
	          </li>
	          <li>
              <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i class="far fa-folder-open"></i> Faculty Folder </a>
              <ul class="collapse list-unstyled" id="pageSubmenu">
                <li >
                    <a class="drobli" href="#"><i class="fas fa-laptop-code"></i> Computer and Info</a>
                </li>
                <li>
                    <a class="drobli" href="#"><i class="fas fa-book-reader"></i>  Arts</a>
                </li>
                <li>
                    <a class="drobli" href="#"><i class="fas fa-cash-register"></i> Commerce</a>
                </li>
              </ul>
	          </li>
	          <li <?php if ($name === 'Profile') {echo 'class="active"';};?>>
              <a href="profile.php"><i class="far fa-user"></i> Profile</a>
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