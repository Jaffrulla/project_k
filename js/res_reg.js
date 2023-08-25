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
      function caution(field){
        document.getElementById(field+"_miss").innerHTML = "**Mandatroy field";
      }
      function cautionless(field) {
        document.getElementById(field+"_miss").innerHTML = "";
      }
      var lis = ["rn","mob","mail","loc","image","pass","cpass"];
      var temp;
      var flag = true;
      for(i=0;i<7;i++){
        temp = document.getElementById(lis[i]);
        if(temp.value==''){
          caution(temp.id);
          flag = false;
        }
        else
          cautionless(temp.id);
      }
  
      return flag;
    }
      if(check()){
      var flag = true;
      var mobile = document.getElementById('mob').value;
      var temp = document.getElementById('cpass').value;
      var pass = document.getElementById('pass').value;
      var loc = document.getElementById('loc').value;
      var loc_flag = false;
      if(loc.length>30){
        if(loc.slice(0,20)=='https://goo.gl/maps/'){
          loc_flag = true;
        }
        else{
          if(loc.slice(0,28)=='https://www.google.com/maps/'){
            loc_flag =true;
          }
        }
      }
      var msg = "Could NOT Register You in. Because:";
      //var phoneno = /^\d{10}$/;
      //||(mobile.match(phoneno))
      if((mobile.length!=10)){
        msg = msg+"\n     - Invalid Mobile Number entered.";
        flag = false;
      }
      if(pass.length<8){
        msg = msg+"\n     - Password should be atleast 8 characters.";        
        flag = false;
      }
      if(pass!=temp){
        msg = msg+"\n     - Password and Confirm password should match.";        
        flag = false;
      }
      if(!loc_flag){
        msg = msg+"\n     - Invalid Location link is given.";        
        flag = false;
      }
      if(flag){
        return true;
      }
      else{
        alert(msg);
        return false;
      }
    }
    else
    return false;
  }
  