<?php
include('incl/auth.php');

require_once 'incl/config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}



$empQuery = "SELECT id, name, standing, brgy, prk, pn, pos, status  FROM election where pos=''";
$empRecords = mysqli_query($con, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
   $data[] = array( 
      "id"=>$row['id'],
      "name"=>$row['name'],
      "standing"=>$row['standing'],
      "brgy"=>$row['brgy'],
      "prk"=>$row['prk'],
      "pn"=>$row['pn'],
      "pos"=>$row['pos'],
      "status"=>$row['status'],
      
   );
}

$response = array(
  "data" => $data
);

echo json_encode($response);



// $sql = "SELECT id, name, standing, brgy, prk, pn, pos, status  FROM election where
// pos=''";
// $result = $conn->query($sql);
    
// if ($result->num_rows > 0) {
        
//             while($row = $result->fetch_assoc()) {
                
//                 if($row['remarks']!=""){
//                     echo "<tr style='background-color:red;'><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
//                     <td>".$row["brgy"].", ".$row["prk"] ."</td>
//                     <td>".$row["pn"]."</td>
//                     <td>".$row["pos"]."</td>";
//                     if($row["status"]!="voted"){
//                         echo "<td><span class='badge bg-danger'>".$row["status"]."</span></td>";
//                     }else{
//                         echo "<td><span class='badge bg-success'><a href='brgy_member_update.php?id=".$row["id"]."' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                        
//                     }
//                     echo "<td>
//                         <a class='badge bg-success' href='position.php?id=" . $row["id"]."/".$id[0]. "' id=". $row["id"].">View Leaders</a>
//                         <a class='badge bg-primary' href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
//                         </td>
//                         </tr>";
//                 }else{  
//                 echo "<tr><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
//                     <td>".$row["brgy"].", ".$row["prk"] ."</td>
//                     <td>".$row["pn"]."</td>
//                     <td>".$row["pos"]."</td>";
//                     if($row["status"]!="voted"){
//                         echo "<td><span class='badge bg-danger'><a href='brgy_member_update.php?id=".$row["id"]."' class='btn badge bg-danger a'>".$row["status"]."</a></span></td>";
//                     }else{
//                         echo "<td><span class='badge bg-success'><a href='brgy_member_update.php?id=".$row["id"]."' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                        
//                     }
//                     echo "<td>
//                         <a class='badge bg-primary' href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
//                         </td>
//                         </tr>";
//             }
//         }
//     } else {
//       echo "0 results";
//     }
?>