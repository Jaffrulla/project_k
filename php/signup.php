<?php
include('connect.php');
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $gender = $_POST['gender'];
  $mobile = $_POST['mobile'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  //Database connecting
  $conn = access('critic_foodie');
    $sql = "SELECT * from Accounts where mobile = '$mobile';";
    $result = $conn->query($sql);
    if($result){
      $count = mysqli_num_rows($result);
      if($count){
         echo "
              <script>
                  alert('User Already Exists');
                  window.location.href = '/critic_foodie/webpages/signup.html';
              </script>
              ";
        }
    }
    $stmt = $conn->prepare("insert into Accounts (firstname, lastname, gender, mobile, email, password)
    VALUES ('$firstname', '$lastname', '$gender', '$mobile', '$email', '$password');");
    $result = $stmt->execute();
    if($result)
      echo "
      <script>
        alert('Registration Successful');
        window.location.href = '/critic_foodie/webpages/login.html';
      </script>
      ";
    else
      echo "Error";
    $stmt->close();
    $sql->close();
    $conn->close();
?>
