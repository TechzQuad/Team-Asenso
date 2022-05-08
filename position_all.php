<?php
include('incl/auth.php');

require_once 'incl/config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$pos = $_GET['pos'];
$pos_explode = explode($pos, ' ');
$sql1 = "SELECT *, SUBSTRING_INDEX(pos, ' ', 1) as co, SUBSTRING_INDEX(pos, ' & ', -1) as lead FROM election WHERE pos like '".$pos."'";
$qry = mysqli_query($conn,$sql1);
$data = mysqli_fetch_array($qry);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include'incl/links.php';?>
<link href="incl/swa/dist/sweetalert.css" rel="stylesheet" type="text/css">
<script src="incl/swa/dist/sweetalert.min.js" type="text/javascript"></script> 
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
<?php
 $id_session = $_SESSION['id'];
    $id_sql = "SELECT * FROM users where id='$id_session' AND position='admin'";
    $id_result = $conn->query($id_sql);
    $id_data =  $id_result->fetch_assoc();
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
				</script>";
    }
include'incl/nav.php';?>
<div class="container mt-3">
   <?php if($data['pos'] == 'Coordinator'){ ?>
        <h1>Coordinators List</h1> 
    <?php    
        }else if($pos=='Leader'){
    ?>
        <h1>Leaders List</h1>
    <?php
        }else if($pos=='Leader'){
    ?>
        <h1>Members List</h1>
    <?php }?>
    <a href="qr_all.php?pos=<?php echo $pos;?>"  style="margin-top: 30px;" class="btn btn-secondary pull-right" target="_blank">Browse QR>></a>
    <a href="position_all_sb.php?pos=<?php echo $pos;?>"  style="margin-top: 30px;" class="btn btn-secondary pull-right" target="_blank">Browse Sample Ballot>></a><br><br>
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
    if($pos == 'Coordinator' || $pos_explode[0]=='Coordinator'){
        $sql = "SELECT * FROM election where pos LIKE '%Coordinator%'";
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
                            echo "<td><span class='badge bg-success'><a href='update.php?id=".$row["id"]."' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                            
                        }
                        echo "<td>
                            <a href='position.php?id=" . $row["id"]."/".$id[0]. "' id=". $row["id"].">View Leaders</a>
                            <a href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                            </td>
                            </tr>";
                    }else{  
                    echo "<tr><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
                        <td>".$row["brgy"].", ".$row["prk"] ."</td>
                        <td>".$row["pn"]."</td>
                        <td>".$row["pos"]."</td>";
                        if($row["status"]!="voted"){
                            echo "<td><span class='badge bg-danger'><a href='position_all_update.php?id=".$row["id"]."' class='btn badge bg-danger a'>".$row["status"]."</a></span></td>";
                        }else{
                            echo "<td><span class='badge bg-success'><a href='position_all_update.php?id=".$row["id"]."' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                            
                        }
                        echo "<td>
                            <a class='badge bg-primary' href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                            <a class='badge bg-success' href='pos_all.php?id=" . $row["id"]. "' id=". $row["id"].">View Leaders</a>
                            </td>
                            </tr>";
                }
            }
        } else {
          echo "0 results";
        }
    }else if($pos=='Leader' || $pos_explode[0]=='Leader' || $pos_explode[0]=='leader'){
        $sql = "SELECT * FROM election where
        pos like 'Leader%' and pos!='Cluster Precint Leader'";
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
                            echo "<td><span class='badge bg-success'><a href='update.php?id=".$row["id"]."' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                            
                        }
                        echo "<td>
                            <a href='position.php?id=" . $row["id"]."/".$id[0]. "' id=". $row["id"].">View Leaders</a>
                            <a href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                            </td>
                            </tr>";
                    }else{  
                    echo "<tr><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
                        <td>".$row["brgy"].", ".$row["prk"] ."</td>
                        <td>".$row["pn"]."</td>
                        <td>".$row["pos"]."</td>";
                        if($row["status"]!="voted"){
                            echo "<td><span class='badge bg-danger'><a href='position_all_update.php?id=".$row["id"]."' class='btn badge bg-danger a'>".$row["status"]."</a></span></td>";
                        }else{
                            echo "<td><span class='badge bg-success'><a href='position_all_update.php?id=".$row["id"]."' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                            
                        }
                        echo "<td>
                            <a class='badge bg-primary' href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                            <a class='badge bg-success' href='pos_all.php?id=" . $row["id"]. "' id=". $row["id"].">View Members</a>
                            </td>
                            </tr>";
                }
            }
        } else {
          echo "0 results";
        }
    }else if($pos=='Member' || $pos_explode[0]=='Member'){
        $sql = "SELECT * FROM election where
        pos like '%Member%'";
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
                            echo "<td><span class='badge bg-success'><a href='update.php?id=".$row["id"]."' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                            
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
                            echo "<td><span class='badge bg-danger'><a href='position_all_update.php?id=".$row["id"]."' class='btn badge bg-danger a'>".$row["status"]."</a></span></td>";
                        }else{
                            echo "<td><span class='badge bg-success'><a href='position_all_update.php?id=".$row["id"]."' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                            
                        }
                        echo "<td>
                            <a href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                            </td>
                            </tr>";
                }
            }
        } else {
          echo "0 results";
        }
    }else{
        $sql = "SELECT * FROM election where pos LIKE '%Cluster Precint Leader%'";
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
                            echo "<td><span class='badge bg-success'><a href='update.php?id=".$row["id"]."' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                            
                        }
                        echo "<td>
                            <a href='position.php?id=" . $row["id"]."/".$id[0]. "' id=". $row["id"].">View Coordinators,Leaders & Members</a>
                            <a href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                            </td>
                            </tr>";
                    }else{  
                    echo "<tr><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
                        <td>".$row["brgy"].", ".$row["prk"] ."</td>
                        <td>".$row["pn"]."</td>
                        <td>".$row["pos"]."</td>";
                        if($row["status"]!="voted"){
                            echo "<td><span class='badge bg-danger'><a href='position_all_update.php?id=".$row["id"]."' class='btn badge bg-danger a'>".$row["status"]."</a></span></td>";
                        }else{
                            echo "<td><span class='badge bg-success'><a href='position_all_update.php?id=".$row["id"]."' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                            
                        }
                        echo "<td>
                            <a class='badge bg-primary' href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                            <a class='badge bg-success' href='pos_all.php?id=" . $row["id"]. "' id=". $row["id"].">View Coordinators,Leaders & Members</a>
                            </td>
                            </tr>";
                }
            }
        }
    }
    $conn->close();?>
        </tbody>
    </table>  
</div><br>
<?php include'incl/footer.php';?>
</body>
</html>