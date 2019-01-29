<?php session_start(); ?>
<?php include('../db/connect.php'); ?>
<?php include('../partials/s_header.php'); ?>
<?php require_once('../helpers/function.php'); ?>

<?php if(!isset($_SESSION['userid'], $_SESSION['username']))
	redirect_to('../login.php');
?>

<!-- ---------------- Get user for specific id ----------------- -->
<?php
	$student=getUser($_SESSION['userid']);

	$studentId=$student['id'];
	$username=$student['username'];
	$name=$student['name'];
	$type=$student['type'];
	$email=$student['email'];

	$profile=[];

	$query="SELECT * FROM user_profile WHERE userId='{$studentId}'";
	$res=mysqli_query($connection, $query);
	while($row=mysqli_fetch_array($res)){
		$profile=['image'=>$row['image'], 'nsuId'=>$row['nsuId'], 'about'=>$row['about']];
	}
?>


<?php include('../partials/s_nav.php'); ?>

<div class="container">
	<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;Information</div>
					<div class="panel-body">
						<div class="text-center">
						<?php if(!empty($profile) && $profile['image']!='empty'){ ?>
							<img src="images/<?php echo $profile['image']; ?>" alt="" width="200px" height="200px">
						<?php }else{ if($type=='faculty'){ ?>
							<img src="https://lh3.googleusercontent.com/-ps7fYBDY170/AAAAAAAAAAI/AAAAAAAAAB4/O7ry2Z2mruA/photo.jpg" alt="" width="200px" height="200px">
						<?php }else{ ?>
							<img src="https://www.meine-erste-homepage.com/avatars24.png" alt="" width="200px" height="200px">
						<?php }} ?>
						</div>
						
						<br><br>

						<div class="list-group">
							<button type="button" class="list-group-item">Name: <b><?php echo ucwords($name); ?></b></button>
							<?php if(!empty($profile) && $profile['nsuId']!='empty'){ ?>
							<button type="button" class="list-group-item">NSU ID: <b><?php echo $profile['nsuId']; ?></b></button>
							<?php } ?>
							<button type="button" class="list-group-item">Username: <b><?php echo $username; ?></b></button>
							<button type="button" class="list-group-item">Email: <b><?php echo $email; ?></b></button>
							<button type="button" class="list-group-item">Type: <b><?php echo $type; ?></b></button>

							<?php if(!empty($profile) && $profile['about']!=''){ ?>
							<button type="button" class="list-group-item list-group-item-warning">
								<b><?php echo nl2br($profile['about']); ?></b>
							</button>
							<?php } ?>
						</div>
					</div>
					<div class="panel-footer">
						<a href="userprofile.php?userid=<?php echo $studentId; ?>&user=<?php echo profileGetParamName($name); ?>" class="btn btn-default">Edit</a>
					</div>
				</div>
			</div>

		</div>
				
				<nav aria-label="Page navigation">
					<ul class="pagination">
						<?php
							$i=for_pagination('posts');
							$act=$pg+1;
							for($b=1; $b<=$i; $b++){
						?>

				    	<li><a href="homepage.php?items=<?php echo $b; ?>">
				    		<?php echo $b; ?>
				    	</a></li>

				    	<?php } ?>

				  	</ul>
				</nav>

			</div>
		</div>
	</div>
	</div>
</div>

<?php include('../partials/s_footer.php'); ?>
<?php include('../db/close.php'); ?>
