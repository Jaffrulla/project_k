<?php
session_start();
include("../php/logout.php");
include("../php/redirect.php");
$conn = new mysqli('localhost','root','','critic_foodie');
if($conn->connect_error){
    die('Connection Failed : '.$conn->connect_error);
}
$stmt = "SELECT * from Restaurants;";
$result = $conn->query($stmt);
$mobile = $_SESSION['mobile'];
$user_info = mysqli_fetch_assoc(get_data('critic_foodie','Accounts','*','mobile',$mobile));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Critic Foodie</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="../css/account.css">
    <link rel="stylesheet" href="../css/stars.css">
    <!-- Link to our js file -->
    <script src="../js/account.js"></script>

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
                        <a href="account.php">Home</a>
                    </li>
                    <li>
                        <a href="about.html">About</a>
                    </li>
                    <li>
                        <a href="contact.html">Contact Us</a>
                    </li>
					<li>
                        <a href="#" onClick='location.href = "?logout=1"'>Logout</a>
                    </li>
                    <!-- <li>
                        <a href="#">Account</a>
                    </li> -->
                </ul>
                <div class='acc_info'>
                <h3>Welcome <?php echo $user_info['firstname']; ?></h3>
                <p><?php echo $user_info['firstname'].' '.$user_info['lastname'].'  ('.$user_info['gender'].')'; ?></p><hr>
              <p id='u_details'> Contact : +91 <?php echo $user_info['mobile']; ?><br>
              Email : <?php echo $user_info['email']; ?> </p>
               
                </div>
            </div>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Navbar Section Ends Here -->

    <!-- fOOD sEARCH Section Starts Here -->
    <!-- food search Section Ends Here -->

    <!-- Categories Section Starts Here -->
    <!-- <section class="categories">
        <div class="container">
            <h2>Explore New Places</h2>

            <a href="category-foods.html">
            <div class="box-3 float-container">
                <img src="../css/images/idli.jpg" alt="idli" class="img-responsive">

                <h3 class="float-text">Idli</h3>
            </div>
            </a>

            <a href="#">
            <div class="box-3 float-container">
                <img src="../css/images/dosa.jpg" alt="Dosa" class="img-responsive">

                <h3 class="float-text">Dosa</h3>
            </div>
            </a>

            <a href="#">
            <div class="box-3 float-container">
                <img src="../css/images/vada.jpg" alt="Vada" class="img-responsive">

                <h3 class="float-text">Vada</h3>
            </div>
            </a>

            <div class="clearfix"></div>
        </div>
    </section> -->
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <ul id="dynamic_res">
            <h2><pre>  Explore New Places  </pre></h2>
            <?php

                while($row = mysqli_fetch_assoc($result)){
                    $menu = $row['menu'];
                    $res_name = $row['restaurant_name'];
                    $contact = $row['contact'];
                    $img = $row['image'];
                    $cur_rate = mysqli_fetch_assoc(get_data('cf_reviews','restaurant_reviews','rating,count','restaurant_name',$menu));
                    if($cur_rate['count']!=0){
                        $cur_rate = $cur_rate['rating'] / $cur_rate['count'];
                        }
                        else{
                            $cur_rate = 0;
                        }
                    echo "
                    <script>
                    card_insert('$menu','$res_name','$contact','$img','$cur_rate');
                    </script>";
                }
            ?>
            </ul>
           

            <div class="clearfix"></div>

            

        </div>
    </section>
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
?>
</body>
</html>
