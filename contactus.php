<?php
$message="";
//if($_SESSION['username']){ header('Location: index.php'); }
if(isset($_POST['submit']))
{
$email=$_POST['email'];
$Message=($_POST['Message']);
$stmt=$db->prepare("INSERT INTO contactus(email,message) VALUES(:email,:Message)");
$stmt->execute(array(':email' => $email,':Message' => $Message));
$lastInsertId = $db->lastInsertId();
if($lastInsertId)$message="Sent successfully!";
else $message="Something went wrong!Try again.";
}

?>

<head>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css"/>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
</head>
<style type="text/css">
.contact-form{ margin-top:15px;}
.contact-form .textarea{ min-height:120px; resize:none;}
.form-control{ box-shadow:none; border-color:#eee; height:40px;}
.form-control:focus{ box-shadow:none; border-color:#00b09c;}
.form-control-feedback{ line-height:50px;}
.main-btn{ background:#00b09c; border-color:#00b09c; color:#fff;}
.main-btn:hover{ background:#00a491;color:#fff;}
.form-control-feedback {
line-height: 50px;
top: 0px;
}
</style>

<div class="container">
  <div class="container col-md-6 col-xs-6" style="margin-top: 20px;">
    <form role="form" action="" method="post" id="contact-form" class="contact-form" style="border:1px solid #ccc;background-color: #fff;">
      <div class="message" align="center"><?php if($message!="") { echo $message; } ?></div>
      <div class="container">
        <p style="font-weight: bold;color: #074861;font-size: 23px;">Contact with TechSci Room</p>
        <hr>
                    <div class="row">
                      <div class="col-md-12 col-xs-12">
                      <div class="form-group">
                            <input type="email" class="form-control" name="email" autocomplete="off" id="email" placeholder="E-mail">
                      </div>
                    </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 col-xs-12">
                      <div class="form-group">
                            <textarea class="form-control textarea" rows="3" name="Message" id="Message" placeholder="Message"></textarea>
                      </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12 col-xs-12">
                  <button type="submit" name="submit" class="btn main-btn">Send a message</button>
                  </div>
                  </div>
                </div>
                </form>
              </div>
</div>

<script type="text/javascript">
  $('#contact-form').bootstrapValidator({
//        live: 'disabled',
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            Name: {
                validators: {
                    notEmpty: {
                        message: 'The Name is required and cannot be empty'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required'
                    },
                    emailAddress: {
                        message: 'The email address is not valid'
                    }
                }
            },
            Message: {
                validators: {
                    notEmpty: {
                        message: 'The Message is required and cannot be empty'
                    },
                    stringLength: {
                        min: 10,
                        message:'Please enter at least 10 characters'
                    }
                }
            }
        }
    });
</script>