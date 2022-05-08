



<!DOCTYPE html>
<html lang="en">
<head>
<?php include'incl/links.php';?>
<style>
      
</style>
 
</head>
<body>   
    
    
<?php include'incl/nav.php';?>

<div class="container mt-3">
 <table id="voters" class="display" style="width:100%">
    <thead>
      <tr>
        <th>Name</th>
        <th>Cluster Presinct #</th>
        <th>Position</th>
        <th>Address</th>
        <th>date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
            <?php
    
                require_once 'incl/config.php';
                
                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
                // Check connection
                if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
                }
                $sql = "SELECT election.name,election.standing, election.pn, election.pos, election.brgy, election.prk , attendance.* from attendance INNER JOIN election ON attendance.v_id=election.id";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr ><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
                        <td>".$row["pn"]."</td>
                        <td>".$row["pos"]."</td>
                        <td>".$row["brgy"].", ".$row["prk"] ."</td>
                        <td>".$row["date"]."</td>
                        <td><a href='remove.php?id=".$row["id"]."' class='btn btn-danger'>Remove</a></td></tr>
                        ";
                    }
                } else {
                  echo "0 results";
                }
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