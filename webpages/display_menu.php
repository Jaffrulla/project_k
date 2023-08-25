<?php
include('../php/logout.php');
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
$mobile = $_SESSION['mobile'];
$stmt = "SELECT * from `{$menu}`;";
$result = $conn->query($stmt);
$res_given = in_array($menu,$_SESSION['reviews_given']);
$location = mysqli_fetch_assoc(get_data('critic_foodie','Restaurants','location','menu',$menu));
$location = $location['location'];
$uname = mysqli_fetch_assoc(get_data('critic_foodie','Accounts','firstname','mobile',$mobile));
$uname = $uname['firstname'];
//get_alert($location);


if($_GET['submit_review']){
    $item = $_GET['item'];
    if(!array_key_exists($res_name,$_SESSION['reviews_given'])){
        $_SESSION['reviews_given'][$res_name] = array();
    }
    if(!in_array($item,$_SESSION['reviews_given'][$res_name])){
        $rating = $_GET['rating'];
        $review = $_GET['review'];
        $review = str_replace('~~','',$review);
        $review = str_replace('<>','',$review);
        
        $count = mysqli_fetch_assoc(get_data('cf_reviews',$menu,'count','item',$item));
        $count = $count['count'];
        
        
        $dt = date('d-M-Y,  D');
        $final = '<>'.$uname.'~~'.$dt.'~~'.$review.'~~'.$rating;
        if($count>0){
            $cur_rate = mysqli_fetch_assoc(get_data('cf_reviews',$menu,'rating','item',$item));
            $cur_rate = $cur_rate['rating'];
            $cur_rate = $cur_rate + $rating;
            $cur_review = mysqli_fetch_assoc(get_data('cf_reviews',$menu,'reviews','item',$item));
            $cur_review = $cur_review['reviews'];
            $final = $final.$cur_review;
        }
        else{
            $cur_rate = $rating;
        }
        $count = $count + 1;
        $stmt = "UPDATE `{$menu}` set rating='$cur_rate',count='$count',reviews='$final' where item='$item';";
        $sql = $conn3->prepare($stmt);
        $done = $sql->execute();
        $count = mysqli_fetch_assoc(get_data('critic_foodie','Accounts','rev_count','mobile',$mobile));
        $count = $count['rev_count'];
        $final = '<>'.$res_name.'~~'.$item.'~~'.$dt.'~~'.$review.'~~'.$rating;
        if($count>0){
            $cur_review = mysqli_fetch_assoc(get_data('critic_foodie','Accounts','reviews','mobile',$mobile));
            $cur_review = $cur_review['reviews'];
            $final = $final.$cur_review;
        }
        $count = $count + 1;
        $sql = $conn2->prepare("UPDATE Accounts set rev_count='$count',reviews='$final' where mobile='$mobile';");
        $done = $sql->execute();
        $_SESSION['reviews_given'][$res_name][] = $item;
    }
    
}



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
    <script src="../js/display_menu.js"></script>
</head>

<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="account.php" title="Logo">
                    <img src="../css/images/cf.png" alt="Logo" class="img-responsive">
                </a>
            </div>

            <div class="menu">
                <ul>
                    <li>
                        <a href="account.php">Home</a>
                    </li>
                    <li>
                        <a href="about2.html">About</a>
                    </li>
                    <li>
                        <a href="contact.html">Contact</a>
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
        <div class="locations">
            
                <h2><pre>  <?php echo $res_name; ?>  </pre></h2>
                <a href="<?php echo $location; ?>" target="_blank"><button class="btn">location</button></a>
                </div>
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
                    if(array_key_exists($res_name,$_SESSION['reviews_given'])){
                        if(in_array($item_name,$_SESSION['reviews_given'][$res_name])){
                            $given = true;
                        }
                        else{
                            $given = false;
                        }
                    }
                    else{
                        $given = false;
                    }
                    $reviews_present = mysqli_fetch_assoc(get_data('cf_reviews',$menu,'reviews','item',$item_name));
                    $reviews_present = $reviews_present['reviews'];
                    echo "
                    <script>
                    card_insert('$item_name','$price','$img','$desc','$given','$reviews_present','$cur_rate');
                    </script>";
                }
            ?>
            </ul>
           

            <div class="clearfix"></div>

            
        </div>
    </section>
   





    <!-- fOOD Menu Section Ends Here -->
    <section>
        <br>
        <div class='website_rating'>
    <div class="rating-css">
        <span id='website_rating'>
                       
           

        </span>
    </div>
    </div>
    <?php
    if(isset($_POST['submit']) && (!$res_given)){
        $res_rating = $_POST['res_rating'];
        $res_review = $_POST['res_review'];
        $uname = mysqli_fetch_assoc(get_data('critic_foodie','Accounts','firstname','mobile',$mobile));
        $uname = $uname['firstname'];
        $dt = date('d-M-Y,  D');
        $final = '<>'.$uname.'~~'.$dt.'~~'.$res_review.'~~'.$res_rating;
        $ans = mysqli_fetch_assoc(get_data('cf_reviews','restaurant_reviews','*','restaurant_name',$menu));
        $count = $ans['count']+1;
        $rev = $ans['reviews'];
        if($rev=='none'){$rev = $final;}
        else{$rev = $final.$rev;}
        $rat = $ans['rating'];
        $rat = $rat + $res_rating;
        $stmt = $conn3->prepare("UPDATE restaurant_reviews set count='$count',rating='$rat',reviews='$rev' where restaurant_name='$menu' ;");
        $ans = $stmt->execute();
        $final = '<>'.$res_name.'~~'.$dt.'~~'.$res_review.'~~'.$res_rating;  
        $count = mysqli_fetch_assoc(get_data('critic_foodie','Accounts','rev_count','mobile',$mobile));
        $count = $count['rev_count']+1;
        if($count>1){
            $rev = mysqli_fetch_assoc(get_data('critic_foodie','Accounts','reviews','mobile',$mobile));
            $rev = $rev['reviews'];
            $rev = $final.$rev;
        }
        else{
            $rev = $final;
        }
        $sql = "UPDATE Accounts set rev_count='$count',reviews='$rev' where mobile='$mobile';";
        $stmt = $conn2->prepare($sql);
        $ans = $stmt->execute(); 
        if($ans){
        $_SESSION['reviews_given'][] = $menu; 
        }
        $res_given = true;
       
    }
    echo "
    <script>
    submit_restaurant_rating('$res_given');
    </script>";
    ?>
    </section>
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
$conn->close();//cf_menus
$conn2->close();//critic_foodie
$conn3->close();//cf_reviews
?>
</body>
</html>
