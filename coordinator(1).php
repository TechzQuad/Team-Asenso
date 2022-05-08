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
    
<?php 
include'incl/nav.php';
require_once 'incl/config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$id = $_GET['id'];




// $sql1 = "SELECT * FROM voters WHERE pos='COORDINATOR' && name='Kim Banasing'";
// $qry = mysqli_query($conn,$sql1);
// $data = mysqli_fetch_array($qry);
// $exp = explode(',', $data['cluster_id']);
// $count = COUNT($exp);
// $loop = 0;
// for($loop; $loop<$count; $loop++){

     

// }




?>

<div class="container mt-3">
  <h1>Coordinators Table</h1><a href="printco.php?id=<?php echo $id?>" class="btn btn-secondary pull-right" target="_blank">Browse QR>></a><br><br>
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
    <tbody id="coor">
    </tbody>
  </table>  

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">
              Add Cluster leader
     </button><br><br>
</div>
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="add.php?id=<?php echo $id;?>" method="POST">
				<div class="modal-content">
					<div class="modal-body">
						<div class="col-md-12">
							<div class="form-group">
								<label>Name</label>
								<input type="text" name="name" class="form-control"/>
							</div>
							<div class="form-group">
								<label>Address</label>
								<input type="text" name="address" class="form-control"/>
							</div>
							<div class="form-group">
							    <label>Presinc #</label>
							    <select class="select form-control" name="preno">
                                    <option value="0022A">0022A</option>
                                    <option value="0022B">0022B</option>
                                    <option value="0022C">0022C</option>
                                    <option value="4">Four</option>
                                    <option value="5">Five</option>
                                    <option value="6">Six</option>
                                    <option value="7">Seven</option>
                                    <option value="8">Eight</option>
                                    <option value="9">Nine</option>
                                    <option value="10">Ten</option>
                                </select>
							</div>
							<div class="form-group">
							    <label>Standing</label>
							    <select class="select form-control" name="stand">
                                    <option value="">NONE</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                </select>
							</div>
						</div>
					</div>
					<div style="clear:both;"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="#modal"> Close</button>
						<button name="save_coor"  class="btn btn-primary">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>	
<?php
?>

<script>
	$.ajax({
		url: "fetch_coor.php?id=<?php echo $id;?>",
		type: "POST",
		cache: false,
		success: function(data){
			$('#coor').html(data); 
		}
	});
</script>    





<br><br>
<div class="row">
<?php include'incl/footer.php';?>
</div>
</body>

</html>