<?php
require_once '../Paths.php';

require_once VALIDATION_BASE_PATH."/PersonValidator.php";
require_once BUSINESS_BASE_PATH."/Person.php";
require_once SESSIONS_BASE_PATH."/SessionManager.php";
require_once DATABASE_BASE_PATH."/PersonAction.php";
require_once FILE_MANAGEMENT_BASE_PATH."/FileRepoHandler.php";
require_once DATABASE_BASE_PATH."/FileAction.php";



error_reporting(E_ALL);
try {

    $personRef = Person::Builder()->setID(SessionManager::getID())->setEmail(SessionManager::getEmail())->build();
    $Action = new PersonAction($personRef);

    $fileAction = new FileAction($personRef);
    $handler = new FileRepoHandler($fileAction);
    //fill Info
    $detailedPersonRef=$Action->getMyDetails();

    $image=$detailedPersonRef->getImgRef();


}

catch (Exception $e) {
    //FIXME::HANDLE ERRORS
    echo $e->getMessage();
    $FormErrors[] = $e->getMessage();
    // header("HTTP/1.1 503 Not Found");
    //exit(503);
}
?>
<div class="col-md-3">
	<div class="card-group">
		<div class="card" style="padding: 20px;border-top: 3px  solid #f8b739;border-bottom: 3px  solid #f8b739 ">
			<a style="		
			    position: absolute;
			    left: 85%;
			    top: 0px;
			    color: #343a40;
			    font-size: 20px;
			"  href="../Employees/EditProfile.php"><i class="fas fa-user-edit"></i></a>
			<img style="border-radius: 50%;padding: 5px" src=<?php  if(isset($image) )
            {

                echo $handler->getImagePrivateURI($image);
            }
            else{echo '../img/undraw_male_avatar_323b.svg';}?> width="100px" height="100px" class="card-img-top" alt="...">
			<div class="card-body">
				<h5 class="card-title"><?php  if(isset($detailedPersonRef))
                    {

                        echo htmlspecialchars(trim($detailedPersonRef->getFirstName()." ".$detailedPersonRef->getMiddleName()." ".$detailedPersonRef->getLastName()));
                    }?></h5>
				
					<p class="card-text"><?php  if(isset($detailedPersonRef))
					{
					    $roles= $detailedPersonRef->getRoles();
					    echo htmlspecialchars($roles[0]->getJobDesc());
					}?>
                    </p>
					<p class="card-text"><?php  if(isset($detailedPersonRef))
                        {
                            $roles= $detailedPersonRef->getRoles();
                            echo htmlspecialchars($roles[0]->getInstitutionName());
                        }?></p>
					<p class="card-text"> <?php  if(isset($detailedPersonRef))
                        {

                            echo htmlspecialchars($detailedPersonRef->getEmail());
                        }?></p>
				</pre>
				<br>
				<br>
				<br>
				<br>

			</div>
		</div>
	</div>
</div>
<!----------------------------------------------------------------------->
<!----------------------------------------------------------------------->
<div class="col-md-9">
	<div class="row">
		<div class="col-md-7">
			
		</div>
		<div class="col-md-5">
			<nav style="border:1px solid;padding: 10px" class="navbar navbar-light bg-light  mx-auto d-block  border-dark">
			  <div align="right">
			   	<button class="btn my-2 my-sm-0" type="submit"><i style="font-size: 30px" class="fas fa-folder-plus" data-toggle="modal" data-target="#Folder"></i></button>
			   	  <!-- Modal Create new Folder -->
        <div class="modal fade" id="Folder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content ">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-folder-plus"></i> Add Folder</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                 <form>
                      <p>
                          <input type="file" id="file2" multiple onchange="GetFileSizeNameAndType2()"  required/>
                      </p>

                      <div id="fp2"></div>
                      <p>
                          <div id="divTotalSize"></div>
                      </p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  <input type="submit" class="btn btn-warning" value="Add">
                </div>
                </form>
            </div>
          </div>
        </div>
        <!--End ModalCreate new Folder -->
			   	<button class="btn my-2 my-sm-0" type="submit"><i style="font-size: 30px" class="fas fa-file-medical" data-toggle="modal" data-target="#section"></i></button>
			   	            <!-- Modal Create new section -->
          <div class="modal fade" id="section" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content ">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-file-medical"></i> Add File</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form>
                      <p>
                          <input type="file" id="file" multiple onchange="GetFileSizeNameAndType()"  required/>
                      </p>

                      <div id="fp"></div>
                      <p>
                          <div id="divTotalSize"></div>
                      </p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  <input type="submit" class="btn btn-warning" value="Add">
                </div>
                </form>
              </div>
            </div>
          </div>
          <!--End Modal section -->
			  </div>
			</nav>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<ul class="nav nav-tabs m-auto" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <a class="nav-link active" id="Public-tab" data-toggle="tab" href="#Public" role="tab" aria-controls="Public" aria-selected="true">Public Activity</a>
  </li>

  <li class="nav-item" role="presentation">
    <a class="nav-link" id="Mentions-tab" data-toggle="tab" href="#Mentions" role="tab" aria-controls="Mentions" aria-selected="false">My Mentions </a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="Public" role="tabpanel" aria-labelledby="Public-tab">
    
    <table id="table" border='2' class="table table-responsive-md mt-3">
  		<thead>
	    	<tr class="bg-dark text-light">
		      <th scope="col">File_Name</th>
		      <th scope="col">File_Type</th>
		      <th scope="col">File_Size</th>
		      <th scope="col">Data_Created</th>
		      <th scope="col">Author_Name</th>
	    	</tr>
  		</thead>
		  <tbody>
		    <tr style="height: 40px">
		    	<td></td>
		    	<td></td>
		    	<td></td>
		    	<td></td>
		    	<td></td>
		    </tr>
		    <tr style="height: 40px"> 
		    	<td></td>
		    	<td></td>
		    	<td></td>
		    	<td></td>
		    	<td></td>
		    </tr>
		  </tbody>
</table>

  </div>
  <div class="tab-pane fade" id="Mentions" role="tabpanel" aria-labelledby="Mentions-tab">
      <table id="table2" border='2' class="table table-responsive-md mt-3">
  		<thead>
	    	<tr class="bg-dark text-light">
		      <th scope="col">File_Name</th>
		      <th scope="col">File_Type</th>
		      <th scope="col">File_Size</th>
		      <th scope="col">Data_Created</th>
		      <th scope="col">Author_Name</th>
	    	</tr>
  		</thead>
		  <tbody>
		    <tr style="height: 40px">
		    	<td></td>
		    	<td></td>
		    	<td></td>
		    	<td></td>
		    	<td></td>
		    </tr>
		    <tr style="height: 40px"> 
		    	<td></td>
		    	<td></td>
		    	<td></td>
		    	<td></td>
		    	<td></td>
		    </tr>
		  </tbody>
</table>
  </div>
</div>
<br>
<br>
<br>
<br>
		</div>

	</div>
</div>
<script>
    // Add the following code if you want the name of the file appear on select
    function GetFileSizeNameAndType()
    {
      var fi = document.getElementById('file'); // GET THE FILE INPUT AS VARIABLE.

      var totalFileSize = 0;

      // VALIDATE OR CHECK IF ANY FILE IS SELECTED.
      if (fi.files.length > 0)
      {
      // RUN A LOOP TO CHECK EACH SELECTED FILE.
        for (var i = 0; i <= fi.files.length - 1; i++)
        {
          //ACCESS THE SIZE PROPERTY OF THE ITEM OBJECT IN FILES COLLECTION. IN THIS WAY ALSO GET OTHER PROPERTIES LIKE FILENAME AND FILETYPE
          var fsize = fi.files.item(i).size;
          totalFileSize = totalFileSize + fsize;
          document.getElementById('fp').innerHTML =
          document.getElementById('fp').innerHTML
          +
          '<br /> ' +' <div class="alert alert-success alert-dismissible fade show" role="alert"> <b> File Name is: </b>' + fi.files.item(i).name
          +
          '<br><b>Size is: </b>' + Math.round((fsize / 1024)) + ' KB' //DEFAULT SIZE IS IN BYTES SO WE DIVIDING BY 1024 TO CONVERT IT IN KB
          +
          '<br><b>File Type is: </b>' + fi.files.item(i).type + "</b>."+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
          }
      }
      // document.getElementById('divTotalSize').innerHTML = "Total File(s) Size is <b>" + Math.round((totalFileSize / 1024)) + "</b> KB";
    }
    </script>
    <script>
    // Add the following code if you want the name of the file appear on select
      function GetFileSizeNameAndType2()
      {
        var fi = document.getElementById('file2'); // GET THE FILE INPUT AS VARIABLE.

        var totalFileSize = 0;

        // VALIDATE OR CHECK IF ANY FILE IS SELECTED.
        if (fi.files.length > 0)
        {
          // RUN A LOOP TO CHECK EACH SELECTED FILE.
          for (var i = 0; i <= fi.files.length - 1; i++)
          {
          //ACCESS THE SIZE PROPERTY OF THE ITEM OBJECT IN FILES COLLECTION. IN THIS WAY ALSO GET OTHER PROPERTIES LIKE FILENAME AND FILETYPE
          var fsize = fi.files.item(i).size;
          totalFileSize = totalFileSize + fsize;
          document.getElementById('fp2').innerHTML =
          document.getElementById('fp2').innerHTML
          +
          '<br /> ' +' <div class="alert alert-success alert-dismissible fade show" role="alert"> <b> File Name is: </b>' + fi.files.item(i).name
          +
          '<br><b>Size is: </b>' + Math.round((fsize / 1024)) + ' KB' //DEFAULT SIZE IS IN BYTES SO WE DIVIDING BY 1024 TO CONVERT IT IN KB
          +
          '<br><b>File Type is: </b>' + fi.files.item(i).type + "</b>."+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
          }
        }
        // document.getElementById('divTotalSize').innerHTML = "Total File(s) Size is <b>" + Math.round((totalFileSize / 1024)) + "</b> KB";
      }
    </script>