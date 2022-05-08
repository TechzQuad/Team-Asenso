<?php
include('incl/auth.php');

require_once 'incl/config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$id = $_GET['id'];
$sql1 = "SELECT *, SUBSTRING_INDEX(pos, ' ', 1) as co, SUBSTRING_INDEX(pos, ' & ', -1) as lead, SUBSTRING_INDEX(pos, ' & ', 1) as pos_1  FROM election WHERE id='$id'";
$qry = mysqli_query($conn,$sql1);
$data = mysqli_fetch_array($qry);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include'incl/links.php';?>
<style>
    .a{
        text-decoration: none;
    }
    .a:hover{
        color: white; 
        text-shadow: 2px 2px red;
    }
    
    
</style>
 
</head>
<body>   
<?php //include'nav.php';?>
 
<div class="container mt-3 table-responsive">

        
    <!--coordinator table    -->
       
    <table id="kram" class="display" style="width:100%">
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
    
    
    //Leader table
    if(($data['pos'] == 'Coordinator & Leader') || $data['pos']=='Coordinator' || $data['pos']=='Coordinator & Member' || $data['pos']=='Area Coordinator'){
        $sql = "SELECT * FROM election where
      coordinator_id=$id && id!=$id";
        $result = $conn->query($sql);
        
        
        if ($result->num_rows > 0) {
            
                while($row = $result->fetch_assoc()) {
                    
                    if($row['remarks']!=""){
                        echo "<tr style='background-color:red;'><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
                        <td>".$row["brgy"].", ".$row["prk"] ."</td>
                        <td>".$row["pn"]."</td>
                        <td>".$row["pos"]."</td>";
                        if($row["status"]!="voted"){
                            echo "<td><span class='badge bg-danger'>".$row["status"]."</span></td>";
                        }else{
                            echo "<td><span class='badge bg-success'><a href='' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                            
                        }
                        echo "<td>
                            <a class='badge bg-success' href='position.php?id=" . $row["id"]."/".$id[0]. "' id=". $row["id"].">View Leaders</a>
                            <a class='badge bg-primary' href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                            </td>
                            </tr>";
                    }else{  
                    echo "<tr><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
                        <td>".$row["brgy"].", ".$row["prk"] ."</td>
                        <td>".$row["pn"]."</td>
                        <td>".$row["pos"]."</td>";
                        if($row["status"]!="voted"){
                            echo "<td><span class='badge bg-danger'><a href='#' class='btn badge bg-danger a'>".$row["status"]."</a></span></td>";
                        }else{
                            echo "<td><span class='badge bg-success'><a href='#' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                            
                        }
                        echo "<td>
                            <a href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                            </td>
                            </tr>";
                }
            }
        }
    // Member table 
    }else if($data['pos'] == 'Leader' || $data['pos'] == 'Leader & Member' || $data['co'] == 'Leader'){
        $sql = "SELECT * FROM election where
        leader_id=$id && id!=$id";
        $result = $conn->query($sql);
        
        
        if ($result->num_rows > 0) {
            
                while($row = $result->fetch_assoc()) {
                    
                    if($row['remarks']!=""){
                        echo "<tr style='background-color:red;'><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
                        <td>".$row["brgy"].", ".$row["prk"] ."</td>
                        <td>".$row["pn"]."</td>
                        <td>".$row["pos"]."</td>";
                        if($row["status"]!="voted"){
                            echo "<td><span class='badge bg-danger'>".$row["status"]."</span></td>";
                        }else{
                            echo "<td><span class='badge bg-success'><a href='' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                            
                        }
                        echo "<td>
                            <a class='badge bg-success' href='position.php?id=" . $row["id"]."/".$id[0]. "' id=". $row["id"].">View Leaders</a>
                            <a class='badge bg-primary' href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                            </td>
                            </tr>";
                    }else{  
                    echo "<tr><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
                        <td>".$row["brgy"].", ".$row["prk"] ."</td>
                        <td>".$row["pn"]."</td>
                        <td>".$row["pos"]."</td>";
                        if($row["status"]!="voted"){
                            echo "<td><span class='badge bg-danger'><a href='#' class='btn badge bg-danger a'>".$row["status"]."</a></span></td>";
                        }else{
                            echo "<td><span class='badge bg-success'><a href='#' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                            
                        }
                        echo "<td>
                            <a href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                            </td>
                            </tr>";
                }
            }
        }
    }else if($data['pos'] == 'Cluster Precint Leader & Coordinator' || $data['pos'] == 'Cluster Precint Leader' || $data['pos'] == 'Cluster Precint Leader & Leader'){
        $sql = "SELECT * FROM election where
      cluster_id=$id && id!=$id";
        $result = $conn->query($sql);
        
        
        if ($result->num_rows > 0) {
            
                while($row = $result->fetch_assoc()) {
                    
                    if($row['remarks']!=""){
                        echo "<tr style='background-color:red;'><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
                        <td>".$row["brgy"].", ".$row["prk"] ."</td>
                        <td>".$row["pn"]."</td>
                        <td>".$row["pos"]."</td>";
                        if($row["status"]!="voted"){
                            echo "<td><span class='badge bg-danger'>".$row["status"]."</span></td>";
                        }else{
                            echo "<td><span class='badge bg-success'><a href='' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                            
                        }
                        echo "<td>
                            <a class='badge bg-success' href='position.php?id=" . $row["id"]."/".$id[0]. "' id=". $row["id"].">View Leaders</a>
                            <a class='badge bg-primary' href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                            </td>
                            </tr>";
                    }else{  
                    echo "<tr><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
                        <td>".$row["brgy"].", ".$row["prk"] ."</td>
                        <td>".$row["pn"]."</td>
                        <td>".$row["pos"]."</td>";
                        if($row["status"]!="voted"){
                            echo "<td><span class='badge bg-danger'><a href='#' class='btn badge bg-danger a'>".$row["status"]."</a></span></td>";
                        }else{
                            echo "<td><span class='badge bg-success'><a href='#' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                            
                        }
                        echo "<td>
                            <a href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                            </td>
                            </tr>";
                }
            }
        }
        
    }
    $conn->close();
    ?>
    
        
        </tbody>
    </table>  
</div><br>
<?php include'incl/footer.php';?>
</body>
</html>