<?php
include('incl/auth.php');
require_once 'incl/config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql_brgy = "SELECT brgy,count(id) as no from election WHERE pos!='' GROUP BY brgy";
$result_brgy = mysqli_query($conn, $sql_brgy);

$sql_st = "SELECT brgy,
sum(CASE WHEN status = 'voted' THEN 1 ELSE 0 END) AS vot,
sum(CASE WHEN status = 'not voted' THEN 1 ELSE 0 END) AS novot FROM election WHERE pos!='' GROUP BY brgy";
$result_st = mysqli_query($conn, $sql_st);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include'incl/links.php';  
?>


</head>
<link href="incl/swa/dist/sweetalert.css" rel="stylesheet" type="text/css">
<script src="incl/swa/dist/sweetalert.min.js" type="text/javascript"></script>
<body class="body-bc">
    <?php
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
				</script>";}?>
<?php include'incl/nav.php';?>
<div class="container mt-3" style="background-color:#ffffff;"><br><div id='live_cong'>

<div class="row">

    <div class="col-sm-12 table-responsive">
        <h5 style="margin-bottom:20px">Supporters Status Per Barangay </h5>
        <table class="display" id="kram" style="width:100%">
            <thead>
              <tr>
                <th>Name</th>
                <th>Voted</th>
                <th>Not Voted</th>
                <th>Total Voters</th>
              </tr>
            </thead>
            <tbody>
                <?php
    $sql = "SELECT brgy,count(id) as t, 
    sum(CASE WHEN status = 'voted' && pos!='' THEN 1 ELSE 0 END) AS sv,
    sum(CASE WHEN status = 'not voted' && pos!='' THEN 1 ELSE 0 END) AS snv
    FROM election GROUP BY brgy";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        $vt=0;$nvt=0;$tvt=0;
    		while($row = $result->fetch_assoc()) {
    		$svt += $row['sv'];
    		$snvt += $row['snv'];
    		$vt += $row['v'];
    		$nvt += $row['nv'];
    		$tt = $row['sv'] + $row['snv'] + $row['v'] + $row['nv'];
    		$tvt += $tt;
?>  
        <tr>
			<td><?=$row['brgy'];?></td>
			<td style=""><?=$row['sv'];?></td>
			<td style=""><?=$row['snv'];?></td>
			<td style=""><?=$tt;?></td>
		</tr>
	
<?php
         }?>
         	<tr>
			<td style="font-weight: bold;">Total</td>
			<td style="font-weight: bold;"><?php echo $svt;?></td>
			<td style="font-weight: bold;"><?php echo $snvt;?></td>
			<td style="font-weight: bold;"><?php echo $tvt;?></td>
		</tr>
    <?php	}else {
    		echo "0 results";
    	}

  
?>  
       
            </tbody>
        </table>
    </div>
</div>
</div>
<br>
</div><?php include'incl/footer.php';?>
</body>
</html>