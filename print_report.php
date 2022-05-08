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
  <h1>Cluster Precint Leaders Reports</h1><br><br>
 <table id="voters" class="display" style="width:100%">
    <thead>
      <tr>
        <th>Name</th>
        <th colspan="2">Coordinator #</th>
        <th colspan="2">Leader #</th>
        <th colspan="2">Member #</th>
      </tr>
    </thead>
    <tbody>
       <tr><th></th><th>voted</th><th>not voted</th><th>voted</th><th>not voted</th><th>voted</th><th>not voted</th></tr>
       
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
            sum(CASE WHEN status = 'not voted'  and pos='Coordinator' THEN 1 ELSE 0 END) AS cnv,
            sum(CASE WHEN status = 'voted'  and pos='Coordinator' THEN 1 ELSE 0 END) AS cv, 
            sum(CASE WHEN status = 'not voted'  and pos='Leader' THEN 1 ELSE 0 END) AS lnv,
            sum(CASE WHEN status = 'voted'  and pos='Leader' THEN 1 ELSE 0 END) AS lv, 
            sum(CASE WHEN status = 'not voted'  and pos='Member' THEN 1 ELSE 0 END) AS mnv,
            sum(CASE WHEN status = 'voted'  and pos='Member' THEN 1 ELSE 0 END) AS mv
            FROM election where cluster_id='".$row1['id']."'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
         
          while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'></span></td>
            <td>".$row["cv"]."</td>
            <td>".$row["cnv"]."</td>
            <td>".$row["lv"]."</td>
            <td>".$row["lnv"]."</td>
            <td>".$row["mv"]."</td>
            <td>".$row["mnv"]."</td>
            
            ";
          }
          
        } else {
          echo "0 results";
        }
    }
  
} else {
  echo "0 results";
}

$conn->close();
?>
    
    </tbody>
  </table>  
  
<script type="text/javascript">
	function PrintPage() {
		window.print();
	}
</script>  
  
  
  