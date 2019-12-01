<?php
     $user_id = $_SESSION['login'];
     $slug = $_GET['id'];

	// get post with id 1 from database
	$post_query_result = $db->prepare("SELECT * FROM editorialscitech WHERE ediSlug = :ediSlug ");
	$post_query_result->execute(array(':ediSlug' => $slug));
	$post = $post_query_result->fetch();

	// Get all comments from database
	$comments_query_result = $db->prepare("SELECT * FROM comments WHERE post_id=".$post['ediID']." ORDER BY created_at DESC");
	$comments_query_result->execute();
	$comments = $comments_query_result->fetchAll();

	// Receives a user id and returns the username
	function getUsernameById($id)
	{
		global $db;
		$result = $db->prepare("SELECT Username FROM user WHERE id=".$id." LIMIT 1");
		$result->execute();
		$row = $result->fetch();
		// return the username
		return $row['Username'];
	}
	// Receives a comment id and returns the username
	function getRepliesByCommentId($id)
	{
		global $db;
		$result = $db->prepare("SELECT * FROM replies WHERE comment_id=".$id." ");
		$result->execute();
		$replies = $result->fetchAll();
		return $replies;
	}
	// Receives a post id and returns the total number of comments on that post
	function getCommentsCountByPostId($post_id)
	{
		global $db;
		$result = $db->prepare("SELECT COUNT(*) AS total FROM comments WHERE post_id = ".$post_id." ");
		$result->execute();
		$row = $result->fetch();
		return $row['total'];
	}

// If the user clicked submit on comment form...
if (isset($_POST['comment_text'])) {
	// grab the comment that was submitted through Ajax call
	$comment_text = $_POST['comment_text'];
	$tim = time();
	// insert comment into database
	$sql = $db->prepare('INSERT INTO comments (post_id, user_id, body, created_at, updated_at) VALUES (:post_id,:user_id,:body,:created_at,:updated_at)');
	$sql->execute(array(
		':post_id' => $post['ediID'],
		':user_id' => $user_id,
		':body' => $comment_text,
		':created_at' => date('Y-m-d H:i:s'),
		':updated_at' => date('Y-m-d H:i:s'),
	));
	$result = $db->lastInsertId();
	// Query same comment from database to send back to be displayed
	$inserted_id = $db->lastInsertId();
	$res = $db->prepare("SELECT * FROM comments WHERE id=".$inserted_id." ");
	$res->execute();
	$inserted_comment = $res->fetch();
	// date('Y-m-d H:i:s')
	// if insert was successful, get that same comment from the database and return it
	if ($result) {
		$comment = "<div class='comment clearfix'>
					<img src='profile.png' alt='' class='profile_pic'>
					<div class='comment-details'>
						<span class='comment-name'>" . getUsernameById($inserted_comment['user_id']) . "</span>
						<span class='comment-date'>" . date('F j, Y ', strtotime($inserted_comment['created_at'])) . "</span>
						<p>" . $inserted_comment['body'] . "</p>
						<a class='reply-btn' href='#' data-id='" . $inserted_comment['id'] . "'>reply</a>
					</div>
					<!-- reply form -->
					<form action='post_details.php' class='reply_form clearfix' id='comment_reply_form_" . $inserted_comment['id'] . "' data-id='" . $inserted_comment['id'] . "'>
						<textarea class='form-control' name='reply_text' id='reply_text' cols='30' rows='2'></textarea>
						<button class='btn btn-primary btn-xs pull-right submit-reply'>Submit reply</button>
					</form>
				</div>";
		$comment_info = array(
			'comment' => $comment,
			'comments_count' => getCommentsCountByPostId($post['ediID'])
		);
		echo json_encode($comment_info);
		exit();
	} else {
		echo "error";
		exit();
	}
}
// If the user clicked submit on reply form...
if (isset($_POST['reply_text'])) {
	// grab the reply that was submitted through Ajax call
	$reply_text = $_POST['reply_text']; 
	$comment_id = $_POST['comment_id']; 
	// insert reply into database
	$sql = $db->prepare('INSERT INTO replies (user_id, comment_id, body, created_at, updated_at) VALUES (:user_id,:comment_id,:body,:created_at,:updated_at)');
	$sql->execute(array(
		':user_id' => $user_id,
		':comment_id' => $comment_id,
		':body' => $reply_text,
		':created_at' => date('Y-m-d H:i:s'),
		':updated_at' => date('Y-m-d H:i:s'),
	));
	$result = $db->lastInsertId();
	$inserted_id = $db->lastInsertId();
	$res = $db->prepare("SELECT * FROM replies WHERE id=".$inserted_id." ");
	$res->execute();
	$inserted_reply = $res->fetch();
	// if insert was successful, get that same reply from the database and return it
	if ($result) {
		$reply = "<div class='comment reply clearfix'>
					<img src='profile.png' alt='' class='profile_pic'>
					<div class='comment-details'>
						<span class='comment-name'>" . getUsernameById($inserted_reply['user_id']) . "</span>
						<span class='comment-date'>" . date('F j, Y ', strtotime($inserted_reply['created_at'])) . "</span>
						<p>" . $inserted_reply['body'] . "</p>
						<a class='reply-btn' href='#'>reply</a>
					</div>
				</div>";
		echo $reply;
		exit();
	} else {
		echo "error";
		exit();
	}
}

?>