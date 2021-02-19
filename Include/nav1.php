
<div>
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <!-- Button Create new section modal -->
          <button type="button" class="btn " data-toggle="modal" data-target="#section">
          <i class="fas fa-file-medical"></i> Add new File
          </button> 
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
        </li>

          <li class="nav-item" role="presentation">
          <!--   Button Create new Folder modal -->
        <button type="button" class="btn " data-toggle="modal" data-target="#Folder">
          <i class="fas fa-folder-plus"></i> Add new Folder
        </button> 
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
        </ul>
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