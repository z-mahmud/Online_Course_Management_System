<?php session_start(); ?>
<?php include('../db/connect.php'); ?>
<?php include('../helpers/function.php'); ?>

<?php
	if(isset($_POST['course-add'])){
		$userId=$_POST['userId'];
		$title=$_POST['title'];
		$name=$_POST['name'];
		$tagId=(int)$_POST['tag'];
		$capacity=$_POST['capacity'];

		addCourse($userId, $title, $name, $capacity, $tagId);
		$_SESSION['courseAddSuccess']="Successfully course added!";
		redirect_to('../users/classes.php');
	}
?>

<!-- ------------------- Delete Class -------------------- -->
<?php
	if(isset($_POST['deleteClass'])){
		$cid=(int)$_POST['classId'];
		$uid=(int)$_POST['facId'];

		$query1="DELETE FROM class_materials WHERE classId='{$cid}'";
		$res1=mysqli_query($connection, $query1);

		$query2="SELECT id FROM enrollments WHERE classId='{$cid}'";
		$res2=mysqli_query($connection, $query2);

		$query3="DELETE FROM enrollments WHERE classId='{$cid}'";
		$res3=mysqli_query($connection, $query3);

		$query4="DELETE FROM classes WHERE id='{$cid}'";
		$res4=mysqli_query($connection, $query4);

		redirect_to('../users/classes.php');
	}
?>

<?php include('../db/close.php'); ?>
