<?php 
include'incl/auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include'incl/links.php';?>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link href="incl/swa/dist/sweetalert.css" rel="stylesheet" type="text/css">
<script src="incl/swa/dist/sweetalert.min.js" type="text/javascript"></script> 
   <style>
       .card {
          border: 1px solid;
          padding: 10px;
       }
       .btnhover:hover{
          box-shadow:0 0 0 10px hsl(0, 0%, 80%), 0 0 0 15px hsl(0, 0%, 90%);
       }
       .co {
           text-align: center;
           font-weight:bold;
           
       }
       .ihover{
           text-align: center;
       }
       .ihover:hover{
           box-shadow:0 0 0 5px hsl(0, 0%, 50%), 0 0 0 10px hsl(0, 0%, 70%);
       }
    .b {
       
    }
    h5{
        font-family:Arial Black;
        background: white;
    }
@media print {
    #PrintButton {
        display :  none;
    }
    .page-break{
        page-break-after: always;
    }

}
@page  
{ 
    size:8.5in 13in;
    /* this affects the margin in the printer settings */ 
    margin: 0mm 0 0 0mm;  
} 
</style>
</head>
<body>

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



$id=$_GET['id'];

$sql = "SELECT *,  SUBSTRING_INDEX(pos, ' & ', 1) as position, SUBSTRING_INDEX(pos, ' ', 1) as position_1 FROM election where id='$id'";
$result = $conn->query($sql);
$data =  $result->fetch_assoc();
$cluster_id=$data['cluster_id'];
$co_id=$data['coordinator_id'];
$leader_id=$data['leader_id'];

$query = "SELECT DISTINCT pn FROM election";
        $result = mysqli_query($conn, $query);
         
        

if($data['position'] == 'Coordinator' || $data['pos']=='Coordinator' || $data['position_1'] == 'Coordinator'){
    $sql1 = "SELECT * FROM election where id='$cluster_id'";
    $result1 = $conn->query($sql1);
    $data1 =  $result1->fetch_assoc();
}else if($data['position'] == 'Leader' || $data['pos']=='Leader' || $data['position_1'] == 'Leader' ){
    $sql1 = "SELECT * FROM election where id='$co_id'";
    $result1 = $conn->query($sql1);
    $data1 =  $result1->fetch_assoc();
}else if($data['pos']=='Member'){
    $sql1 = "SELECT * FROM election where id='$leader_id'";
    $result1 = $conn->query($sql1);
    $data1 =  $result1->fetch_assoc();
}else{
    $sql1 = "SELECT * FROM election where id='$cluster_id'";
    $result1 = $conn->query($sql1);
    $data1 =  $result1->fetch_assoc();
}


//data to be stored in qr
$text = "https://onetechzquad.tech/update_status.php?id=". $data['id'] . "&&name=" . $data['name'];
  
//file path
$file = "img/". $data['id'];
  
//other parameters
$ecc = 'H';
$pixel_size = 2;
$frame_size = 2;
  
// Generates QR Code and Save as PNG
QRcode::png($text, $file, $ecc, $pixel_size, $frame_size);
 
// Displaying the stored QR code if you want

include'incl/nav.php';
?>

<!--<div class="container-fluid mt-3">-->
<!--  <h1>Profile</h1>-->
<!--  <br>-->
<!--    <div class="row">-->
<!--        <div class="col-sm-4">Name: <?php echo $data['name'];?></div>-->
<!--        <div class="col-sm-4">Address: <?php echo $data['brgy'];?></div>-->
<!--        <div class="col-sm-4">Position: <?php echo $data['pos'];?></div>-->
<!--        <div class="col-sm-4">QR Code: <?php echo "<div><img src='".$file."'></div>";?></div>-->
<!--        <div class="col-sm-4">-->
<!--            <label>Name of Luster Leader:</label>-->
<!--            <input list="output" name="name" class="no-outline" id="search" placeholder="<?php echo $data1['name']; ?> ">-->
<!--            <datalist id="output" >-->
                
<!--            </datalist>-->
            
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<br>
<center>
<div class="card" style="width: 30rem; margin-top: 20px; text-shadow: 2px 2px 5px red;">
  <center><?php echo "<div><img src='".$file."'></div>";?></center>
  <div class="card-body">
    <h5 class="card-title">QR Code</h5>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">Name: <?php echo $data['name'];?></li>
    <li class="list-group-item">Address: <?php echo $data['brgy']. ", ". $data['prk'] ;?></li>
    <li class="list-group-item">Position: <?php echo $data['pos'];?></li>
    <li class="list-group-item">Presinc: <?php echo $data['pn'];?></li>
    <li class="list-group-item"><?php $e = explode(" & ", $data1['pos']); echo  $e[0]." Name: ".$data1['name']; ?></li>
  </ul>
  <div class="card-body">
    <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalPrint" >Print ID</button>
    <button type="submit" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalPrintSB">Sample Ballot</button>
    <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" >Update</button>
    <button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDelete" >Delete</button>
  </div>
</div>
</center>


<!-----Print Modal------>
<div class="modal fade" id="modalPrint" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="print_id.php?id=<?php echo $id;?>" method="POST">
				<div class="modal-content co" >
				    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><?php echo $data['name'];?> ID</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
            		<div class="modal-body">
					    <div class="col-sm-12" style="margin-bottom:20px" style="align:center;">
                            <div class="card mb-3 b"  style="max-width:317px;max-height:202px; border:2px solid #000000;margin-left:10px;border-radius:5px; text-align:center;">
                                <div class="col-mb-2">
                                    <center>
                                        <p style="text-align:center; background:white;background-color:#C10000;color:#ffffff"><strong>Team Asenso!</strong></p>
                                        <img src="<?php echo $file;?>" class="img img-thumbnail img-rounded img-circle" style="padding:5px;width:100px">
                                    </center>
                                </div>
                                <div class="col-mb-4">
                                  <div class="card-body">
                                    <h5 class="card-title" style="text-align:center; font-size: 14px;background-color:#C10000;padding:2px;border-radius:20px;color:#ffffff"><?php echo $data['name'];?></h5>
                                  </div>
                                </div>
                              </div>
                             </div> 
					</div>
					<div style="clear:both;"></div>
					<div class="modal-footer">
					    
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
						<button name="save_coor" class="btn btn-primary">Print</button>
					</div>
				</div>
			</form>
		</div>
	</div>

<!-----end of Print Modal---->


<!--print sample ballot modal-->
<div class="modal fade" id="modalPrintSB" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="ind_sb.php?id=<?php echo $id;?>" method="POST">
				<div class="modal-content co" >
				    <div class="modal-header">
                        <p class="modal-title" id="staticBackdropLabel"><?php echo $data['name'];?> Sample Ballot</p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
            		<div class="modal-body">
					    <div class="" style="margin-bottom:11px">
                            <div class="card mb-6 b"  style="max-width:376px; border:2px solid #000000;margin-left:10px;border-radius:5px; text-align:center;">
                                
                                 
                                <div class="col-mb-2">
                                    <center>
                                    <p style="text-align:center; background:white;background-color:#C10000;color:#ffffff"><strong>SAMPLE BALLOT</strong></p>
                                    <img src="<?php echo $file;?>" class="img img-thumbnail img-rounded img-circle" style="width:100px; height: 100px; float:center;">
                                    <p style="text-align:center; font-size:15px;"><?php echo $data['name'];?></p><hr>
                                    <p style="font-size:10px; text-align:center;">MAY 9, 2022 NATIONAL AND LOCAL ELECTIONS</p>
                                    
                                    <img src="sb.png" class="img" width="355px" height="740.5">
                                  </center>
                                </div>
                            </div>
                        </div>     
					</div>
					<div style="clear:both;"></div>
					<div class="modal-footer">
					    
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
						<button name="save_coor" class="btn btn-primary">Print</button>
					</div>
				</div>
			</form>
		</div>
	</div>

<!-----end of Print Modal---->



<!--end print sample ballot modal-->




<!-----Delete Modal------>
<div class="modal fade" id="modalDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="delete.php?id=<?php echo $id;?>" method="POST">
				<div class="modal-content co" >
				    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
            		<div class="modal-body">
						<div class="col-md-12">
						    <h1><label>Are you sure You want to Delete <?php echo $data['name'];?>?</label></h1>
						    <div class="form-group">
								<label>Reason: </label><br>
								<textarea type="text" name="remarks" class="form-control ihover"></textarea>
							</div>
						</div>
					</div>
					<div style="clear:both;"></div>
					<div class="modal-footer">
					    
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
						<button name="save_coor" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>

<!-----end of delete Modal---->
<!----- update modal----->

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="update_info.php?id=<?php echo $id;?>" method="POST">
				<div class="modal-content co" >
					<div class="modal-body">
						<div class="col-md-12">
						    <div class="form-group">
								<input hidden type="text" name="id" id="my_id" class="form-control" value="<?php echo $data['id'];?>"/>
							</div>
							<div class="form-group">
								<label>Name</label>
								<input type="text" name="name" class="form-control ihover" value="<?php echo $data['name'];?>"/>
							</div>
							<div class="form-group">
								<label>Barangay</label>
								<input type="text" name="brgy" class="form-control ihover" value="<?php echo $data['brgy'];?>"/>
							</div>
							
							<div class="form-group">
								<label>Purok</label>
								<input type="text" name="prk" class="form-control ihover" value="<?php echo $data['prk'];?>"/>
							</div>
							<div class="form-group">
							    <label>Position</label>
							    <select class="select form-control ihover" name="pos" onchange="showPosition(this.value)">
							        <option value="<?php echo $data['pos'];?>"><?php echo $data['pos'];?></option>
                                    <option value="Cluster Precint Leader">Cluster Precint Leader</option>
                                    <option value="Cluster Precint Leader.Coordinator">Cluster Precint Leader & Coordinator</option>
                                    <option value="Cluster Precint Leader.Leader">Cluster Precint Leader & Leader</option>
                                    <option value="Cluster Precint Leader.Member">Cluster Precint Leader & Member</option>
                                    <option value="Coordinator">Coordinator</option>
                                    <option value="Coordinator.Leader">Coordinator & Leader</option>
                                    <option value="Coordinator.Member">Coordinator & Member</option>
                                    <option value="Leader">Leader</option>
                                    <option value="Leader.Member">Leader & Member</option>
                                    <option value="Member">Member</option>
                                </select>
							</div>
							
							<div class="form-group">
							    <label>Presinc #</label>
							    <select class="select form-control ihover" name="preno">
							        <option value="<?php echo $data['pn'];?>"><?php echo $data['pn'];?></option>
                                    <?php
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                echo "<option value='".$row['pn']."'>".$row['pn']."</option>";
                                            }
                                        }else {
                                        }
                                    ?>
                                </select>
							</div>
							<div class="form-group">
								
								<div id="output" class="form-group">...</div>
								
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
	
	
	
	<!------ end update modal------>




  <script type="text/javascript">
    // $(document).ready(function(){
    //   $("#search").keyup(function(){
    //       var query = $(this).val();
    //       if (query != "") {
    //         $.ajax({
    //           url: 'fetch.php?id=<?php echo $id;?>',
    //           method: 'POST',
    //           data: {query:query},
    //           success: function(data){
    //             $('#output').html(data);
    //             $('#output').css('display', 'block');
 
    //             $("#search").focusout(function(){
    //                 $('#output').css('display', 'none');
    //             });
    //             $("#search").focusin(function(){
    //                 $('#output').css('display', 'block');
    //             });
    //           }
    //         });
    //       } else {
    //       $('#output').css('display', 'none');
    //     }
    //   });
    // });
    
    function showPosition(str) {
        var xhttp;    
        if (str == "") {
            document.getElementById("output").innerHTML = "";
            return;
        }
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              document.getElementById("output").innerHTML = xhttp.responseText;
            }  
        };
        console.log(str);
        xhttp.open("GET", "get_position.php?pos="+str+"/"+<?php echo $id; ?>, true);
        xhttp.send();
    }
  </script>
<br><br>
<div class="row">
<?php include'incl/footer.php';?>
</div>
</body>
</html>