<?php
include('incl/auth1.php');

require_once 'incl/config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$ind=$_SESSION['id'];
$id= md5($ind);
$ids = $_GET['id'];
$sql1 = "SELECT * FROM election WHERE id='$ind'";
$qry = mysqli_query($conn,$sql1);
$data = mysqli_fetch_array($qry);

$sql2 = "SELECT * FROM election WHERE id='$ids'";
$qry1 = mysqli_query($conn,$sql2);
$data1 = mysqli_fetch_array($qry1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include'incl/links.php';?>
<style>
    .a{
        text-decoration: none;
    }
    .a:hover{
        color: white;
        text-shadow: 2px 2px red;
    }
    
    
</style>
 
</head>
<body>
<!--<?php include'incl/nav.php';?>-->
  

 
<div class="container mt-3">
  <?php if($data['pos'] == 'Cluster Precint Leader'){?>
<h1>Coordinator Table</h1> 
<?php }else if($data['pos'] == 'Coordinator'){?>
  <h1> Leader Table</h1>
<?php }else{?>
  <h1> Member Table</h1>
<?php }?>  
 <table id="voters" class="display" style="width:100%">
    <thead>
      <tr>
        <th>Name</th>
        <th>Address</th>
        <th>Precinct #</th>
        <th>Position</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
<?php


if($data['pos'] == 'Cluster Precint Leader'){
    if($id == $ids){
        $sql = "SELECT * FROM election where (pos='Coordinator' || pos='Leader' || pos='Member') && cluster_id='$ind' ";
        $result = $conn->query($sql);
        
        
        if ($result->num_rows > 0) {
         
          while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
            <td>".$row["brgy"].", ".$row["prk"] ."</td>
            <td>".$row["pn"]."</td>
            <td>".$row["pos"]."</td>";
            if($row["status"]!="voted"){
                echo "<td><span class='badge bg-danger'>".$row["status"]."</span></td>";
            }else{
                echo "<td><span class='badge bg-success'>".$row["status"]."</span></td>";
            }
         echo "<td>
         <a href='user.php?id=" . $row["id"]. "' id=". $row["id"].">View Leaders</a>
         <a href='user_view_info.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
         </td>
            </tr>";
          }
          
        } else {
          echo "0 results";
        }
    }
}if($data1['pos'] == 'Coordinator'){
    echo "<script>alert('wala my natabo!!')</script>";
}else{

}

$conn->close();
?>

    
    </tbody>
  </table>  
  
</div>

<br><br>
<div class="row">
<?php include'incl/footer.php';?>
</div>
</body>
</html>