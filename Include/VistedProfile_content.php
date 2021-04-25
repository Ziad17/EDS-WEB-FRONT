<?php


require_once VALIDATION_BASE_PATH."/PersonValidator.php";
require_once BUSINESS_BASE_PATH."/Person.php";
require_once SESSIONS_BASE_PATH."/SessionManager.php";
require_once DATABASE_BASE_PATH."/PersonAction.php";


//TODO:: CHECK if this already my email


try {
    $email=EncryptionManager::Decrypt($_GET['user']);


    $personRef = Person::Builder()->setID(SessionManager::getID())->setEmail(SessionManager::getEmail())->build();

    $Action = new PersonAction($personRef);


    //fill Info
    $detailedPersonRef=$Action->getPersonPublicInfo($email);



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
			<img style="border-radius: 50%;padding: 5px" src=<?php  if(isset($detailedPersonRef))
            {

                echo htmlspecialchars($detailedPersonRef->getImgRef());
            }?> width="100px" height="100px" class="card-img-top" alt="...">
			<div class="card-body">
				<h5 class="card-title"><?php  if(isset($detailedPersonRef))
                    {

                        echo htmlspecialchars(trim($detailedPersonRef->getFirstName()." ".$detailedPersonRef->getMiddleName()." ".$detailedPersonRef->getLastName()));
                    }?></h5>
				
					<p class="card-text"> <?php  if(isset($detailedPersonRef))
                        {
                            $roles= $detailedPersonRef->getRoles();
                            echo htmlspecialchars($roles[0]->getJobDesc());
                        }?></p>
					<p class="card-text"> <?php  if(isset($detailedPersonRef))
                        {
                            $roles= $detailedPersonRef->getRoles();
                            echo htmlspecialchars($roles[0]->getInstitutionName());
                        }?></p>
				</pre>
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
			   	<button class="btn my-2 my-sm-0" type="submit"><i style="font-size: 30px" class="fas fa-lock"></i></button>
			   	<button class="btn my-2 my-sm-0" type="submit"><i style="font-size: 30px" class="fab fa-telegram-plane"></i></button>
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
    <a class="nav-link" id="Inolved-tab" data-toggle="tab" href="#Inolved" role="tab" aria-controls="Inolved" aria-selected="false">Inolved With</a>
  </li>

    <li class="nav-item" role="presentation">
    <a class="nav-link" id="Related-tab" data-toggle="tab" href="#Related" role="tab" aria-controls="Related" aria-selected="false">Related With You</a>
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
  <div class="tab-pane fade" id="Inolved" role="tabpanel" aria-labelledby="Inolved-tab">
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
  <div class="tab-pane fade " id="Related" role="tabpanel" aria-labelledby="Related-tab">
  	    <table id="table3" border='2' class="table table-responsive-md mt-3">
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