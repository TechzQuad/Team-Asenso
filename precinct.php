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


<link href="incl/swa/dist/sweetalert.css" rel="stylesheet" type="text/css">
<script src="incl/swa/dist/sweetalert.min.js" type="text/javascript"></script>

</head>

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
        <h5 style="margin-bottom:20px">Supporters Status Per Precinct </h5>
        <table class="display" style="width:100%" id="kram">
            <thead>
              <tr>
                <th>Precinct</th>
                <th>Voted</th>
                <th>Not Voted</th>
                <th>Total Voters</th>
              </tr>
            </thead>
            <tbody>
                <?php
                
                // $sql101 = "SELECT pn, SUM(CASE WHEN status = 'voted' THEN 1 ELSE 0 END) as voted, SUM(CASE WHEN status = 'not voted' THEN 1 ELSE 0 END) as not from election where pos!='' group by pn";
                // $result101 = $conn->query($sql101);
                
                // if ($result101->num_rows > 0) {
                //     while($row101 = $result101->fetch_assoc()) {
                 $sql = "SELECT pn, SUM(CASE WHEN status = 'voted' THEN 1 ELSE 0 END) as voted, SUM(CASE WHEN status = 'not voted' THEN 1 ELSE 0 END) as notv from election where pos!='' group by pn";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        
                        $t = $row["voted"] + $row["notv"]; 
                        $tt += $t;
                        $t1 += $row["voted"];
                        $t2+= $row["notv"];
                        
                        
                        echo "<tr style=''><td>".$row["pn"]."</td>
                        <td>".$row["voted"]."</td>
                        <td>".$row["notv"]."</td>
                        <td>$t</td></tr>";
                                          
                    }
                    
                    ?>
                    <tr>
            			<td style="font-weight: bold;">Total</td>
            			<td style="font-weight: bold"><?php echo $t1;?></td>
            			<td style="font-weight: bold"><?php echo $t2;?></td>
            			<td style="font-weight: bold"><?php echo $tt;?></td>
            		</tr>
        		    
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