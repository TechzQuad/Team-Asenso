<style type="text/css">
.pads{
    padding-top: 10px;
    
}

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
 
<div class="container mt-3">
  <center><h1>Cluster Precint Leaders<br> per Barangay Reports</h1><br><br></center>
 <br><br>
 <table id="voters" class="display" style="width:100%">
   <thead>
      <tr>
        <th rowspan="2">Name</th>
        <th colspan="2">Bandila</th>
        <th colspan="2">Bug-ang</th>
        <th colspan="2">Gen. Luna</th>
        <th colspan="2">Magticol</th>
        <th colspan="2">Poblacion</th>
        <th colspan="2">Salamanca</th>
        <th colspan="2">San Isidro</th>
        <th colspan="2">San Jose</th>
        <th colspan="2">Tabun-ac</th>
        <th colspan="2">Total</th>
      </tr>
    </thead>
    <tbody>
       <tr><th></th><th>Voted</th><th>Not Voted</th><th>Voted</th><th>Not Voted</th><th>Voted</th><th>Not Voted</th><th>Voted</th><th>Not Voted</th><th>Voted</th><th>Not Voted</th><th>Voted</th><th>Not Voted</th><th>Voted</th><th>Not Voted</th><th>Voted</th><th>Not Voted</th><th>Voted</th><th>Not Voted</th><th></th></tr>
<?php
require_once 'incl/config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql1 = "SELECT * from election where pos='Cluster Precint Leader' order by name";
$result1 = $conn->query($sql1);

if ($result1->num_rows > 0) {
     while($row1 = $result1->fetch_assoc()) {
        $sql = "SELECT name, 
            (SELECT count(*) from election where pos='Coordinator' && cluster_id='".$row1['id']."') AS total,
            (SELECT count(*) from election where status = 'not voted'  and brgy='Bandila' && pos='Coordinator' && cluster_id='".$row1['id']."') AS bnv,
            (SELECT count(*) from election where status = 'voted'  and brgy='Bandila' && pos='Coordinator' && cluster_id='".$row1['id']."') AS bv, 
            (SELECT count(*) from election where status = 'not voted'  and brgy='Bug-ang' && pos='Coordinator' && cluster_id='".$row1['id']."') AS bunv,
            (SELECT count(*) from election where status = 'voted'  and brgy='Bug-ang' && pos='Coordinator' && cluster_id='".$row1['id']."') AS buv, 
            (SELECT count(*) from election where status = 'not voted'  and brgy='Gen. Luna' && pos='Coordinator' && cluster_id='".$row1['id']."') AS gnv,
            (SELECT count(*) from election where status = 'voted'  and brgy='Gen. Luna' && pos='Coordinator' && cluster_id='".$row1['id']."') AS gv, 
            (SELECT count(*) from election where status = 'not voted'  and brgy='Magticol' && pos='Coordinator' && cluster_id='".$row1['id']."') AS mnv,
            (SELECT count(*) from election where status = 'voted'  and brgy='Magticol' && pos='Coordinator' && cluster_id='".$row1['id']."') AS mv, 
            (SELECT count(*) from election where status = 'not voted'  and brgy='Poblacion' && pos='Coordinator' && cluster_id='".$row1['id']."') AS pnv,
            (SELECT count(*) from election where status = 'voted'  and brgy='Poblacion' && pos='Coordinator' && cluster_id='".$row1['id']."') AS pv, 
            (SELECT count(*) from election where status = 'not voted'  and brgy='Salamanca' && pos='Coordinator' && cluster_id='".$row1['id']."') AS snv,
            (SELECT count(*) from election where status = 'voted'  and brgy='Salamanca' && pos='Coordinator' && cluster_id='".$row1['id']."') AS sv, 
            (SELECT count(*) from election where status = 'not voted'  and brgy='San Isidro' && pos='Coordinator' && cluster_id='".$row1['id']."') AS sinv,
            (SELECT count(*) from election where status = 'voted'  and brgy='San Isidro' && pos='Coordinator' && cluster_id='".$row1['id']."') AS siv, 
            (SELECT count(*) from election where status = 'not voted'  and brgy='San Jose' && pos='Coordinator' && cluster_id='".$row1['id']."') AS sjnv,
            (SELECT count(*) from election where status = 'voted'  and brgy='San Jose' && pos='Coordinator' && cluster_id='".$row1['id']."') AS sjv, 
            (SELECT count(*) from election where status = 'not voted'  and brgy='Tabun-ac' && pos='Coordinator' && cluster_id='".$row1['id']."') AS tnv,
            (SELECT count(*) from election where status = 'voted'  and brgy='Tabun-ac' && pos='Coordinator' && cluster_id='".$row1['id']."') AS tv
            FROM election where id='".$row1['id']."'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
         
          while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'></span></td>
            <td>".$row["bv"]."</td>
            <td>".$row["bnv"]."</td>
            <td>".$row["buv"]."</td>
            <td>".$row["bunv"]."</td>
            <td>".$row["gv"]."</td>
            <td>".$row["gnv"]."</td>
            <td>".$row["mv"]."</td>
            <td>".$row["mnv"]."</td>
            <td>".$row["pv"]."</td>
            <td>".$row["pnv"]."</td>
            <td>".$row["sv"]."</td>
            <td>".$row["snv"]."</td>
            <td>".$row["siv"]."</td>
            <td>".$row["sinv"]."</td>
            <td>".$row["sjv"]."</td>
            <td>".$row["sjnv"]."</td>
            <td>".$row["tv"]."</td>
            <td>".$row["tnv"]."</td>
            <td><strong>".$row["total"]."</strong></td>
            
            ";
          }
          
        } else {
          echo "0 results";
        }
    }
  
} else {
  echo "0 results";
}


$sql = "SELECT 
sum(CASE WHEN status = 'not voted' && pos='Coordinator' && brgy='Bandila' THEN 1 ELSE 0 END) AS banv,
sum(CASE WHEN status = 'voted' && pos='Coordinator' && brgy='Bandila' THEN 1 ELSE 0 END) AS bav,
sum(CASE WHEN status = 'not voted' && pos='Coordinator' && brgy='Bug-ang' THEN 1 ELSE 0 END) AS bnv,
sum(CASE WHEN status = 'voted' && pos='Coordinator' && brgy='Bug-ang' THEN 1 ELSE 0 END) AS bv,
sum(CASE WHEN status = 'not voted' && pos='Coordinator' && brgy='Gen. Luna' THEN 1 ELSE 0 END) AS gnv,
sum(CASE WHEN status = 'voted' && pos='Coordinator' && brgy='Gen. Luna' THEN 1 ELSE 0 END) AS gv,
sum(CASE WHEN status = 'not voted' && pos='Coordinator' && brgy='Magticol' THEN 1 ELSE 0 END) AS mnv,
sum(CASE WHEN status = 'voted' && pos='Coordinator' && brgy='Magticol' THEN 1 ELSE 0 END) AS mv,
sum(CASE WHEN status = 'not voted' && pos='Coordinator' && brgy='Poblacion' THEN 1 ELSE 0 END) AS pnv,
sum(CASE WHEN status = 'voted' && pos='Coordinator' && brgy='Poblacion' THEN 1 ELSE 0 END) AS pv,
sum(CASE WHEN status = 'not voted' && pos='Coordinator' && brgy='Salamanca' THEN 1 ELSE 0 END) AS snv,
sum(CASE WHEN status = 'voted' && pos='Coordinator' && brgy='Salamanca' THEN 1 ELSE 0 END) AS sv,
sum(CASE WHEN status = 'not voted' && pos='Coordinator' && brgy='San Isidro' THEN 1 ELSE 0 END) AS sinv,
sum(CASE WHEN status = 'voted' && pos='Coordinator' && brgy='San Isidro' THEN 1 ELSE 0 END) AS siv,
sum(CASE WHEN status = 'not voted' && pos='Coordinator' && brgy='San Jose' THEN 1 ELSE 0 END) AS sjnv,
sum(CASE WHEN status = 'voted' && pos='Coordinator' && brgy='San Jose' THEN 1 ELSE 0 END) AS sjv,
sum(CASE WHEN status = 'not voted' && pos='Coordinator' && brgy='Tabun-ac' THEN 1 ELSE 0 END) AS tnv,
sum(CASE WHEN status = 'voted' && pos='Coordinator' && brgy='Tabun-ac' THEN 1 ELSE 0 END) AS tv,
(select count(*) from election WHERE status!='' && (pos='Coordinator' || pos='Leader' || pos='Member')  && pos!='') AS total
FROM `election` ";
$result = $conn->query($sql);
$data =  $result->fetch_assoc();

$conn->close();
?>
    <tfoot>
        <tr>
          <td><b>Total</b></td>
          <td><b><?php echo $data['banv']; ?></b></td>
          <td><b><?php echo $data['bav']; ?></b></td>
          <td><b><?php echo $data['bnv']; ?></b></td>
          <td><b><?php echo $data['bv']; ?></b></td>
          <td><b><?php echo $data['gnv']; ?></b></b></td>
          <td><b><?php echo $data['gv']; ?></b></td>
          <td><b><?php echo $data['mnv']; ?></b></td>
          <td><b><?php echo $data['mv']; ?></b></td>
          <td><b><?php echo $data['pnv']; ?></b></td>
          <td><b><?php echo $data['pv']; ?></b></td>
          <td><b><?php echo $data['snv']; ?></b></td>
          <td><b><?php echo $data['sv']; ?></b></td>
          <td><b><?php echo $data['sinv']; ?></b></td>
          <td><b><?php echo $data['siv']; ?></b></td>
          <td><b><?php echo $data['sjnv']; ?></b></td>
          <td><b><?php echo $data['sjv']; ?></b></td>
          <td><b><?php echo $data['tnv']; ?></b></td>
          <td><b><?php echo $data['tv']; ?></b></td>
          <td><b><?php echo $data['total']; ?></b></td>
        </tr>
  </tfoot>

   

    </tbody>
  </table>  
</div>
<script type="text/javascript">
	function PrintPage() {
		window.print();
	}
	window.addEventListener('DOMContentLoaded', (event) => {
   		PrintPage()
		setTimeout(function(){ window.close() },750)
	});
</script>  
  
  
  