<?php
	function redirect_to($location){
		header('Location: '.$location);
		exit();
	}

	function getUser($id){
		global $connection;
		$query="SELECT * FROM users WHERE id='{$id}'";
		$result=mysqli_query($connection, $query);
		$arr=[];

		while($row=mysqli_fetch_array($result)){
			$arr=['id'=>$row['id'], 'username'=>$row['username'], 'name'=>$row['name'], 'type'=>$row['type'], 'email'=>$row['email']];
		}
		return $arr;
	}
	
	function for_pagination($name){
		global $connection;

		$query="SELECT * FROM {$name}";
		$result=mysqli_query($connection, $query);
		$count=mysqli_num_rows($result);

		$i=$count/5;
		$i=ceil($i);
		return $i;
	}


	function randomCode(){
	    $alphabet='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	    $code=array();
	    $alphaLength=strlen($alphabet)-1;
	    for($i=0; $i<8; $i++){
	        $n=rand(0, $alphaLength);
	        $code[]=$alphabet[$n];
	    }
	    return implode($code);
	}

	function addCourse($userId, $title, $name, $capacity, $tagId){
		global $connection;
		$code=randomCode();

		$query="SELECT id FROM classes WHERE code='{$code}'";
		$res=mysqli_query($connection, $query);

		if(mysqli_num_rows($res)>0)
			addCourse($userId, $title, $name, $capacity, $tagId);

		else{
			$query1="INSERT INTO classes(userId, title, name, code, capacity, tagId) VALUES('{$userId}', '{$title}', '{$name}', '{$code}', '{$capacity}', '{$tagId}')";
			mysqli_query($connection, $query1);
		}
	}


	function validateName($name){
		$res=NULL;
		if(!preg_match("/^[a-zA-Z. ]*$/", $name))
			$res="Name must only contain <b>letters</b>, <b>dots</b> and <b>whitespace!</b>";
		return $res;
	}

	function validateUsername($username){
		$res=NULL;
		if(!preg_match("/^[0-9a-z]*$/", $username))
			$res="Username must only contain <b>letters</b> and <b>numbers</b>";
		return $res;
	}

	function profileGetParamName($name){
		$result=strtolower($name);
		$result=preg_replace('/[.]/', '', $result);
		$result=preg_replace('/[ ]/', '.', $result);
		return $result;
	}

	function getUserProfile($id){
		global $connection;

		$profile=[];

		$query="SELECT * FROM user_profile WHERE userId='{$id}'";
		$res=mysqli_query($connection, $query);
		while($row=mysqli_fetch_array($res)){
			$profile=['image'=>$row['image'], 'nsuId'=>$row['nsuId'], 'about'=>$row['about']];
		}
		return $profile;
	}
?>
