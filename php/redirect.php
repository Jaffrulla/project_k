<?php

session_start();
if($_GET['redirect']){
    $menu = $_GET['menu'];
    $res_name = $_GET['res_name'];
    $_SESSION['menu'] = $menu;
    $_SESSION['res_name'] = $res_name;
    echo "$menu,$res_name";
    header("Location: ../webpages/display_menu.php");
}
?>