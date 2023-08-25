<?php
// $rating = 5;
// $review = "can be ~~ better <>";
// $review = str_replace('~~','',$review);
// $review = str_replace('<>','',$review);
// $num = 9999999999;
// $dt = date('d-M-Y, D');
// $final = '<>'.$num.'~~'.$dt.'~~'.$review.'~~'.$rating;
include('connect.php');
$g = mysqli_fetch_assoc(get_data('cf_menus','Brindavan Foods 0','description','item','Poori'));
display($g);


//CREATE TABLE `cf_reviews`.`reference_overall_structure` (`id` INT(4) NOT NULL AUTO_INCREMENT , 
//`restaurant_name` VARCHAR(100) NOT NULL , `rating` FLOAT(4) NOT NULL , `reviews` TEXT NOT NULL , 
//PRIMARY KEY (`id`)) ENGINE = InnoDB;

//"<>9999999999~~2022-12-13~~5~~rating<>"
?>

