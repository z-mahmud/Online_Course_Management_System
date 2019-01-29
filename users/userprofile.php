<?php session_start(); ?>
<?php include('../db/connect.php'); ?>
<?php include('../partials/s_header.php'); ?>
<?php require_once('../helpers/function.php'); ?>

<?php if(!isset($_SESSION['userid'], $_SESSION['username']))
	redirect_to('../login.php');
?>

<?php if(!isset($_GET['userid'], $_GET['user'])){ redirect_to('homepage.php'); } ?>

<?php
	$student=getUser($_SESSION['userid']);

	$studentId=$student['id'];
	$username=$student['username'];
	$name=$student['name'];
	$type=$student['type'];
	$email=$student['email'];

	$profile=[];

	$query="SELECT * FROM user_profile WHERE userId='{$_GET['userid']}'";
	$res=mysqli_query($connection, $query);
	while($row=mysqli_fetch_array($res)){
		$profile=['image'=>$row['image'], 'nsuId'=>$row['nsuId'], 'about'=>$row['about']];
	}
?>

<?php
	if(isset($_GET['userid'], $_GET['user'])){
		if($_SESSION['userid']==$_GET['userid'])
			$edit=true;
		else
			$edit=false;
	}
?>

<?php include('../partials/s_nav.php'); ?>

<div class="container">
	<div class="col-md-8 col-md-offset-2">


		<?php if($edit){ ?>

		<form action="../controllers/editProfile.php" method="POST" enctype="multipart/form-data">
		<div class="panel panel-default">
			<div class="panel-heading">Edit profile as: <b><?php echo ucwords($name); ?></b></div>
			<div class="panel-body">
				<?php if(isset($_SESSION['editFailed'])){ ?>
				<div class="alert alert-danger"><?php echo $_SESSION['editFailed']; ?></div>
				<?php unset($_SESSION['editFailed']); } ?>

				<?php if(isset($_SESSION['editSuccess'])){ ?>
				<div class="alert alert-success"><?php echo $_SESSION['editSuccess']; ?></div>
				<?php unset($_SESSION['editSuccess']); } ?>

				<div class="row">
					<div class="col-md-5">
						<?php if(!empty($profile) && $profile['image']!='empty'){ ?>
							<img src="images/<?php echo $profile['image']; ?>" alt="" width="100px" height="100px">
						<?php } ?>
						<br>
						<br>
						<label for="image">Add your picture:</label>
						<input type="file" name="image">
					</div>
					<div class="col-md-7">
						<div class="row">
							<input type="hidden" name="userId" value="<?php echo $studentId; ?>">
							<input type="hidden" name="user" value="<?php echo $_GET['user']; ?>">
							<div class="col-md-3"><label for="name">Full name:</label></div>
							<div class="col-md-9">
								<input type="text" name="name" id="name" class="form-control" value="<?php echo $name; ?>" placeholder="Name" required>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-3"><label for="username">Username:</label></div>
							<div class="col-md-9">
								<input type="text" name="username" id="username" class="form-control" value="<?php echo $username; ?>" placeholder="Username" readonly>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-3"><label for="email">Email:</label></div>
							<div class="col-md-9">
								<input type="email" name="email" id="email" class="form-control" value="<?php echo $email; ?>" placeholder="Email" readonly>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-3"><label for="nsuId">NSU ID:</label></div>
							<div class="col-md-9">
								<?php if(!empty($profile) && $profile['nsuId']!=NULL){ ?>
								<input type="text" name="nsuId" id="nsuId" class="form-control" placeholder="NSU ID" value="<?php echo $profile['nsuId']; ?>" required pattern="[0-9]{10}">
								<?php }else{ ?>
								<input type="text" name="nsuId" id="nsuId" class="form-control" placeholder="NSU ID" required pattern="[0-9]{10}">
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="col-md-12"><hr></div>
					<div class="col-md-12">
						<label for="about">About yourself:</label>
						<?php if(!empty($profile) && $profile['about']!=NULL){ ?>
						<textarea name="about" id="about" cols="30" rows="5" class="form-control" placeholder="Write a little bit about yourself" style="resize: vertical"><?php echo $profile['about']; ?></textarea>
						<?php }else{ ?>
						<textarea name="about" id="about" cols="30" rows="5" class="form-control" placeholder="Write a little bit about yourself" style="resize: vertical"></textarea>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="panel-footer text-right">
				<button type="submit" class="btn btn-primary" name="edit-profile">Save</button>
			</div>
		</div>
		</form>

		<?php }else{ ?>

			<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-body">
					<h4 class="text-center"><?php echo ucwords(getUser($_GET['userid'])['name']); ?></h4>
					<hr>
					<div class="col-md-4">
						<?php if(!empty($profile) && $profile['image']!='empty'){ ?>
							<img src="images/<?php echo $profile['image']; ?>" alt="" width="150px" height="150px">
						<?php }else{ if(getUser($_GET['userid'])['type']=='faculty'){ ?>
							<img src="https://lh3.googleusercontent.com/-ps7fYBDY170/AAAAAAAAAAI/AAAAAAAAAB4/O7ry2Z2mruA/photo.jpg" alt="" width="150px" height="150px">
						<?php }else{ ?>
							<img src="https://www.meine-erste-homepage.com/avatars24.png" alt="" width="150px" height="150px">
						<?php }} ?>
					</div>
					<div class="col-md-8">
						<div class="list-group">
							<?php if(!empty($profile) && $profile['nsuId']!='empty'){ ?>
							<button type="button" class="list-group-item">NSU ID: <b><?php echo $profile['nsuId']; ?></b></button>
							<?php } ?>
							<button type="button" class="list-group-item">Username: <b><?php echo getUser($_GET['userid'])['username']; ?></b></button>
							<button type="button" class="list-group-item">Email: <b><?php echo getUser($_GET['userid'])['email']; ?></b></button>
							<button type="button" class="list-group-item">Type: <b><?php echo getUser($_GET['userid'])['type']; ?></b></button>

							<?php if(!empty($profile) && $profile['about']!=''){ ?>
							<button type="button" class="list-group-item list-group-item-warning">
								<b><?php echo nl2br($profile['about']); ?></b>
							</button>
							<?php } ?>
						</div>

					</div>
				</div>
			</div>
			</div>

		<?php } ?>
	</div>
</div>

<?php include('../partials/s_footer.php'); ?>
<?php include('../db/close.php'); ?>
