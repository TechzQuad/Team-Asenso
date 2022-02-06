<!DOCTYPE html>
<html lang="en">
<head>
<?php include'incl/links.php';?>
</head>
<body>
<?php include'incl/nav.php';?>


<div class="container mt-3">
  <h1>Voter's Table</h1><a href="#" class="btn btn-secondary pull-right">Browse QR>></a><br><br>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Name</th>
        <th>Address</th>
        <th>Precinct #</th>
        <th>Position</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php
$servername = "localhost";
$username = "u722023368_techzquad";
$password = "@TechzQuad1";
$dbname = "u722023368_toboso";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT standing,name,address,pcn,status FROM voters";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
 
  while($row = $result->fetch_assoc()) {
    echo "<tr><td>".$row["name"]." ".$row["standing"]."</td>
    <td>".$row["address"]."</td>
    <td>".$row["pcn"]."</td>
    <td>".$row["status"]."</td>
    <td><a href='#'>View Info</a>&nbsp;<a href='#'>View Members</a></td>
    </tr>";
  }
  
} else {
  echo "0 results";
}
$conn->close();
?>
    
    </tbody>
  </table>
</div>
<br><br>
<div class="row">
<?php include'incl/footer.php';?>
</div>
</body>
</html>