<?php
include('incl/auth.php');
require_once 'incl/config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql_brgy = "SELECT brgy,count(*) as no from election WHERE pos!='' GROUP BY brgy";
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
        <h5 style="margin-bottom:20px">Supporters Status Per Cluster Precinct Leader </h5>
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
                
                $sql101 = "SELECT * from election where pos like '%Cluster Precint Leader%'";
                $result101 = $conn->query($sql101);
                
                if ($result101->num_rows > 0) {
                    while($row101 = $result101->fetch_assoc()) {
                        
                        $sql11 = "SELECT name,count(id) as t, 
                        (SELECT count(id) from election where pos!='' && status = 'voted' && cluster_id='".$row101['id']." '  ) AS v,
                        (SELECT count(id) from election where pos!='' && status = 'not voted' && cluster_id='".$row101['id']."') AS nv
                            FROM election where id = '%".$row101['id']."%' ";
                            
                        $result11 = $conn->query($sql11);
                        
                        $data11 =  $result11->fetch_assoc();
                        $vt += $data11['v'];
                		$nvt += $data11['nv'];
                		$tvt = $vt + $nvt ;
                        $t = $data11["v"] + $data11["nv"];
                                echo "<tr style=''><td>".$row101["name"]."</td>
                                <td>".$data11["v"]."</td>
                                <td>".$data11["nv"]."</td>
                                <td>".$t."</td></tr>";
                                          
                    }
                    ?>
                    <tfooter>
                    <tr>
        			<td style="font-weight: bold;">XX--Total--XX</td>
        			<td style="font-weight: bold;"><?php echo $vt;?></td>
        			<td style="font-weight: bold;"><?php echo $nvt;?></td>
        			<td style="font-weight: bold;"><?php echo $tvt;?></td>
        			</tr>
        			</tfooter>
        		    
        		<?php
                }else {
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