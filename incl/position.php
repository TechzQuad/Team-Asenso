<?php
include('incl/auth.php');

require_once 'incl/config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$ids = $_GET['id'];
$id = explode('/',$_GET['id']);
$sql1 = "SELECT * FROM election WHERE id='".$id[0]."'";
$qry = mysqli_query($conn,$sql1);
$data = mysqli_fetch_array($qry);
$cluster_id=$data['cluster_id'];
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
    
    
<?php include'incl/nav.php';?>
  

 
<div class="container mt-3">
  <?php if($data['pos'] == 'Cluster Precint Leader'){?>
<nav>
    <a href="position.php" class="a">Cluster Precint Leader</a>  << 
    <a href="position.php?id=<?php echo $id[0]; ?> " class="a">Coordinator</a>
</nav>
<h1>Coordinator Table</h1> 
<a href="qr.php?id=<?php echo $id[0];?>" class="btn btn-secondary pull-right" target="_blank">Browse QR>></a><br><br>
<?php }else if($data['pos'] == 'Coordinator'){?>
<nav>
    <a href="position.php" class="a">Cluster Precint Leader</a>  << 
    <a href="position.php?id=<?php echo $id[1]; ?> " class="a">Coordinator</a> <<
    <a href="position.php?id=<?php echo $id[0]. "/".$id[1]; ?> " class="a">Leader</a>
</nav>
  <h1> Leader Table</h1>
  <a href="qr.php" class="btn btn-secondary pull-right" target="_blank">Browse QR>></a><br><br>
<?php }else{?>
<nav>
    <a href="position.php" class="a">Cluster Precint Leader</a>  
</nav>
  <h1> Cluster Leader Precint Table</h1>
  <a href="qr.php" class="btn btn-secondary pull-right" target="_blank">Browse QR>></a><br><br>
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
        <th>Reason</th>
      </tr>
    </thead>
    <tbody>
<?php


if($data['pos'] == 'Cluster Precint Leader' || $data['pos']= 'Cluster Precinct Leader/Coordinator'){
    $sql = "SELECT * FROM election where (pos='Coordinator' || pos='Leader' || pos='Member') && cluster_id='".$id[0]."' ";
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
                        echo "<td><span class='badge bg-success'><a href='update.php?id=".$row["id"]."' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                        
                    }
                    echo "<td>
                        <a href='position.php?id=" . $row["id"]."/".$id[0]. "' id=". $row["id"].">View Leaders</a>
                        <a href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                        </td>
                        <td>".$row["remarks"]."</td>
                        </tr>";
            }else{  
                echo "<tr><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
                    <td>".$row["brgy"].", ".$row["prk"] ."</td>
                    <td>".$row["pn"]."</td>
                    <td>".$row["pos"]."</td>";
                    if($row["status"]!="voted"){
                        echo "<td><span class='badge bg-danger'><a href='update.php?id=".$row["id"]."' class='btn badge bg-danger a'>".$row["status"]."</a></span></td>";
                    }else{
                        echo "<td><span class='badge bg-success'><a href='update.php?id=".$row["id"]."' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                        
                    }
                    echo "<td>
                        <a href='position.php?id=" . $row["id"]."/".$id[0]. "' id=". $row["id"].">View Leaders</a>
                        <a href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                        </td>
                        <td>".$row["remarks"]."</td>
                        </tr>";
            }
        }
    } else {
      echo "0 results";
    }

}else if($data['pos'] == 'Coordinator'){
    echo"<script>alert('".$id[0] . " " . $id[1]."')</script>";
}else if($data['pos'] == 'Leader'){
    echo"<script>alert('".$id[0] . " " . $id[1]."')</script>";
}else{
    $sql = "SELECT * FROM election where pos='Cluster Precint Leader' OR pos='Cluster Precinct Leader/Coordinator'";
    $result = $conn->query($sql);
    
    
    if ($result->num_rows > 0) {
     
      while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
        <td>".$row["brgy"].", ".$row["prk"] ."</td>
        <td>".$row["pn"]."</td>
        <td>".$row["pos"]."</td>";
        if($row["status"]!="voted"){
            echo "<td><span class='badge bg-danger'><a href='update.php?id=".$row["id"]."' class='btn badge bg-danger a'>".$row["status"]."</a></span></td>";
        }else{
            echo "<td><span class='badge bg-success'><a href='update.php?id=".$row["id"]."' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
            
        }
     echo "<td>
         <a href='position.php?id=" . $row["id"]."' id=". $row["id"].">View Coordinators</a>
         <a href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
         </td>
        <td></td>
        </tr>";
      }
      
    } else {
      echo "0 results";
    }
}

$conn->close();
?>

    
    </tbody>
</table>  
<button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" >
      Add Cluster leader
</button><br><br>
</div>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="add.php?id=<?php echo $ids;?>" method="POST">
				<div class="modal-content">
					<div class="modal-body">
						<div class="col-md-12">
							<div class="form-group">
								<label>Name</label>
								<input type="text" name="name" class="form-control" required/>
							</div>
							<div class="form-group">
								<label>Barangay</label>
								<input type="text" name="brgy" class="form-control" required/>
							</div>
							<div class="form-group">
								<label>Purok</label>
								<input type="text" name="prk" class="form-control" required/>
							</div>
							<div class="form-group">
							    <label>Standing</label>
							    <select class="select form-control" name="standing">
                                    <option value=""></option>
                                    <option value="PWD">PWD</option>
                                    <option value="Senior Citizen">Senior Citizen</option>
                                    <option value="PWD & Senior Citizen">PWD & Senior Citizen</option>
                                </select>
							</div>
							<div class="form-group">
							    <label>Presinc #</label>
							    <select class="select form-control" name="preno">
                                    <option value="0022A">0022A</option>
                                    <option value="0022B">0022B</option>
                                    <option value="0022C">0022C</option>
                                </select>
							</div>
							
						</div>
					</div>
					<div style="clear:both;"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
						<button name="save" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
<br><br>
<div class="row">
<?php include'incl/footer.php';?>
</div>
</body>
</html>