<?php
include('connect.php');
session_start();
$menu = $_SESSION['menu'];
$count = $_POST['count'];
$conn = access('cf_menus');
    for($i=1;$i<=$count;$i++){
        $item = $_POST['Item'.$i];
        if($item==''){
            continue;
        }
        $price = $_POST['Price'.$i];
        $desc = $_POST['desc'.$i];
        $duplicate = "SELECT item from `{$menu}`;";
        $rows = $conn->query($duplicate);
        $flag = false;
        
        $img_name = $_FILES['image'.$i]['name'];
        $img_tmp_name = $_FILES['image'.$i]['tmp_name'];
        $img_ext = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ext = strtolower($img_ext);
        $allowed_ext = array('jpg','jpeg','png','bmp','gif');
        if(in_array($img_ext,$allowed_ext)){
            $image = uniqid("IMG-",true).'.'.$img_ext;
            $upload_path = '../css/item_uploads/'.$image;
            if(move_uploaded_file($img_tmp_name, $upload_path)){
                echo "Images Uploaded";
            }
            else{
                echo "Error Uploading Images";
                die();
            }
        }
        else{
            $msg = "Invalid_Format_for_'$img_name'";
            header("Location: ../webpages/menus.php?error=$msg");
            die();
        }

        while($row = mysqli_fetch_assoc($rows)){
          if($item == $row['item']){
            $flag = true;
            if($desc==''){
              $req = "UPDATE `{$menu}` set price='$price',image='$image' where item='$item' ;";
            }
            else{
              $req = "UPDATE `{$menu}` set price='$price',image='$image',description='$desc' where item='$item' ;";
            }
            $stmt = $conn->prepare($req);
            $result = $stmt->execute();
            break;
          }
        }
        if($flag){
          continue;
        }
        if($desc!=''){
          $req = "INSERT into `{$menu}` (item,price,image,description)
          values ('$item','$price','$image','$desc');";
        }
        else{
          $req = "INSERT into `{$menu}` (item,price,image)
          values ('$item','$price','$image');";
        }
        $stmt = $conn->prepare($req);
        $result = $stmt->execute();
        $conn2 = access('cf_reviews');
        $stmt = $conn2->prepare("INSERT into `{$menu}` (item) values('$item');");
        $result = $stmt->execute();
    }
    echo "
      <script>
        alert('Registration Completed');
        window.location.href = '/critic_foodie/webpages/res_login.html';
      </script>
      ";


$conn->close();
$conn2->close();
?>
