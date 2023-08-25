function passwordvisible(){
    var pass = document.getElementById('password');
    if(pass.type === "password"){
      pass.type = "text";
      document.getElementById('hide').innerHTML = "hide ";
    }
    else{
      pass.type = "password";
      document.getElementById('hide').innerHTML = "show";
    }
  }
  
  function constraint_check(){
    var mob = document.getElementById('mobile').value;
    var pass = document.getElementById('password').value;
    var flag = true;
    if(mob.length!=10){
      document.getElementById('mob_missing').innerHTML = "  **Invalid Mobile Number";
      flag = false;
    }
    else
      document.getElementById('mob_missing').innerHTML = "";
  
    if(pass.length<8){
      document.getElementById('pass_missing').innerHTML = "**Invalid Password<br>";
      flag = false;
    }
    else
      document.getElementById('pass_missing').innerHTML = "";
  
    return flag;
  }
  