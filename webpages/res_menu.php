<?php
session_start();
$menu = $_SESSION['menu'];
$res_name = $_SESSION['res_name'];
$conn = new mysqli('localhost','root','','cf_menus');
if($conn->connect_error){
    die('Connection Failed : '.$conn->connect_error);
}
$stmt = "SELECT * from `{$menu}`;";
$result = $conn->query($stmt);
$num = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="../js/menu_imgs.js"></script>
    <link rel="stylesheet" href="../css/res_menu.css">
    <title>Restaurant Menu</title>
</head>
<body>
    <h1 class="heading" ><?php echo $res_name; ?></h1>
    <form method="post" action="../php/img_upload.php" enctype="multipart/form-data">
        <input type="hidden" name="count" value = "<?php echo $num;?>"/>
        <table border="1" align="center" id="item_list">
            <th>S.No.</th>
            <th>Items</th>
            <th>Prices</th>
            <th>Image</th>
            <?php 
            while($row = mysqli_fetch_assoc($result)){
                $item = $row['item'];
                $price = $row['price'];
                echo "
                <script>
                entry('$item','$price');
                </script>";
            }
            ?>
        </table>
        <button type="submit" value="Upload" name="upload">Submit</button>
    </form>
</body>
</html>