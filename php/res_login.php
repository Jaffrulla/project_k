<?php
include('connect.php');
$mobile = $_POST['mobile'];
$password = $_POST['password'];
//Database connecting
$conn = access('critic_foodie');
    $stmt = "SELECT * FROM Restaurants WHERE contact='$mobile'";
    $result = $conn->query($stmt);
    if(mysqli_num_rows($result)==0){
      echo "
      <script>
      alert('Mobile Number is not Registered for any Restaurant.');
      window.location.href = '/critic_foodie/webpages/res_login.html';
      </script>
      ";
      die();
    }
    else{
      $restaurant = mysqli_fetch_assoc($result);
      $real_password = $restaurant['password'];
      if($real_password == $password){
        $sql = "SELECT logout_time from res_login_data 
        where logout_time='0000-00-00 00:00:00' and contact='$mobile';";
        $exist = $conn->query($sql);
        if(mysqli_num_rows($exist)!=0){
          session_start();
          $_SESSION['mobile'] = $mobile;
          $_SESSION['user_type'] = "restaurant";
          $_SESSION['menu'] = $restaurant['menu'];
          $_SESSION['res_name'] = $restaurant['restaurant_name'];
          echo "
            <script>
              alert('This Restaurant is already Logged in.');
              window.location.href='/critic_foodie/webpages/res_acc.php';
            </script>
          ";
        }
        else{
          $stmt2 = "SELECT restaurant_name,menu FROM Restaurants WHERE contact='$mobile'";
          $ans = $conn->query($stmt2);
          $names = mysqli_fetch_assoc($ans);
          $res_name = $names['restaurant_name'];
          $menu = $names['menu'];
          $dt = date('Y-m-d H:i:s');
          $stmt3 = $conn->prepare("insert into res_login_data (restaurant_name, menu, contact, login_time)
          values ('$res_name','$menu','$mobile','$dt')");
          $output = $stmt3->execute();
          session_start();
          $_SESSION['mobile'] = $mobile;
          $_SESSION['user_type'] = "restaurant";
          $_SESSION['menu'] = $menu;
          $_SESSION['res_name'] = $res_name;
          if($output){
            echo "
              <script>
                alert('Login Successful');
                window.location.href = '/critic_foodie/webpages/res_acc.php';
              </script>
            ";
          }
          die();
        }
      }
      else{
        echo "
          <script>
          alert('Restaurant Exists, but Incorrect Password');
          window.location.href = '/critic_foodie/webpages/res_login.html';
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
