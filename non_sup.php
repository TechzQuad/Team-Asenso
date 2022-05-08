
<?php
include('incl/auth.php');
require_once 'incl/config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$brgy1 = $_GET['brgy'];
$sql1 = "SELECT *, SUBSTRING_INDEX(pos, ' ', 1) as co, SUBSTRING_INDEX(pos, ' & ', -1) as lead FROM election WHERE id='".$id[0]."'";
$qry = mysqli_query($conn,$sql1);
$data = mysqli_fetch_array($qry);
$cluster_id=$data['cluster_id'];
$count=count($id);
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
			    //define total number of results you want per page  
                 
    }
    $results_per_page = 200;  
              
    //find the total number of results stored in the database  
    $page_sql = "SELECT count(*) as p FROM election where pos=''";
    $page_result = $conn->query($page_sql);
    $page_data =  $page_result->fetch_assoc();
    $number_of_page = ceil ($page_data['p'] / $results_per_page);  
include'incl/nav.php';?>
<div class="container mt-3" >
    <br>
    <?php

    
    if (!isset ($_GET['page']) ) {  
        $page = 1;  
    } else {  
        $page = $_GET['page'];  
    }  
	$page_first_result = ($page-1) * $results_per_page;
      
    
    ?>

 <table id="kram" class="display" style="width:100%">
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
    $sql = "SELECT * FROM election where
   pos='' order by name limit ". $page_first_result . "," . $results_per_page;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if($row['remarks']!=""){
                    echo "<tr style='background-color:red;'><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
                    <td>".$row["brgy"].", ".$row["prk"] ."</td>
                    <td>".$row["pn"]."</td>
                    <td>".$row["pos"]."</td>";
                    if($row["status"]!="voted"){
                        echo "<td><span class='badge bg-danger'>".$row["status"]."</span></td>";
                    }else{
                        echo "<td><span class='badge bg-success'><a href='brgy_member_update.php?id=".$row["id"]."' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                        
                    }
                    echo "<td>
                        <a class='badge bg-success' href='position.php?id=" . $row["id"]."/".$id[0]. "' id=". $row["id"].">View Leaders</a>
                        <a class='badge bg-primary' href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                        </td>
                        </tr>";
                }else{  
                echo "<tr><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
                    <td>".$row["brgy"].", ".$row["prk"] ."</td>
                    <td>".$row["pn"]."</td>
                    <td>".$row["pos"]."</td>";
                    if($row["status"]!="voted"){
                        echo "<td><span class='badge bg-danger'><a href='non_sup_update.php?id=".$row["id"]."' class='btn badge bg-danger a'>".$row["status"]."</a></span></td>";
                    }else{
                        echo "<td><span class='badge bg-success'><a href='non_sup_update.php?id=".$row["id"]."' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                        
                    }
                    echo "<td>
                        <a class='badge bg-primary' href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                        </td>
                        </tr>";
            }
        }
    } else {
      echo "0 results";
    }
$conn->close();
?>
    </tbody>
</table>
<?php 
for($page = 1; $page<= $number_of_page; $page++) {  
        echo "<a class='btn btn-secondary' href='non_sup.php?page=".$page."' style='border-radius:100px;margin:2px 2px 5px 5px;column-count:2'>".$page."</a>";
        if($page==25 || $page==49 || $page==70 || $page==100 || $page==125){
            echo "<br>";
        }
        
    }
?>
</div>
<br><?php include'incl/footer.php';?>
</body>
</html>