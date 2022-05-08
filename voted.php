<?php
include('incl/auth.php');
require_once 'incl/config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include'incl/links.php';?>
<link href="incl/swa/dist/sweetalert.css" rel="stylesheet" type="text/css">
<script src="incl/swa/dist/sweetalert.min.js" type="text/javascript"></script> 
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
<?php 
 $id_session = $_SESSION['id'];
    $id_sql = "SELECT * FROM users where id='$id_session' AND position='admin'";
    $id_result = $conn->query($id_sql);
    $id_data =  $id_result->fetch_assoc();
    if($id_session==$id_data['id']){
        session_start();
    }else{
        unset($_SESSION['id']);
        unset($_SESSION['username']);
        echo "<script language = 'javascript'>
				swal({title: 'Failed To Login!',
                text: 'You cant access this Page',
                type : 'error',
                showConfirmButton: false,
                timer: 1000,
                },
                function(){
                setTimeout(function(){
                location = 'login.php';
                });
                });
				</script>";
    }
include'incl/nav.php';?>
<div class="container mt-3" >
<br>
 <table id="kram" class="display" style="width:100%">
    <thead>
      <tr>
        <th>Name</th>
        <th>Address</th>
        <th>Precinct #</th>
        <th>Position</th>
        <th>Status</th>
        <th>Time</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
<?php
    $sql = "SELECT election.name,election.standing, election.pn, election.pos, election.brgy, election.prk , election.status , tbl_time.* from tbl_time INNER JOIN election ON tbl_time.voter_id=election.id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
                <td>".$row["brgy"].", ".$row["prk"] ."</td>
                <td>".$row["pn"]."</td>
                <td>".$row["pos"]."</td>";
                echo "<td><span class='badge bg-success'>".$row["status"]."</span></td>
                <td><span >".$row["real_time"]."</span></td>";
            
            echo "<td>
                <a class='badge bg-primary' href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                </td>
                </tr>";
        }
    } else {
      echo "0 results";
    }
$conn->close();
?>
</tbody>
</table>
</div><br> 
<?php include'incl/footer.php';?>
</body>
</html>