<?php
include 'incl/config.php';
//load the ar library
include 'phpqrcode/qrlib.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$id=$_GET['id'];
$remarks=$_POST['remarks'];
$sql = "SELECT * FROM election WHERE id='$id'";
$qry = mysqli_query($conn,$sql);
$data = mysqli_fetch_array($qry);
$sql1 = "SELECT * FROM election WHERE id='".$data['cluster_id']."'";
$qry1 = mysqli_query($conn,$sql1);
$data1 = mysqli_fetch_array($qry1);

if($data['pos']=='Cluster Precint Leader'){
    $dsql = "UPDATE election SET remarks='$remarks' WHERE id='$id'";
    if ($conn->query($dsql) === TRUE) {
        echo "<script>
            alert('Record deleted successfully');
            window.location.href='position.php';
          </script>";
        } else {
        echo "Error deleting record: " . $conn->error;
    }
}else if($data['pos']=='Coordinator'){
    $d1sql = "UPDATE election SET remarks='$remarks' WHERE id='$id'";
    if ($conn->query($d1sql) === TRUE) {
      echo "<script>
            alert('Record deleted successfully');
            window.location.href='position.php?id=".$data['cluster_id']."';
          </script>";
    } else {
      echo "Error deleting record: " . $conn->error;
    }    
    
}
// else if($data['pos']=='LEADER'){
//     $d1sql = "DELETE FROM voters WHERE id=$id";
//     if ($conn->query($d1sql) === TRUE) {
//       echo "<script>
//             alert('Record deleted successfully');
//             window.location.href='leader.php?id=".$data['coordinator_id']."';
//           </script>";
//     } else {
//       echo "Error deleting record: " . $conn->error;
//     }    
    
// }else if($data['pos']=='MEMBER'){
//     $d1sql = "DELETE FROM voters WHERE id=$id";
//     if ($conn->query($d1sql) === TRUE) {
//       echo "<script>
//             alert('Record deleted successfully');
//             window.location.href='leader.php?id=".$data['leader_id']."';
//           </script>";
//     } else {
//       echo "Error deleting record: " . $conn->error;
//     }    
    
// }else{
//     echo "wala my natabo";
// }



$conn->close();




?>