<?php
include('incl/auth.php');
require_once 'incl/config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['name'])){
    $name =  $_POST['name'];
    $count=count($name);
    $id = $_GET['id'];
    $id_explode = explode("/", $id);
    $id_cluster_precint = $id_explode[2];
    $id_coordinator = $id_explode[1];
    $id_leader = $id_explode[0];
    
    for($x=0; $x<$count; $x++){
        $name_upper = strtoupper($name[$x]);
        $name_clean = mysqli_real_escape_string($conn, $name_upper);
        $special_name= htmlspecialchars($name_upper);
        $sql = "SELECT * FROM election where name like '%$name_clean%'";
        $result = $conn->query($sql);
        $data =  $result->fetch_assoc();
        echo $special_name ;
        $sql1 = "UPDATE election SET pos='Member', leader_id='$id_leader', coordinator_id='$id_coordinator', cluster_id='$id_cluster_precint' WHERE name='".$special_name."'";
        if ($conn->query($sql1) === TRUE) {
            echo "updated successfully!!";
                 
        } else {
          echo "Error updating record: " . $conn->error;
        }
        
    }

}


?>