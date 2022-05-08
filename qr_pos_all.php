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

$id = $_GET['pos'];
$sql1 = "SELECT *, SUBSTRING_INDEX(pos, ' ', 1) as co, SUBSTRING_INDEX(pos, ' & ', 2) as lead FROM election WHERE id='".$id."'";
$qry = mysqli_query($conn,$sql1);
$data = mysqli_fetch_array($qry);
$cluster_id=$data['cluster_id'];
$count=count($id);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <?php include'incl/links.php';?>
</head>
<style>
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
</style>
<script language="javascript" type="text/javascript">
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML = 
              "<html><head><title></title></head><body>" + 
              divElements + "</body>";
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;
             
        };
            </script>
<body>
    
<div class="container-fluid mt-3 d-print-inline-flex table-responsive" id="printablediv">
    <center><button id="PrintButton" class="bi bi-printer btn-success" onclick="PrintPage()">Print</button></center><br>
  <?php if($data['pos'] == 'Cluster Precint Leader'){?>
<!--  <h4>COORDINATOR QR CODE <a href="#" type="button" class="btn btn-success btn-lg a"  onclick="javascript:printDiv('printablediv')"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer a" viewBox="0 0 16 16">-->
<!--  <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>-->
<!--  <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>-->
<!--</svg></a></h4>-->
  <?php }else{ ?>
<!--  <h4>CLUSTER PRECINT LEADER QR CODE <a href="#" type="button" class="btn btn-success btn-lg"  onclick="javascript:printDiv('printablediv')"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">-->
<!--  <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>-->
<!--  <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>-->
<!--</svg></a></h4>-->
  <?php }?>
    <div class="row">
<?php 
//leader Print

if($data['co'] == 'Coordinator' || $data['lead'] == 'Coordinator'){    
    $sql = "SELECT *, SUBSTRING_INDEX(pos, ' ', 1) as l FROM election where coordinator_id='$id' && pos!='Cluster Precint Leader' && pos not like '%Coordinator%' order by name";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    //data to be stored in qr
    
    $text = "https://onetechzquad.tech/update_status.php?id=". $row['id']."&&name=".$row['name'];
      
    //file path
    $file = "img/". $row['id'];
      
    //other parameter
    $ecc = 'H';
    $pixel_size = 1;
    $frame_size = 1;
      
    // Generates QR Code and Save as PNG
    QRcode::png($text, $file, $ecc, $pixel_size, $frame_size);
    // Displaying the stored QR code if you want
    
    ?>
   <div class="col-sm-4" style="margin-bottom:20px">
    <div class="card mb-3 b"  style="max-width:317px;max-height:202px; border:2px solid #000000;margin-left:10px;border-radius:5px; text-align:center;">
        
         
        <div class="col-mb-2">
            <center>
            <p style="text-align:center; background:white;background-color:#C10000;color:#ffffff"><strong>Team Asenso!</strong></p>
          <img src="<?php echo $file;?>" class="img img-thumbnail img-rounded img-circle" style="padding:5px;width:100px">
          </center>
        </div>
        <div class="col-mb-4">
          <div class="card-body">
            <h5 class="card-title" style="text-align:center; font-size: 14px;background-color:#C10000;padding:2px;border-radius:20px;color:#ffffff"><?php echo $row['name'];?></h5>
          </div>
        </div>
      </div>
     </div>  
            
        
    <?php
    }
    } else {
      echo "0 results";
    }
    
    
    //Member Print QR
}else if($data['co'] == 'Leader' || $data['lead'] == 'Leader' || $data['co'] == 'leader' || $data['lead'] == 'leader'){
    $sql = "SELECT * FROM election where pos!='Cluster Precint Leader' && pos!='Coordinator' && pos not like '%Leader%' && pos!='leader' && leader_id='$id' order by name";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    //data to be stored in qr
    
    $text = "https://onetechzquad.tech/update_status.php?id=". $row['id']."&&name=".$row['name'];
      
    //file path
    $file = "img/". $row['id'];
      
    //other parameter
    $ecc = 'H';
    $pixel_size = 1;
    $frame_size = 1;
      
    // Generates QR Code and Save as PNG
    QRcode::png($text, $file, $ecc, $pixel_size, $frame_size);
    // Displaying the stored QR code if you want
    
    ?>
   <div class="col-sm-4" style="margin-bottom:20px">
    <div class="card mb-3 b"  style="max-width:317px;max-height:202px; border:2px solid #000000;margin-left:10px;border-radius:5px; text-align:center;">
        
         
        <div class="col-mb-2">
            <center>
            <p style="text-align:center; background:white;background-color:#C10000;color:#ffffff"><strong>Team Asenso!</strong></p>
          <img src="<?php echo $file;?>" class="img img-thumbnail img-rounded img-circle" style="padding:5px;width:100px">
          </center>
        </div>
        <div class="col-mb-4">
          <div class="card-body">
            <h5 class="card-title" style="text-align:center; font-size: 14px;background-color:#C10000;padding:2px;border-radius:20px;color:#ffffff"><?php echo $row['name'];?></h5>
          </div>
        </div>
      </div>
     </div>  
            
        
    <?php
    }
    } else {
      echo "0 results";
    }
    
    
    //leader print
   //cluster leader Print
}
$conn->close();

?>
  
<script type="text/javascript">
	function PrintPage() {
		window.print();
	}
</script>  
</div>
</div>
<br><br>
<div class="row">
</div>
</body>
</html>