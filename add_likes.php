<?php
session_start();
include('includes/config.php');
if(!empty($_POST['id'])){
	switch ($_POST['action']) {
		case 'like':
			$sql = $db->prepare("UPDATE comments SET likes = likes+1 WHERE id = ".$_POST['id']." ");
			$sql->execute();
			$user = $_SESSION['login'];
			$sql = $db->prepare('SELECT * FROM user WHERE Username = :Username ');
			$sql->execute(array(':Username' => $user));
			$row = $sql->fetch();
			$f = 1;
			$comment_id = $_POST['id'];
			$user_id = $row['id'];
			$sql = $db->prepare('INSERT INTO likes (comment_id,user_id,vote,created_at) VALUES(:comment_id,:user_id,:vote,:created_at)');
			$sql->execute(array(':comment_id' => $comment_id,':user_id' => $user_id,':vote' => $f,':created_at' => date('Y-m-d H:i:s')));
			break;
		
		case 'unlike':
			$sql = $db->prepare("UPDATE comments SET likes = likes-1 WHERE id = ".$_POST['id']." ");
			$sql->execute();
			$user = $_SESSION['login'];
			$sql = $db->prepare('SELECT * FROM user WHERE Username = :Username ');
			$sql->execute(array(':Username' => $user));
			$row = $sql->fetch();
			$f = 1;
			$comment_id = $_POST['id'];
			$user_id = $row['id'];
			$sql = $db->prepare("DELETE FROM likes WHERE comment_id =".$comment_id." AND user_id=".$user_id." ");
			$sql->execute();
			break;
	}
}
?>