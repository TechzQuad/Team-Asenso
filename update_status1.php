
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include'incl/links.php';?>
    <link href="incl/swa/dist/sweetalert.css" rel="stylesheet" type="text/css">
    <script src="incl/swa/dist/sweetalert.min.js" type="text/javascript"></script>  
  <link rel="stylesheet" href="/css/bootstrap-print.min.css" media="print">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-print-css/css/bootstrap-print.min.css" media="print">
  <style>.btn{box-shadow:4px 4px 1px #e0ebeb}</style>
</head>
<body>

<?php 
include 'incl/config.php';
include 'incl/auth.php';
// //load the ar library
// include 'phpqrcode/qrlib.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$id=$_GET['id'];
// date_default_timezone_set('Asia/Manila');
// $date=date('Y-m-d h:i');
// $date1=date('Y-m-d');

// $sql_date = "SELECT * FROM election_date";
// $result_date = $conn->query($sql_date);
// $data_date =  $result_date->fetch_assoc();

// $date2 =$data_date['date'];

$sql = "SELECT * FROM election where id='$id'";
$result = $conn->query($sql);
$data =  $result->fetch_assoc();

$sqlpos = "SELECT * FROM election where id='$id' AND pos LIKE '%Member%'";
$resultpos = $conn->query($sqlpos);
$datapos =  $resultpos->fetch_assoc();
?>
<div class="container-fluid mt-3">
    <center>
    <div style="border: 3px solid #f0f5f5;padding:5px">
        <h1><label>Name :</label>&nbsp;<strong><?php echo $data['name']; ?></strong></h1>
        <h1><label>Precinct Number :</label>&nbsp;<strong><?php echo $data['pn']; ?></strong></h1>
        <h1><label>Position :</label>&nbsp;<strong><?php echo $data['pos']; ?></strong></h1>
     </div>
      <br><br>
     <form method="post" role="form" action="updates_status.php?id=<?php echo $id?>">
      <button class="btn btn-danger btn-sm" style="padding-top:27px;padding-bottom:27px;padding-right:17px;padding-left:17px;background-color:#C10000" name="vote"><span class="spinner-grow spinner-grow-sm"></span>&nbsp;Cast Vote</button>&nbsp;
      <button hidden class="btn btn-success btn-sm" style="padding-top:27px;padding-bottom:27px;padding-right:10px;padding-left:10px;" name="att" <?php $ed=date('Y-m-d'); if($ed=='2022-05-09') {echo 'hidden';}?>>Add Attendance</button>&nbsp;
       <a href="ind_position.php?id=<?php echo $data['id'];?>" class="btn btn-sm" style="padding-top:27px;padding-bottom:27px;padding-left:20px;padding-right:20px;background-color:#008080;color:#ffffff" <?php if($datapos['pos']==true){echo'hidden';}?>><svg xmlns="http://www.w3.org/2000/svg" width="20" height="19" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
  <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
  <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
</svg></a></form>
<img class="img img-thumbnail" src="pics/sc.png" style="margin-top:50px"/>
    </center>  

</div>
<script language="javascript" type="text/javascript">
    // setTimeout (window.close, 10000);
    // function openWindow() {
    //   newWindow = window.open();
    // }
</script>

<br><br>
<div class="row">
<?php include'incl/footer.php';?>
</div>
</body>
</html>