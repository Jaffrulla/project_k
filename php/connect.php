<?php
function access($dbname){
    $conn = new mysqli('localhost','root','',$dbname);
if($conn->connect_error){
    die('Connection Failed : '.$conn->connect_error);
  }
else{
    return $conn;
}
}

function get_data($database,$table,$column,$ref_column,$ref_value){
    $conn = access($database);
    $sql = "SELECT {$column} from `{$table}` where `{$ref_column}`='{$ref_value}';";
    // echo $sql;
    $result = $conn->query($sql);
    // echo "<br>success";
    return $result;
}

function display($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

function get_alert($data){
    echo  "
    <script>
    alert('$data');
    </script>
    ";
}
?>