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

$brgy = $_GET['brgy'];
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
@page  
{ 
    size:8.5in 13in;
    /* this affects the margin in the printer settings */ 
    margin: 0; 
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
    
<div class="container-fluid mt-6 d-print-inline-flex table-responsive" id="printablediv">
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
    $sql = "SELECT * FROM election where
    brgy = '$brgy' AND pos like 'Member%' order by name";
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
<?php include 'incl/sbin.php';?>
    <?php
    }
    } else {
      echo "0 results";
    }
    
    
    //leader print

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