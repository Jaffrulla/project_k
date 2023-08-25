<?php
include('connect.php');
$mobile = $_POST['mobile'];
$password = $_POST['password'];
//Database connecting
$conn = access('critic_foodie');
    $stmt = "SELECT password FROM Accounts WHERE mobile='$mobile'";
    $result = $conn->query($stmt);
    if(mysqli_num_rows($result)==0){
      echo "
      <script>
      alert('User Does not Exist');
      window.location.href = '/critic_foodie/webpages/login.html';
      </script>
      ";
      die();
    }
    else{
      $real_password = mysqli_fetch_assoc($result)['password'];
      if($real_password == $password){
        $sql = "SELECT logout_time from login_data 
        where logout_time='0000-00-00 00:00:00' and mobile='$mobile';";
        $exist = $conn->query($sql);
        if(mysqli_num_rows($exist)!=0){
          session_start();
          $_SESSION['mobile'] = $mobile;
          $_SESSION['user_type'] = "user";
          $_SESSION['reviews_given'] = array();
          echo "
            <script>
              alert('A User is Already Logged in');
              window.location.href='/critic_foodie/webpages/account.php';
            </script>
          ";
        }
        else{
          $stmt2 = "SELECT firstname,lastname FROM Accounts WHERE mobile='$mobile'";
          $ans = $conn->query($stmt2);
          $names = mysqli_fetch_assoc($ans);
          $firstname = $names['firstname'];
          $lastname = $names['lastname'];
          $dt = date('Y-m-d H:i:s');
          $stmt3 = $conn->prepare("insert into login_data (mobile, firstname, lastname, login_time)
          values ('$mobile','$firstname','$lastname','$dt')");
          $output = $stmt3->execute();
          session_start();
          $_SESSION['mobile'] = $mobile;
          $_SESSION['user_type'] = "user";
          $_SESSION['reviews_given'] = array();
          if($output){
            echo "
              <script>
                alert('Login Successful');
                window.location.href = '/critic_foodie/webpages/account.php';
              </script>
            ";
          }
          die();
        }
      }
      else{
        echo "
          <script>
          alert('User Exists, but Incorrect Password');
          window.location.href = '/critic_foodie/webpages/login.html';
          </script>
        ";
        die();
      }
    }
    $sql->close();
    $stmt2->close();
    $stmt3->close(); 
    $stmt->close();
    $conn->close();

 ?>
