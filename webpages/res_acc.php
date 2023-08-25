<?php
include('../php/res_logout.php');
session_start();

$conn = new mysqli('localhost','root','','cf_menus');
if($conn->connect_error){
    die('Connection Failed : '.$conn->connect_error);
}

$conn2 = new mysqli('localhost','root','','critic_foodie');
if($conn2->connect_error){
    die('Connection Failed : '.$conn2->connect_error);
}
$conn3 = new mysqli('localhost','root','','cf_reviews');
if($conn3->connect_error){
    die('Connection Failed : '.$conn3->connect_error);
}

$menu = $_SESSION['menu'];
$res_name = $_SESSION['res_name'];
$stmt = "SELECT * from `{$menu}`;";
$result = $conn->query($stmt);


//  if($_GET['submit_review']){
//     $item = $_GET['item'];
//     if(!array_key_exists($res_name,$_SESSION['reviews_given'])){
//         $_SESSION['reviews_given'][$res_name] = array();
//     }
//     if(!in_array($item,$_SESSION['reviews_given'][$res_name])){
//         $rating = $_GET['rating'];
//         $review = $_GET['review'];
//         $review = str_replace('~~','',$review);
//         $review = str_replace('<>','',$review);
        
//         $count = mysqli_fetch_assoc(get_data('cf_reviews',$menu,'count','item',$item));
//         $count = $count['count'];
//         $mobile = $_SESSION['mobile'];
//         $uname = mysqli_fetch_assoc(get_data('critic_foodie','Accounts','firstname','mobile',$mobile));
//         $uname = $uname['firstname'];
        
//         $dt = date('d-M-Y,  D');
//         $final = '<>'.$uname.'~~'.$dt.'~~'.$review.'~~'.$rating;
//         if($count>0){
//             $cur_rate = mysqli_fetch_assoc(get_data('cf_reviews',$menu,'rating','item',$item));
//             $cur_rate = $cur_rate['rating'];
//             $cur_rate = $cur_rate + $rating;
//             $cur_review = mysqli_fetch_assoc(get_data('cf_reviews',$menu,'reviews','item',$item));
//             $cur_review = $cur_review['reviews'];
//             $final = $final.$cur_review;
//         }
//         else{
//             $cur_rate = $rating;
//         }
//         $count = $count + 1;
//         $stmt = "UPDATE `{$menu}` set rating='$cur_rate',count='$count',reviews='$final' where item='$item';";
//         $sql = $conn3->prepare($stmt);
//         $done = $sql->execute();
//         $count = mysqli_fetch_assoc(get_data('critic_foodie','Accounts','rev_count','mobile',$mobile));
//         $count = $count['rev_count'];
//         $final = '<>'.$res_name.'~~'.$item.'~~'.$dt.'~~'.$review.'~~'.$rating;
//         if($count>0){
//             $cur_review = mysqli_fetch_assoc(get_data('critic_foodie','Accounts','reviews','mobile',$mobile));
//             $cur_review = $cur_review['reviews'];
//             $final = $final.$cur_review;
//         }
//         $count = $count + 1;
//         $sql = $conn2->prepare("UPDATE Accounts set rev_count='$count',reviews='$final' where mobile='$mobile';");
//         $done = $sql->execute();
//         $_SESSION['reviews_given'][$res_name][] = $item;
//     }
    
//  }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Critic Foodie</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="../css/display_menu.css">
    <link rel="stylesheet" href="../css/stars.css">
    <!-- Link to our js file -->
    <script src="../js/res_acct.js"></script>
</head>

<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="#" title="Logo">
                    <img src="../css/images/cf.png" alt="Logo" class="img-responsive">
                </a>
            </div>

            <div class="menu">
                <ul>
                    <li>
                        <a href="res_acc.php">Home</a>
                    </li>
                    <li>
                        <a href="about3.html">About</a>
                    </li>
                    <li>
                        <a href="contact2.html">Contact Us</a>
                    </li>
                    <li>
                        <a href="#" onClick='location.href = "?logout=1"'>Logout</a>
                    </li>
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Navbar Section Ends Here -->

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
                <h2><?php echo $res_name; ?></h2>
                <br>

                

        </div>
    </section>
    <!-- food search Section Ends Here -->
  

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <ul id="dynamic_res">
            <?php

                while($row = mysqli_fetch_assoc($result)){
                    $item_name = $row['item'];
                    $price = $row['price'];
                    $img = $row['image'];
                    $desc = $row['description'];
                    $cur_rate = mysqli_fetch_assoc(get_data('cf_reviews',$menu,'rating','item',$item_name));
                    $cur_rate = $cur_rate['rating'];
                    $count = mysqli_fetch_assoc(get_data('cf_reviews',$menu,'count','item',$item_name));
                    $count = $count['count'];
                    if($count!=0){
                    $cur_rate = $cur_rate / $count;
                    }
                    else{
                        $cur_rate = 0;
                    }
                    $reviews_present = mysqli_fetch_assoc(get_data('cf_reviews',$menu,'reviews','item',$item_name));
                    $reviews_present = $reviews_present['reviews'];
                    echo "
                    <script>
                    card_insert('$item_name','$price','$img','$desc','$reviews_present','$cur_rate');
                    </script>";
                }
            ?>
            </ul>
           

            <div class="clearfix"></div>

            
        </div>
    </section>
    <div id='get_res_reviews'>


</div>
<div class='backing'>
<span id='backing'>
    <br><br><button class="btn" onclick='location.href = "?show_reviews=1"'>Restaurant Reviews</button>
</span>
</div>
<?php
$res_reviews_given = mysqli_fetch_assoc(get_data('cf_reviews','restaurant_reviews','reviews','restaurant_name',$menu));
$res_reviews_given = $res_reviews_given['reviews'];
if($_GET['show_reviews']){
    echo "
    <script>
    get_res_reviews('$res_reviews_given');
    </script>
    ";
}
//get_alert("$res_reviews_given");
?>
    <!-- fOOD Menu Section Ends Here -->
    
    <!-- social Section Starts Here -->
    <section class="social">
        <div class="container">
            <ul>
                <li>
                    <a href="#"><img src="https://img.icons8.com/fluent/50/000000/facebook-new.png"/></a>
                </li>
                <li>
                    <a href="#"><img src="https://img.icons8.com/fluent/48/000000/instagram-new.png"/></a>
                </li>
                <li>
                    <a href="#"><img src="https://img.icons8.com/fluent/48/000000/twitter.png"/></a>
                </li>
            </ul>
        </div>
    </section>
    <!-- social Section Ends Here -->

    <!-- footer Section Starts Here -->
    <section class="footer">
        <div class="container text-center">
            <p>All rights reserved.</p>	
        </div>
    </section>
    <!-- footer Section Ends Here -->
<?php 
$conn->close();
$conn2->close();
$conn3->close();
?>
</body>
</html>
