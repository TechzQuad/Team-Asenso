<?php
include('incl/auth.php');

require_once 'incl/config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
    if(isset($_POST['search'])){
        if(!EMPTY($_POST['search'])){
            
        
            echo "
             <table id='voters' class='display' style='width:100%'>
                <thead>
                  <tr>
                    <th>Voter Number</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Precinct #</th>
                    <th>Position</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
            ";
            $sql = "SELECT *,  SUBSTRING_INDEX(pos, ' ', 1) as pos_1, SUBSTRING_INDEX(pos, ' & ', -1) as pos_2, SUBSTRING_INDEX(pos, ' & ', 1) as pos_3  FROM election where
            (name like '%".$_POST['search']."%') || (id= '".$_POST['search']."') order by name limit 10";
            $result = $conn->query($sql);
        
        
            if ($result->num_rows > 0) {
            
                while($row = $result->fetch_assoc()) {
                      
                    echo "<tr><td>".$row["id"]."<td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
                        <td>".$row["brgy"].", ".$row["prk"] ."</td>
                        <td>".$row["pn"]."</td>
                        <td>".$row["pos"]."</td>";
                        if($row["status"]!="voted"){
                            echo "<td><span class='badge bg-danger'><a href='search_update.php?id=" . $row["id"]."' class='btn badge bg-danger a'>".$row["status"]."</a></span></td>";
                           
                        }else{
                            echo "<td><span class='badge bg-success'><a href='search_update.php?id=" . $row["id"]."' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                            
                        }
                        if($row['pos']=='Cluster Precint Leader' || $row['pos_3']=='Cluster Precint Leader'){
                            echo "<td>
                                <a class='badge bg-success' href='position.php?id=" . $row["id"]."' id=". $row["id"].">View Coordinators</a>
                                <a class='badge bg-primary' href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                                </td>
                                </tr>";        
                        }else if($row['pos']=='Coordinator' || $row['pos_1']=='Coordinator' || $row['pos_2']=='Coordinator'){
                            echo "<td>
                                <a class='badge bg-success' href='position.php?id=" . $row["id"]."/".$row["cluster_id"]."' id=". $row["id"].">View Leaders</a>
                                <a class='badge bg-primary' href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                                </td>
                                </tr>";    
                        }else if($row['pos']=='Leader' || $row['pos_1']=='Leader' || $row['pos_2']=='Leader'){
                            echo "<td>
                                <a class='badge bg-success' href='position.php?id=" . $row["id"]."/".$row["coordinator_id"]."/".$row["cluster_id"]."' id=". $row["id"].">View Members</a>
                                <a class='badge bg-primary' href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                                </td>
                                </tr>";    
                        }else if($row['pos']=='Member'){
                            echo "<td>
                                <a class='badge bg-primary' href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                                </td>
                                </tr>"; 
                        }else{
                            echo "<td>
                                <a class='badge bg-primary' href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                                </td>
                                </tr>";
                        }
                }
            }else {
              echo "0 results";
            }
            
            echo "</tbody>
                </table>
            ";
            
        }else{
            echo "";
        }
    }


$conn->close();
?>
