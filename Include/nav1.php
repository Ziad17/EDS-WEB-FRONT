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

<!--           <li class="nav-item" role="presentation">
            <div class="dropdown">
              <button class="btn  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-chevron-circle-down"></i> Dropdown button
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
              </div>
            </div> 
          </li> -->
        </ul>
      </div>