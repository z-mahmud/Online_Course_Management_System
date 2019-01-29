<?php session_start(); ?>
<?php include('../db/connect.php'); ?>
<?php include('../helpers/function.php'); ?>

<?php
	if(isset($_POST['edit-profile'])){
		$name=htmlentities($_POST['name']);
		$nsuId=htmlentities($_POST['nsuId']);
		$nsuId=(int)$nsuId;
		$about=mysqli_real_escape_string($connection, $_POST['about']);
		$userId=(int)$_POST['userId'];
		$user=$_POST['user'];

		$username=getUser($userId)['username'];

		$image=$_FILES['image']['name'];
		$tmp_image=$_FILES['image']['tmp_name'];
		$extension=pathinfo($image, PATHINFO_EXTENSION);

		if(validateName($name)!=NULL){
			$_SESSION['editFailed']=validateName($name);
			redirect_to('../users/userprofile.php?userid='.$userId.'&user='.$user);
		}

		if($image!=NULL){
			if($extension!='jpg' && $extension!='jpeg' && $extension!='png'){
				$_SESSION['editFailed']='Image should be in <b>jpg</b>, <b>jpeg</b> or <b>png</b> format!';
				redirect_to('../users/userprofile.php?userid='.$userId.'&user='.$user);
			}else{
				$image=$username.'.'.$extension;
				move_uploaded_file($tmp_image, '../users/images/'.$image);
			}
		}else{
			$query3="SELECT image FROM user_profile WHERE userId='{$userId}'";
			$res3=mysqli_query($connection, $query3);

			if(mysqli_num_rows($res3)>0){
				while($row=mysqli_fetch_array($res3)){
					$image=$row['image'];
				}
			}
			else
				$image='empty';
		}

		$query="UPDATE users SET name='{$name}' WHERE id='{$userId}'";
		mysqli_query($connection, $query);

		$query1="SELECT id FROM user_profile WHERE userId='{$userId}'";
		$res1=mysqli_query($connection, $query1);

		if(mysqli_num_rows($res1)>0){
			$query2="UPDATE user_profile SET image='{$image}', nsuId='{$nsuId}', about='{$about}' WHERE userId='{$userId}'";
			mysqli_query($connection, $query2);
		}else{
			$query2="INSERT INTO user_profile(userId, image, nsuId, about) VALUES('{$userId}', '{$image}', '{$nsuId}', '{$about}')";
			mysqli_query($connection, $query2);
		}

		$_SESSION['editSuccess']='Profile updated!';
		redirect_to('../users/userprofile.php?userid='.$userId.'&user='.$user);
	}
?>

<?php include('../db/close.php'); ?>