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
$sql1 = "SELECT *, SUBSTRING_INDEX(pos, ' ', 1) as co, SUBSTRING_INDEX(pos, ' & ', 2) as lead FROM election WHERE id='".$id[0]."'";
$qry = mysqli_query($conn,$sql1);
$data = mysqli_fetch_array($qry);
$cluster_id=$data['cluster_id'];
$count=count($id);
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
    
<h1>Set Election Date</h1>  
 <table id="voters" class="display" style="width:100%">
     
        <button  type='submit' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#staticBackdrop' >Update </button><br><br>
    <thead>
      <tr>
        <th style='text-align: center;font-weight: bold; font-size: 20px;'>Date of Election</th>
      </tr>
    </thead>
    <tbody>
<?php

//coordinator table


//cluster leader precint table    

    $sql = "SELECT * FROM election_date";
    $result = $conn->query($sql);
    
    
    if ($result->num_rows > 0) {
     
      while($row = $result->fetch_assoc()) {
        echo "</tr>
        <td style='text-align: center;font-weight: bold; font-size: 20px; backgound:gray;'>".$row["date"]."</td>
        </tr>";
      }
      
    } else {
      echo "0 results";
    }


$conn->close();
?>
    
    
    </tbody>
</table> 
</div>
<!--<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">-->
<!--		<div class="modal-dialog" role="document">-->
<!--				<div class="modal-content">-->
<!--				    <form method="POST" action"date_update.php">-->
<!--					<div class="modal-body">-->
					    
<!--						<input type="date" class="form-control"  placeholder="dd-mm-yyyy" value=""-->
<!--        min="1997-01-01" max="2030-12-31">-->
                        
<!--					</div>-->
<!--					<div style="clear:both;"></div>-->
<!--					<div class="modal-footer">-->
<!--						<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>-->
<!--						<button name="update_date" id="save" class="btn btn-primary">Submit</button>-->
<!--					</div>-->
<!--					</form>-->
<!--				</div>-->
<!--		</div>-->
<!--	</div>-->


<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="date_update.php" method="POST">
				<div class="modal-content co" >
					<div class="modal-body">
						<input type="date" class="form-control" name="date"  placeholder="dd-mm-yyyy" value="" min="1997-01-01" max="2030-12-31">
                        
						
					</div>
					<div style="clear:both;"></div>
					<div class="modal-footer">
					    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
						<button name="update_date" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>






<br><br>
<div class="row">
<?php include'incl/footer.php';?>
</div>

<script>
</script>


</body>
</html>