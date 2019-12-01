var username = document.forms['vform']['username'];
var email = document.forms['vform']['email'];
var password = document.forms['vform']['password'];
var password_confirm = document.forms['vform']['conpass'];
// SELECTING ALL ERROR DISPLAY ELEMENTS
var name_error = document.getElementById('name_error');
var email_error = document.getElementById('email_error');
var password_error = document.getElementById('password_error');
var pass_confirm_error = document.getElementById('pass_confirm_error');
// SETTING ALL EVENT LISTENERS
//username.addEventListener('blur', nameVerify, true);
//email.addEventListener('blur', emailVerify, true);
//// validation function
function Validate() {
  // validate username
  var f1=1,f2=1,f3=1,f4=1;
  var name = username.value;
  var mail = email.value;
  if (username.value == ""){
    f1=0;
    username.style.border = "1px solid red";
    document.getElementById('username_div').style.color = "red";
    name_error.textContent = "Username is required";
    username.focus();
  }
  // validate username
  if ((username.value.length < 3 || username.value.length>20) && f1==1) {
    f1=0;
    username.style.border = "1px solid red";
    document.getElementById('username_div').style.color = "red";
    name_error.textContent = "Username must be between 3 to 20 characters";
    username.focus();
  }
  // validate username
  var letters = /^[0-9a-zA-Z]+$/;
  if (name.match(letters)==0 && f1==1) {
    f1=0;
    username.style.border = "1px solid red";
    document.getElementById('username_div').style.color = "red";
    name_error.textContent = "Characters must be (A-Z) or (a-z) or (0-9)";
    username.focus();
  }
  // validate email
  if (email.value == "") {
    f2=0;
    email.style.border = "1px solid red";
    document.getElementById('email_div').style.color = "red";
    email_error.textContent = "Email is required";
    email.focus();
  }
  var atpos=mail.indexOf("@");
  var dotpos=mail.lastIndexOf(".");
  if((atpos<4 || dotpos<atpos+3)&&f2==1)
  {
    f2=0;
    email.style.border = "1px solid red";
    document.getElementById('email_div').style.color = "red";
    email_error.textContent = "You entered an invalid email!";
    email.focus();
  }
  // validate password
  if (password.value == "") {
    f3=0;
    password.style.border = "1px solid red";
    document.getElementById('password_div').style.color = "red";
    password_error.textContent = "Password is required";
    password.focus();
  }
  // check if the two passwords match
  if (password.value != password_confirm.value) {
    f4=0;
    password_confirm.style.border = "1px solid red";
    document.getElementById('pass_confirm_div').style.color = "red";
    pass_confirm_error.textContent = "Passwords do not match";
    password_confirm.focus();
  }
  if(f1==0||f2==0||f3==0||f4==0)return false;
}
// event handler functions
function nameVerify() {
  if (username.value != "") {
   username.style.border = "1px solid #5e6e66";
   document.getElementById('username_div').style.color = "#5e6e66";
   name_error.innerHTML = "";
   return true;
  }
}
function emailVerify() {
  if (email.value != "") {
    email.style.border = "1px solid #5e6e66";
    document.getElementById('email_div').style.color = "#5e6e66";
    email_error.innerHTML = "";
    return true;
  }
}
function passwordVerify() {
  if (password.value != "") {
    password.style.border = "1px solid #5e6e66";
    document.getElementById('password_div').style.color = "#5e6e66";
    password_error.innerHTML = "";
    return true;
  }
  if (password.value === password_confirm.value) {
    password_confirm.style.border = "1px solid #5e6e66";
    document.getElementById('pass_confirm_div').style.color = "#5e6e66";
    pass_confirm_error.innerHTML = "";
    return true;
  }
}