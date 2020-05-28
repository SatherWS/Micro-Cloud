
<form action="../controllers/upload.php" method="post" enctype="multipart/form-data">
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Upload a File or Folder</h2>
            <!--<input type="file" name="files" id="files">-->
            
            <input type="radio" name="fileop" id="">
            <label>Upload Single File</label>
            <br><br>
            <input type="radio" name="fileop" id="">
            <label>Upload Entire Folder</label>
            <br><br>
            <input type="file" webkitdirectory="" mozdirectory="" multiple="" name="files[]" id="files">
            <br><br>
            <input type="submit" value="Upload File">
        </div>
    </div>
</form>