<?php
include('connect.php');
  $restaurant_name = $_POST['restaurant_name'];
  $mobile = $_POST['mobile'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  //Database connecting
  $conn = access('critic_foodie');
    $sql = "SELECT * from Restaurants where contact = '$mobile';";
    $result = $conn->query($sql);
    $count = mysqli_num_rows($result);
    if($count>0){
      echo "
      <script>
        alert('This Mobile Number is linked with another restaurant. Please Use another number.');
        window.location.href = '/critic_foodie/webpages/res_reg.html';
      </script>
      ";
    }
    else{
    $sql = "SELECT * from Restaurants where restaurant_name = '$restaurant_name';";
    $result = $conn->query($sql);


    $location = $_POST['location'];
    $img_name = $_FILES['image']['name'];
    $img_tmp_name = $_FILES['image']['tmp_name'];
    $img_ext = pathinfo($img_name, PATHINFO_EXTENSION);
    $img_ext = strtolower($img_ext);
    $allowed_ext = array('jpg','jpeg','png','bmp','gif');
    if(in_array($img_ext,$allowed_ext)){
        $image = uniqid("IMG-",true).'.'.$img_ext;
        $upload_path = '../css/res_uploads/'.$image;
        if(move_uploaded_file($img_tmp_name, $upload_path)){
            echo "Image uploaded";
        }
        else{
            echo "Error Uploading Image";
            if(is_writable($upload_path)){
            echo "<br>$image<br>$img_tmp_name<br>$upload_path";
            }
            die();
        }
    }


    $count = mysqli_num_rows($result);
    $count = strval($count);
    $menu = $restaurant_name." ".$count;
    $stmt = $conn->prepare("insert into Restaurants (restaurant_name, email, contact, password, menu, image, location)
    VALUES ('$restaurant_name', '$email', '$mobile', '$password', '$menu', '$image', '$location');");
    $result = $stmt->execute();
    $conn2 = access('cf_menus');
      $create_table = $conn2->prepare("CREATE TABLE `{$menu}` (
        s_no int NOT NULL AUTO_INCREMENT , 
        item varchar(50) NOT NULL , 
        price int NOT NULL , 
        image varchar(255) NOT NULL DEFAULT 'none',
        description text NOT NULL Default 'none',
        PRIMARY KEY (s_no));");
        $result = $create_table->execute();
    $conn3 = access('cf_reviews');
    $create_table = $conn3->prepare("CREATE TABLE `{$menu}` (
      id int NOT NULL AUTO_INCREMENT , 
      item varchar(100) NOT NULL , 
      rating float NOT NULL Default 0 , 
      count int NOT NULL Default 0,
      reviews text NOT NULL DEFAULT 'none',
      PRIMARY KEY (id));");
      $result = $create_table->execute();
    $stmt = $conn3->prepare("INSERT into restaurant_reviews (restaurant_name) values('$menu');");
    $result = $stmt->execute();
    if($result){
    session_start();
          $_SESSION['menu'] = $menu;
          $_SESSION['user_type'] = "restaurant";
          $_SESSION['mobile'] = $mobile;
          $_SESSION['res_name'] = $restaurant_name;
      header("Location: ../webpages/menus.html");
    }
    else{
      echo "Error";
    }
    $stmt->close();
    $sql->close();
    $conn->close();
    $conn2->close();
    $conn3->close();
  }
?>
