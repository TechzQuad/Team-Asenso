<!DOCTYPE html>
<html lang="en">
<head>
  <?php include'incl/links.php';?>
</head>

<style type="text/css">
.pads{
    padding-top: 10px;
    
}

@media print {
    #PrintButton {
        display :  none;
    }
}
@page {
			size: auto;   /* auto is the initial value */
			margin: 0;  /* this affects the margin in the printer settings */
		}
</style>
<body>
    
<div class="container-fluid mt-3">
  <br>
  <h1>CLUSTER LEADER QR CODE</h1>
    <div class="row">
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
$id = $_GET['id'];
$sql = "SELECT * FROM voters where pos='COORDINATOR' && cluster_id=$id";
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
 echo $data['id'];
// Displaying the stored QR code if you want

?>


        <td><div class="pads col-sm-1"><?php echo "<div><img src='".$file."'></div>";?></div></td>
    
<?php
}
} else {
  echo "0 results";
}
$conn->close();

?>
</div>
</div>
<br><br>
<div class="row">
</div>
<center><button id="PrintButton" onclick="PrintPage()">Print</button></center>

<script type="text/javascript">
	function PrintPage() {
		window.print();
	}
	window.addEventListener('DOMContentLoaded', (event) => {
   		PrintPage()
		setTimeout(function(){ window.close() },750)
	});
</script>

</body>
</html>