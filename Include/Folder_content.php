<div align="left" class="col-md-6">
	<table>
		<tbody>
			<tr>
				<td style="padding: 5px;border:2px solid;text-align: center;">File Owner</td>
				<td>&nbsp;&nbsp;&nbsp;</td>
				<td>&nbsp;<u><b> User 1</b></u></td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td style="padding: 5px;border:2px solid;text-align: center;">Date Created</td>
				<td>&nbsp;&nbsp;&nbsp;</td>
				<td>2021/5/9</td>
			</tr>
		</tbody>
	</table>
</div>
<div align="right" class="col-md-6">
	<table>
		<tbody>
			<tr>
				<td><button class="btn btn-dark btn-sm" style="padding-right: 40px;padding-left: 40px" data-toggle="modal" data-target="#File">Add File</button></td>
				<td>&nbsp;&nbsp;&nbsp;</td>
				<td><button class="btn btn-dark btn-sm" style="padding-right: 40px;padding-left: 40px" data-toggle="modal" data-target="#Folder">Add Folder</button></td>
			</tr>
		</tbody>
	</table>
</div>
</div>
<div class="row mb-5">
	<div class="col-md-12">
		    <table id="table" border='2' class="table table-hover table-responsive-md mt-3">
  <thead>
    <tr>
      <th scope="col">FileNameAndlicon</th>
      <th scope="col">Type</th>
      <th scope="col">Size</th>
      <th scope="col">DataCreated</th>
      <th scope="col">Owner</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>1.pdf</td>
      <td>Pdf</td>
      <td>1kb</td>
      <td>12/8/2012</td>
      <td>Ahmed</td>
    </tr>
    <tr>
      <td>Security.docx</td>
      <td>Word</td>
      <td>16kb</td>
      <td>24/9/2020</td>
      <td>Yousef</td>
    </tr>
    <tr>
      <td>1.pdf</td>
      <td>Pdf</td>
      <td>1kb</td>
      <td>12/8/2012</td>
      <td>Ahmed</td>
    </tr>
    <tr>
      <td>1.pdf</td>
      <td>Pdf</td>
      <td>1kb</td>
      <td>12/8/2012</td>
      <td>Ahmed</td>
    </tr>
    <tr>
      <td>Security.docx</td>
      <td>Word</td>
      <td>16kb</td>
      <td>24/9/2020</td>
      <td>Yousef</td>
    </tr>
    <tr>
      <td>1.pdf</td>
      <td>Pdf</td>
      <td>1kb</td>
      <td>12/8/2012</td>
      <td>Ahmed</td>
    </tr>
    <tr>
      <td>1.pdf</td>
      <td>Pdf</td>
      <td>1kb</td>
      <td>12/8/2012</td>
      <td>Ahmed</td>
    </tr>
    <tr>
      <td>Security.docx</td>
      <td>Word</td>
      <td>16kb</td>
      <td>24/9/2020</td>
      <td>Yousef</td>
    </tr>
    <tr>
      <td>1.pdf</td>
      <td>Pdf</td>
      <td>1kb</td>
      <td>12/8/2012</td>
      <td>Ahmed</td>
    </tr>
    <tr>
      <td>1.pdf</td>
      <td>Pdf</td>
      <td>1kb</td>
      <td>12/8/2012</td>
      <td>Ahmed</td>
    </tr>
    <tr>
      <td>Security.docx</td>
      <td>Word</td>
      <td>16kb</td>
      <td>24/9/2020</td>
      <td>Yousef</td>
    </tr>
    <tr>
      <td>1.pdf</td>
      <td>Pdf</td>
      <td>1kb</td>
      <td>12/8/2012</td>
      <td>Ahmed</td>
    </tr>
  </tbody>
</table>
	</div>
 <!-- Modal Create new File -->
          <div class="modal fade" id="File" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
          <!--End Modal File -->
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
              <div align="center" class="modal-body mb-5">
                 <form>
                      <p>
                          <input class="form-group w-100 mt-3" type="text" placeholder="Folder Name" required/>
                      </p>

                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                  <input type="submit" class="btn btn-warning" value="Confirm">
                </div>
                </form>
            </div>
          </div>
        </div>
        <!--End ModalCreate new Folder -->