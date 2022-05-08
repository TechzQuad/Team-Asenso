<!DOCTYPE html>
<html lang="en">
<head>
  <?php include'incl/links.php';?>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
   <style>
       .card {
          border: 1px solid;
          padding: 10px;
          box-shadow:0 0 0 10px hsl(0, 0%, 80%), 0 0 0 15px hsl(0, 0%, 90%);
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
       
   </style>
   
</head>
<body>

<?php 
include'incl/nav.php';
include 'incl/config.php';
//load the ar library
include 'phpqrcode/qrlib.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$id=$_GET['id'];

$sql = "SELECT * FROM election where id='$id'";
$result = $conn->query($sql);
$data =  $result->fetch_assoc();
$cluster_id=$data['cluster_id'];
$co_id=$data['coordinator_id'];
$leader_id=$data['leader_id'];
$sql1 = "SELECT * FROM election where id='$cluster_id' || id='$co_id' || id='$leader_id'";
$result1 = $conn->query($sql1);
$data1 =  $result1->fetch_assoc();


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


<center>
<div class="card" style="width: 18rem; margin-top: 20px; text-shadow: 2px 2px 5px red;">
  <center><?php echo "<div><img src='".$file."'></div>";?></center>
  <div class="card-body">
    <h5 class="card-title">QR Code</h5>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">Name: <?php echo $data['name'];?></li>
    <li class="list-group-item">Address: <?php echo $data['brgy']. ", ". $data['prk'] ;?></li>
    <li class="list-group-item">Position: <?php echo $data['pos'];?></li>
    <li class="list-group-item">Presinc: <?php echo $data['pn'];?></li>
    <li class="list-group-item"><?php echo  $data1['pos'].": ".$data1['name']; ?></li>
  </ul>
</div>
</center>

<br><br>
<div class="row">
<?php include'incl/footer.php';?>
</div>
</body>
</html>