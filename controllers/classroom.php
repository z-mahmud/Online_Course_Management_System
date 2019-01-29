<?php session_start(); ?>
<?php include('../db/connect.php'); ?>
<?php include('../helpers/function.php'); ?>


<!-- ---------------------------------- Course material upload --------------------------------- -->
<?php
	if(isset($_POST['upload-material'])){
		$classId=(int)$_POST['classId'];
		$fileName=$_FILES['file']['name'];
		$tmpFile=$_FILES['file']['tmp_name'];
       $extension='.'.pathinfo($fileName, PATHINFO_EXTENSION);
		$file=explode($extension, $fileName)[0];

		$file=preg_replace('/[ ]+/', '_', $file);
		$file=preg_replace('/[-]+/', '_', $file);
		$file=preg_replace('/[^A-Za-z0-9_\-]/', '', $file);
		$file=preg_replace('/[_]+/', '_', $file);

		$file='class'.$classId.'-'.$file.$extension;
		$text=mysqli_real_escape_string($connection, $_POST['text']);

		$check="SELECT id FROM class_materials WHERE file='{$file}'";
		$resC=mysqli_query($connection, $check);

		if(mysqli_num_rows($resC)>0){
			$_SESSION['materialExists']='It seems file <b>'.$file.'</b> already uploaded! You can do following to solve it:
					<ul>
						<li>Rename file which you want to upload.</li>
						<li>Delete file which is already uploaded.</li>
					</ul>';
		}else{
			move_uploaded_file($tmpFile, '../users/files/'.$file);

			$query="INSERT INTO class_materials(classId, text, file) VALUES('{$classId}', '{$text}', '{$file}')";
			$res=mysqli_query($connection, $query);

			if($res)
				$_SESSION['materialSuccess']="File successfully upload!";
			else
				$_SESSION['materialError']="File upload error! try again.";
		}
		redirect_to('../users/classroom.php?class_id='.$classId);
	}
?><!-- ------------------------- Course material delete --------------------------- -->
<?php
	if(isset($_POST['delete-material'])){
		$id=(int)$_POST['id'];
		$classId=(int)$_POST['classId'];
		$file=$_POST['file'];

		$query="DELETE FROM class_materials WHERE id='{$id}'";

mysqli_query($connection, $query);
		unlink('../users/files/'.$file);
		$_SESSION['materialDeleteSuccess']='File deleted!';
		redirect_to('../users/classroom.php?class_id='.$classId);
	}
?>


<!-- ---------------------------- Download course material ---------------------------- -->
<?php
	if(isset($_POST['download-material'])){
		$file=$_POST['file'];

		if(file_exists($file)){
			header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
		}
	}
?>



<?php include('../db/close.php'); ?>