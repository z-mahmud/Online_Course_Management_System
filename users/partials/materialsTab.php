<div role="tabpanel" class="tab-pane" id="materials">
	<br>
	<?php
		if($type=='faculty'){
	?>
	<div class="row">
	<div class="col-md-12 materials">
		<!-- ------------------------- Flash message ------------------------- -->
		<?php if(isset($_SESSION['materialSuccess'])){ ?>
		<div class="alert alert-success"><?php echo $_SESSION['materialSuccess']; ?></div>
		<script>
			$('#homeTl, #home').removeClass('active');
			$('#materialsTl, #materials').addClass('active');
		</script>
		<?php unset($_SESSION['materialSuccess']);} ?>

		<?php if(isset($_SESSION['materialDeleteSuccess'])){ ?>
		<div class="alert alert-success"><?php echo $_SESSION['materialDeleteSuccess']; ?></div>
         
		<script>
			$('#homeTl, #home').removeClass('active');
			$('#materialsTl, #materials').addClass('active');
		</script>
		
		<?php unset($_SESSION['materialDeleteSuccess']);} ?>
		
		<?php if(isset($_SESSION['materialError'])){ ?>
		<div class="alert alert-danger"><?php echo $_SESSION['materialError']; ?></div>
		<script>
			$('#homeTl, #home').removeClass('active');
			$('#materialsTl, #materials').addClass('active');
		</script>
		<?php unset($_SESSION['materialError']);} ?>

		
		<?php if(isset($_SESSION['materialExists'])){ ?>
		<div class="alert alert-danger"><?php echo $_SESSION['materialExists']; ?></div>
		<script>
			$('#homeTl, #home').removeClass('active');
			$('#materialsTl, #materials').addClass('active');
		</script>
		<?php unset($_SESSION['materialExists']);} ?>


		
		<button type="button" class="btn btn-success materialsModal" data-toggle="modal" data-target="#materialsModal">
			Upload course material
		</button>

		<div class="modal" id="materialsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
          
        <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Upload course material</h4>
				
				
				</div>
		      <div class="modal-body">
		      	<input type="hidden" name="classId" value="<?php echo $classId; ?>">
		      	<label for="file">Select file:</label>
		      	<input type="file" name="file" id="file" required>
		      	<br>
		      	<label for="text">Description:</label>
		      	<textarea name="text" id="text" class="form-control" cols="30" rows="4" required style="resize: vertical"></textarea>
		      </div>
			  
			  
			  <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary" name="upload-material">Upload</button>
		      </div>
		      </form>
		    </div>
		  </div>
		</div>
	</div>
	</div>
	<hr>
	<?php } ?>


	
	
	<div class="row">
		<div class="col-md-12">

	<?php
	
	$query= "SELECT class_materials.*, classes.userId FROM class_materials INNER JOIN classes ON class_materials.classId=classes.id AND class_materials.classId='{$classId}' ORDER BY class_materials.id DESC";
	$res=mysqli_query($connection, $query);

				while($row=mysqli_fetch_array($res)){
?>

      <div class="panel panel-default">
				<div class="panel-body"><?php echo nl2br($row['text']); ?></div>
				
				<div class="panel-footer">
					<div class="row">
						<div class="col-md-9">
							<b style="color: gray">File:</b> <span style="font-size: 12px"><?php echo $row['file']; ?></span>
						</div>

                  <div class="col-md-3 text-right">
							<?php if($row['userId']==$studentId){ ?>
							<form action="../controllers/classroom.php" method="POST" style="display: inline">
                             <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
								<input type="hidden" name="classId" value="<?php echo $classId; ?>">
								<input type="hidden" name="file" value="<?php echo $row['file']; ?>">
								<button type="submit" name="delete-material" class="btn btn-warning btn-xs" onclick="return confirm('You are going to delete a material! Are you sure?')">Delete</button>
							</form>
                           <?php } ?>
							<form action="../controllers/classroom.php" method="POST" style="display: inline">

				<?php
									$dlFile='../users/files/'.$row['file'];
								?>
								<input type="hidden" name="file" value="<?php echo $dlFile; ?>">
								<button type="submit" name="download-material" class="btn btn-danger btn-xs">Download</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>			
							