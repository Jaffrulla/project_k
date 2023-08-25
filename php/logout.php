<?php
include('connect.php');
session_start();
if($_GET['logout']){
    record();
}
function record(){
    $conn = access('critic_foodie');
        $mobile = $_SESSION['mobile'];
        $sql = "SELECT logout_time from login_data where mobile='$mobile' and logout_time='0000-00-00 00:00:00';";
        $result = $conn->query($sql);
        if(mysqli_num_rows($result)==0){
            echo "
                <script>
                    alert('User is Already Logged out');
                    window.location.href='/critic_foodie/index.html';
                </script>
            ";
        }
        else{
        $dt = date('Y-m-d H:i:s');
        $stmt = $conn->prepare("UPDATE login_data set logout_time='$dt' where mobile='$mobile' and logout_time='0000-00-00 00:00:00';");
        $output = $stmt->execute();
        session_unset();
        session_destroy();
        echo "
            <script>
                alert('Logging Out');
                window.location.href = '/critic_foodie/index.html';
            </script>
        ";
        }
    $sql->close();
    $stmt->close();
    $conn->close();
    }
?>