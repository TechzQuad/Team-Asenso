<?php include('incl/auth.php');?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include'incl/links.php';?>
<style>
#voters {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#voters td, #voters th {
  border: 1px solid #ddd;
  padding: 8px;
}

#voters tr:nth-child(even){background-color: #f2f2f2;}

#voters tr:hover {background-color: #ddd;}

#voters th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
    
</style>
 
</head>
<body>
<?php include'incl/nav.php';?>

<div class="container mt-3"> 
  <h1>Cluster Precint Leaders Reports</h1><br><br>
  <a href="print_report.php" class="btn btn-secondary pull-right" target="_blank">Print Report >></a><br><br>
  <div style="overflow-x:auto;">
 <table id="voters" class="display" style="width:100%">
    <thead>
      <tr>
        <th rowspan="2">Name</th>
        <th colspan="2">Coordinator #</th>
        <th colspan="2">Leader #</th>
        <th colspan="2">Member #</th>
        <th rowspan="2">Total</th>
      </tr>
    </thead>
    <tbody>
       <tr><th></th><th>Voted</th><th>Not Voted</th><th>Voted</th><th>Not Voted</th><th>Voted</th><th>Not Voted</th><th></th></tr>
       
<?php
require_once 'incl/config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql1 = "SELECT * from election where pos like '%Cluster Precint Leader%' order by name ASC";
$result1 = $conn->query($sql1);

if ($result1->num_rows > 0) {
     while($row1 = $result1->fetch_assoc()) {
        $sql = "SELECT name, (SELECT count(*) from election where (pos like '%Coordinator%' || pos like '%Leader%' || pos like '%Member%' ) and cluster_id='".$row1['id']."') as total,
        (SELECT count(*) from election where status='not voted' and pos like '%Coordinator%' and cluster_id='".$row1['id']."') as cnv,
        (SELECT count(*) from election where status='voted' and pos like '%Coordinator%' and cluster_id='".$row1['id']."' and pos != 'Cluster Precint Leader') as cv,
        (SELECT count(*) from election where status='not voted' and pos like '%Leader%' and cluster_id='".$row1['id']."' and pos != 'Cluster Precint Leader') as lnv,
        (SELECT count(*) from election where status='voted' and pos like '%Leader%' and cluster_id='".$row1['id']."' and pos  != 'Cluster Precint Leader') as lv,
        (SELECT count(*) from election where status='not voted' and pos like '%Member%' and cluster_id='".$row1['id']."' and pos != 'Cluster Precint Leader') as mnv,
        (SELECT count(*) from election where status='voted' and pos like '%Member%' and cluster_id='".$row1['id']."' and pos != 'Cluster Precint Leader') as mv
        FROM election where id='".$row1['id']."'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
              $tcnv += $row['cnv'];
              $tcv += $row['cv'];
              $tlnv += $row['lnv'];
              $tlv += $row['lv'];
              $tmv += $row['mv'];
              $tmnv += $row['mnv'];
              $total = $tmnv + $tmv + $tlv + $tlnv + $tcv + $tcnv;
            echo "<tr><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'></span></td>
            <td>".$row["cv"]."</td>
            <td>".$row["cnv"]."</td>
            <td>".$row["lv"]."</td>
            <td>".$row["lnv"]."</td>
            <td>".$row["mv"]."</td>
            <td>".$row["mnv"]."</td>
            <td>".$row["total"]."</td>
           
            
            ";
          
    }
  
} else {
  echo "0 results";
}



$conn->close();
?>
 <tfoot>
    <tr>
      <td><b>Total</b></td>
      <td><b><?php echo $tcv; ?></b></td>
      <td><b><?php echo $tcnv; ?></b></td>
      <td><b><?php echo $tlv; ?></b></td>
      <td><b><?php echo $tlnv; ?></b></td>
      <td><b><?php echo $tmv; ?></b></b></td>
      <td><b><?php echo $tmnv;; ?></b></td>
      <td><b><?php echo $total ?></b></td>
    </tr>
  </tfoot>
    </tbody>
  </table> 
  </div>
</div>

<br><br>
<div class="row">
<?php include'incl/footer.php';?>
</div>
</body>

</html>