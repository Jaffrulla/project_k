function showpassword(){
  var pass = document.getElementById('pass');
  var cpass = document.getElementById('cpass');
  if((pass.type === "password")&&(cpass.type === "password")){
    pass.type = "text";
    cpass.type = "text";
    document.getElementById('hide').innerHTML = "hide ";
  }
  else{
    pass.type = "password";
    cpass.type = "password";
    document.getElementById('hide').innerHTML = "show";
  }
}



function verify() {
  function check() {
    function check_radio(radname) {
      var rad = document.getElementsByName(radname);
      for(i=0;i<rad.length;i++){
        if(rad[i].checked)
          return false;
      }
      return true;
    }
    function caution(field){
      document.getElementById(field.id+"_miss").innerHTML = "  *Mandatroy field";
    }
    function cautionless(field) {
      document.getElementById(field.id+"_miss").innerHTML = "";
    }
    var lis = ["fn","ln","mob","mail","pass","cpass"];
    var temp;
    var flag = true;
    for(i=0;i<6;i++){
      temp = document.getElementById(lis[i]);
      if(temp.value==''){
        caution(temp);
        flag = false;
      }
      else
        cautionless(temp);
    }
    if(check_radio('gender')){
      document.getElementById("gender_miss").innerHTML = "  *Choose one";
      flag = false;
    }
    else
    document.getElementById("gender_miss").innerHTML = "";
    return flag;
  }
    if(check()){
    var flag = true;
    var mobile = document.getElementById('mob').value;
    var temp = document.getElementById('cpass').value;
    var pass = document.getElementById('pass').value;
    var msg = "Could NOT Register you in. Because:";
    if(mobile.length!=10){
      msg = msg+"\n     -Invalid Mobile Number entered.";
      flag = false;
    }
    if(pass.length<8){
      msg = msg+"\n     -Password should be atleast 8 characters.";
      flag = false;
    }
    if(pass!=temp){
      msg = msg+"\n     -Password and Confirm password should match.";
      flag = false;
    }
    if(flag)
      return true;
    else{
      alert(msg);
      return false;
    }
    }
  else
    return false;
}
