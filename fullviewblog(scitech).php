<?php 
session_start();
$_SESSION['url'] = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
include('includes/config.php');
include('includes/function.php');
$stmt = $db->prepare('SELECT * FROM editorialscitech WHERE ediSlug = :ediSlug');
$stmt->execute(array(':ediSlug' => $_GET['id']));
$row = $stmt->fetch();
$cnt = $row['count'] + 1;
$ediID = $row['ediID'];
$stmt2 = $db->prepare('UPDATE editorialscitech SET count = '.$cnt.',postdate = NOW() WHERE ediID = '.$ediID.'');
$stmt2->execute();
//if post does not exists redirect user.
if($row['ediID'] == ''){
	header('Location: ./');
	exit;
}
 ?>
<!DOCTYPE html>
<html>
   <head>
      <title> <?php echo $row['ediTitle'];?> | TECHSCIPEDIA</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name='keywords' content='<?php echo $row['ediTitle'];?>'>
		<meta name='description' content='<?php echo $row['ediCont']; ?>'>
		<meta name='language' content='en'>
      <meta name="robots" content="noindex, nofollow">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script scr="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/jquery.simplePagination.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
   </head>
   <style type="text/css">
     .blog-list{
    background-color: #fff;
    padding: 20px;
    border-radius: 4px;
    margin-bottom: 20px;
}
.blog-list p {
    color: rgba(0, 0, 0, 0.7);
    font-family: 'Roboto Slab', serif;
    font-size: 20px;
    padding-top: 5px;
    padding-bottom: 0px;
  }

  form button { margin: 5px 0px; }
textarea { display: block; margin-bottom: 10px; }
/*post*/
.post { border: 1px solid #ccc; margin-top: 10px; }
/*comments*/
.comments-section { margin-top: 10px; border: 1px solid #ccc;background-color: #fff;padding: 10px; }
.comment { margin-bottom: 10px; }
.comment .comment-name { font-weight: bold; }
.comment .comment-date {
  font-style: italic;
  font-size: 0.8em;
}
.comment .reply-btn, .edit-btn { font-size: 0.8em; }
.comment-details { width: 91.5%; float: left; }
.comment-details p { margin-bottom: 0px; }
.comment .profile_pic {
  width: 35px;
  height: 35px;
  margin-right: 5px;
  float: left;
  border-radius: 50%;
}
/*replies*/
.reply { margin-left: 30px; }
.reply_form {
  margin-left: 40px;
  display: none;
}
#comment_form { margin-top: 10px; }

.demo-table .highlight, .demo-table .selected {color:#F4B30A;text-shadow: 0 0 1px #F48F0A;}
.btn-likes {float:left; padding: 0px 5px;cursor:pointer;}
.btn-likes input[type="button"]{width:20px;height:20px;border:0;cursor:pointer;}
.like {background:url('image/like.png')}
.unlike {background:url('image/unlike.png')}
.label-likes {font-size:12px;color:#2F529B;height:20px;}
   </style>
   <body style="background-color: #d2dadf;">
      <div class="container">
         <?php include('includes/header.php');?>
         <div style="margin-top: 10px;">

            <div class="row">

                    <div class="col-md-8">
                        <div class="container" style="margin-top: 20px;border: 1px solid #ccc;background-color: #fff;">
                    
                  <?php	
                  echo '<div class="blog-list">';
                 echo '<h3 style="padding-bottom: 10px;"><a href="fullviewblog(scitech).php?title='.$row['ediSlug'].'" style="color:#3a9cdd;text-decoration: none;">'.$row['ediTitle'].'</a></h3>'; 

                            echo '<ul class="list-inline list-unstyled">';
                              echo '<li class="list-inline-item"><span>by </span><b style="color: #6260d0;">'.$row['ediAuthor'].'</b><span>,</span></li>';
                              // posted #days ago
                              $tim = abs(time() - strtotime($row['ediDate']));
                              $tim = ceil($tim/(60*60*24));
                              if($tim<365){
                              if($tim==1){
                              echo '<li class="list-inline-item"><b style="color:#4846bf;">'.$tim.' </b><span>day ago </span></li>';
                              }
                              else{
                                echo '<li class="list-inline-item"><b style="color:#4846bf;">'.$tim.'</b> <span>days ago </span></li>';
                              }
                              }
                              else{
                                $tim = $tim/365;
                                if($tim==1){
                                echo '<li class="list-inline-item"><b style="color:#4846bf;">'.$tim.'</b> <span>year ago </span></li>';
                              }
                              else{
                                echo '<li class="list-inline-item"><b style="color:#4846bf;">'.$tim.'</b> <span>years ago </span></li>';
                              }
                              }

                $stmt2 = $db->prepare('SELECT topTitle, topSlug FROM tagsscitech, editagsscitech WHERE tagsscitech.topID = editagsscitech.topID AND editagsscitech.ediID = :ediID');
                $stmt2->execute(array(':ediID' => $row['ediID']));

                $topRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                $links = array();
                foreach ($topRow as $top)
                {
                    $links[] = "".$top['topTitle']."";
                }

                 //echo '<i class="fa fa-folder-open"></i><span style="color:#2e879a;"> Tag: '.implode(", ", $links).'</span>';

                           echo '</ul>';
                        echo '<p>'.$row['ediDesc'].
                        $row['ediCont'].'</p>';
                  echo '</div>';
               ?>

                </div>

       <div class="comments-section" id="jumptocomments">
      <!-- if user is not signed in, tell them to sign in. If signed in, present them with comment form -->
      <?php if($user_id){ ?>
        <form action="fullviewblog(scitech).php?id=<?php echo $row['ediSlug']; ?>" method="post" id="comment_form">
          <textarea name="comment_text" placeholder="Write a comment..." id="comment_text" class="form-control" cols="30" rows="2"></textarea>
          <button type="button" class="btn btn-primary btn-sm pull-right" id="submit_comment">comment</button>
        </form>
      <?php } else { ?>
        <div class="well" style="margin-top: 20px;">
          <h4 class="text-center"><a href="sign-in(user).php">Sign in</a> to post a comment</h4>
        </div>
      <?php } ?>
      <!-- Display total number of comments on this post  -->
      <h4><span id="comments_count"><?php echo count($comments) ?></span> Comment(s)</h4>
      <hr>
      <!-- comments wrapper -->
      <div id="comments-wrapper">
      <?php if ($comments){ ?>
        <!-- Display comments -->
        <?php foreach ($comments as $comment){ ?>
        <!-- comment -->
        <div class="comment clearfix">
          <?php 
          $sql = $db->prepare(" SELECT * FROM user WHERE id = :id ");
          $sql->execute(array(':id' => $comment['user_id']));
          $row = $sql->fetch();
          if(!$row['picture']){
                            echo "<a href='profile(user).php?user=".$row['Username']." '><img src='image/default-avatar.jpg' width='200px' height='200px' style='border-radius: 50%;' alt='img' class='profile_pic'/></a>";
                           }
                           else{
                            ?>
                            <a href="profile(user).php?user='.$row['Username'].' ">
                            <img src='<?php echo 'image/'.$row['picture'];?>' width='200px' height='200px' style='border-radius: 50%;' alt='img' class='profile_pic'/>
                          </a>
                            <?php
                        }
          ?>
          <div class="comment-details">
            <a href="profile(user).php?user='.$row['Username'].' " style="text-decoration: none;">
            <span class="comment-name"><?php echo getUsernameById($comment['user_id']) ?></span></a>
            <span class="comment-date"><?php echo date("F j, Y ", strtotime($comment["created_at"])); ?></span>
            <p><?php echo $comment['body']; ?></p>
            <table class="demo-table">
              <tr>
            <span id="comment-<?php echo $comment["id"]; ?>">
            <?php
            $sql = $db->prepare("SELECT * FROM user WHERE Username = :Username ");
            $sql->execute(array(':Username'=>$user_id));
            $row = $sql->fetch();
            $f = 1;
            $sql = $db->prepare("SELECT * FROM likes WHERE comment_id=".$comment['id']." AND user_id=".$row['id']." AND vote=".$f." ");
            $sql->execute();
            $result = $sql->fetch();
            $str_like = "like";
            if($user_id){
            if($result){
            $str_like = "unlike";
            }
            ?>
            <input type="hidden" id="likes-<?php echo $comment["id"]; ?>" value="<?php echo $comment["likes"]; ?>">
            <div class="btn-likes"><input type="button" title="<?php echo ucwords($str_like); ?>" class="<?php echo $str_like; ?>" onClick="addLikes(<?php echo $comment['id']; ?>,'<?php echo $str_like; ?>')" /></div>
         
            <div class="label-likes"><?php if(!empty($comment['likes'])) { echo $comment['likes'] . " Like(s)"; } ?></div>
              
          <?php } ?>
           </span>
      </tr>
      <a class="reply-btn" href="#" data-id="<?php echo $comment['id']; ?>">reply</a>
      </table>
          </div>

          <!-- GET ALL REPLIES -->
          <?php $replies = getRepliesByCommentId($comment['id']) ?>
          <div class="replies_wrapper_<?php echo $comment['id']; ?>">
            <?php if (isset($replies)){ ?>
              <?php foreach ($replies as $reply){ ?>
                <!-- reply -->
                <div class="comment reply clearfix">
                  <?php 
                   $sql = $db->prepare(" SELECT * FROM user WHERE id = :id ");
                   $sql->execute(array(':id' => $comment['user_id']));
                   $row = $sql->fetch();
                    if(!$row['picture']){
                            echo "<a href='profile(user).php?user=".$row['Username']." '><img src='image/default-avatar.jpg' width='200px' height='200px' style='border-radius: 50%;' alt='img' class='profile_pic'/></a>";
                           }
                           else{
                            ?>
                            <a href="profile(user).php?user='.$row['Username'].' ">
                            <img src='<?php echo 'image/'.$row['picture'];?>' width='200px' height='200px' style='border-radius: 50%;' alt='img' class='profile_pic'/>
                          </a>
                            <?php
                        }
                 ?>
                  <div class="comment-details">
                    <a href="profile(user).php?user='.$row['Username'].' " style="text-decoration: none;">
                    <span class="comment-name"><?php echo getUsernameById($reply['user_id']) ?></span></a>
                    <span class="comment-date"><?php echo date("F j, Y ", strtotime($reply["created_at"])); ?></span>
                    <p><?php echo $reply['body']; ?></p>
                    <a class="reply-btn" href="#" data-id="<?php echo $comment['id']; ?>">reply</a>
                  </div>
                </div>
              <?php } ?>
            <?php } ?>
          </div>
          <!-- reply form -->
          <form action="" class="reply_form clearfix" id="comment_reply_form_<?php echo $comment['id'] ?>" data-id="<?php echo $comment['id']; ?>">
            <textarea class="form-control" name="reply_text" id="reply_text" cols="30" rows="2"></textarea>
            <button class="btn btn-primary btn-sm pull-right submit-reply">reply</button>
          </form>
        </div>
          <!-- // comment -->
        <?php } ?>
      <?php } else { ?>
        <h4>Be the first to comment on this blog</h4>
      <?php } ?>
      </div><!-- comments wrapper -->
    </div><!-- // all comments -->

              </div>
                
               <div class="col-md-4">
                    <?php include('includes/sidebar(scitech).php'); ?>
               </div>
            </div>
         </div>  
      <?php include ('includes/footer.php'); ?>
    </div>
   </body>


   <script type="text/javascript">
     $(document).ready(function(){
  // When user clicks on submit comment to add comment under post
  $(document).on('click','#submit_comment',function(e) {
    e.preventDefault();
    var comment_text = $('#comment_text').val();
    var url = $('#comment_form').attr('action');
    // Stop executing if not value is entered
    if(comment_text === "") return;
    $.ajax({
      type: 'POST',
      url: url,
      data: {
        comment_text: comment_text,
        comment_posted: 1
      },
      success: function(data){
        var response = JSON.parse(data);
        if (data === "error") {
          alert('There was an error adding comment. Please try again');
        } else {
          $('#comments-wrapper').prepend(response.comment)
          $('#comments_count').text(response.comments_count); 
          $('#comment_text').val('');
        }
      }
    });
  });
  // When user clicks on submit reply to add reply under comment
  $(document).on('click', '.reply-btn', function(e){
    e.preventDefault();
    // Get the comment id from the reply button's data-id attribute
    var comment_id = $(this).data('id');
    // show/hide the appropriate reply form (from the reply-btn (this), go to the parent element (comment-details)
    // and then its siblings which is a form element with id comment_reply_form_ + comment_id)
    $(this).parent().siblings('form#comment_reply_form_' + comment_id).toggle(500);
    $(document).on('click', '.submit-reply', function(e){
      e.preventDefault();
      // elements
      var reply_textarea = $(this).siblings('textarea'); // reply textarea element
      var reply_text = $(this).siblings('textarea').val();
      var url = $(this).parent().attr('action');
      if(reply_text==="")return;
      $.ajax({
        type: 'POST',
        url: url,
        data: {
          comment_id: comment_id,
          reply_text: reply_text,
          reply_posted: 1
        },
        success: function(data){
          if (data === "error") {
            alert('There was an error adding reply. Please try again');
          } else {
            $('.replies_wrapper_' + comment_id).append(data);
            reply_textarea.val('');
          }
        }
      });
    });
  });
});

  function addLikes(id,action) {
  $('.demo-table #comment-'+id+' li').each(function(index) {
    $(this).addClass('selected');
    $('#comment-'+id+' #rating').val((index+1));
    if(index == $('.demo-table #comment-'+id+' li').index(obj)) {
      return false; 
    }
  });
  $.ajax({
  url: "add_likes.php",
  data:'id='+id+'&action='+action,
  type: "POST",
  beforeSend: function(){
    $('#comment-'+id+' .btn-likes').html("<img src='image/LoaderIcon.gif' />");
  },
  success: function(data){
  var likes = parseInt($('#likes-'+id).val());
  switch(action) {
    case "like":
    $('#comment-'+id+' .btn-likes').html('<input type="button" title="Unlike" class="unlike" onClick="addLikes('+id+',\'unlike\')" />');
    likes = likes+1;
    break;
    case "unlike":
    $('#comment-'+id+' .btn-likes').html('<input type="button" title="Like" class="like"  onClick="addLikes('+id+',\'like\')" />')
    likes = likes-1;
    break;
  }
  $('#likes-'+id).val(likes);
  if(likes>0) {
    $('#comment-'+id+' .label-likes').html(likes+" Like(s)");
  } else {
    $('#comment-'+id+' .label-likes').html('');
  }
  }
  });
}
   </script>

   <script src="Jboot/jquery/jquery.min.js"></script>
    <script src="Jboot/tether/tether.min.js"></script>
    <script src="Jboot/bootstrap/js/bootstrap.min.js"></script>
</html>