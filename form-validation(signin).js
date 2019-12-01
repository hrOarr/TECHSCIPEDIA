var username = document.forms['vform']['username'];
var password = document.forms['vform']['password'];
// SELECTING ALL ERROR DISPLAY ELEMENTS
var name_error = document.getElementById('name_error');
var password_error = document.getElementById('password_error');
// SETTING ALL EVENT LISTENERS
//username.addEventListener('blur', nameVerify, true);
//email.addEventListener('blur', emailVerify, true);
//// validation function
function Validate() {
  // validate username
  var f1=1,f2=1,f3=1,f4=1;
  var name = username.value;
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
  // validate password
  if (password.value == "") {
    f3=0;
    password.style.border = "1px solid red";
    document.getElementById('password_div').style.color = "red";
    password_error.textContent = "Password is required";
    password.focus();
  }
  if(f1==0||f3==0)return false;
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