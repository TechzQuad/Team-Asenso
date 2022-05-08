<?php
include('incl/auth.php');
require_once 'incl/config.php';
$conn = new mysqli($servername, $username, $password, $dbname);
$ids = $_GET['id'];
$id = explode('/',$_GET['id']);
$sql1 = "SELECT * FROM voters WHERE id='".$id[0]."'";
$qry = mysqli_query($conn,$sql1);
$data = mysqli_fetch_array($qry);
$cluster_id=$data['cluster_id'];


if($data['pos'] == 'CLUSTER LEADER'){

    $sql = "SELECT * FROM voters where cluster_id like '%$ids' || '$ids%' || '%$ids%' order by pos";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $exp = explode(',', $row['cluster_id']);
            $count = COUNT($exp);
            $loop = 0;
            for($loop; $loop<$count; $loop++){
                
                if($ids == $exp[$loop]){
                    echo "<tr>"; ?>
                        <td><?php echo $row['name']; ?> &nbsp;&nbsp;&nbsp;<span class="badge bg-secondary"><?php echo $row['standing']; ?></span></td>
                        <td><?php echo $row["address"]; ?></td>
                        <td><?php echo $row['pcn']; ?></td>
                        <td><?php echo $row["pos"]; ?></td>
                       <?php if($row["status"]!="Voted"){  ?>
                        <td><span class="badge bg-danger"><a href="update.php?id=<?php echo $exp[$loop];?>" class="btn badge bg-danger"><?php echo $row['status']; ?></a></span></td>
                        
<?php
                        }else{
                            echo "<td><span class='badge bg-success'><a href='update.php?id=".$row["id"]."' class='btn badge bg-success'>".$row["status"]."</a></span></td>";}
                        echo "<td>
                            <a href='coordinator(1).php?id=" . $row["id"]."/".$ids. "' id=". $row["id"].">View Leaders</a>
                            <a href='view_profile.php?id=" . $row["id"]."' id=". $row["id"].">View Info</a>
                            </td>
                    </tr>";
                }    
            }
        }
    } else {
      echo "0 results";
    }
}else if($data['pos'] == 'COORDINATOR'){
    $sql = "SELECT * FROM voters where coordinator_id='".$id[0]."' && cluster_id like '%".$id[1]."%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row1 = $result->fetch_assoc()) {
            $exp = explode(',', $row1['cluster_id']);
            $count = COUNT($exp);
            $loop = 0;
            for($loop; $loop<$count; $loop++){
                $exp2 = explode(',', $row1['cluster_id']);
                if($id[1] == $exp[$loop]){
                    echo "<tr>"; ?>
                        <td><?php echo $row1['name']; ?> &nbsp;&nbsp;&nbsp;<span class="badge bg-secondary"><?php echo $row1['standing']; ?></span></td>
                        <td><?php echo $row1["address"]; ?></td>
                        <td><?php echo $row1['pcn']; ?></td>
                        <td><?php echo $row1["pos"]; ?></td>
                       <?php if($row["status"]!="Voted"){  ?>
                        <td><span class="badge bg-danger"><a href="update.php?id=<?php echo $exp[$loop];?>" class="btn badge bg-danger"><?php echo $row1['status']; ?></a></span></td>
                        
<?php
                        }else{
                            echo "<td><span class='badge bg-success'><a href='update.php?id=".$row1["id"]."' class='btn badge bg-success'>".$row1["status"]."</a></span></td>";}
                        echo "<td>
                            <a href='coordinator(1).php?id=" . $row1["id"]. "/".$id[1]."'>View Members</a>
                            <a href='view_profile.php?id=" . $row1["id"]. "' id=". $row1["id"].">View Info</a>
                            </td>
                    </tr>";
                }    
            }
        }
    } else {
      echo "0 results";
    }
}else if($data['pos'] == 'LEADER'){
    
    $sql = "SELECT * FROM voters where leader_id='".$id[0]."' && cluster_id like '%".$id[1]."%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row1 = $result->fetch_assoc()) {
            $exp = explode(',', $row1['cluster_id']);
            $count = COUNT($exp);
            $loop = 0;
            for($loop; $loop<$count; $loop++){
                $exp2 = explode(',', $row1['cluster_id']);
                if($id[1] == $exp[$loop]){
                    echo "<tr>"; ?>
                        <td><?php echo $row1['name']; ?> &nbsp;&nbsp;&nbsp;<span class="badge bg-secondary"><?php echo $row1['standing']; ?></span></td>
                        <td><?php echo $row1["address"]; ?></td>
                        <td><?php echo $row1['pcn']; ?></td>
                        <td><?php echo $row1["pos"]; ?></td>
                       <?php if($row["status"]!="Voted"){  ?>
                        <td><span class="badge bg-danger"><a href="update.php?id=<?php echo $exp[$loop];?>" class="btn badge bg-danger"><?php echo $row1['status']; ?></a></span></td>
                        
<?php
                        }else{
                            echo "<td><span class='badge bg-success'><a href='update.php?id=".$row1["id"]."' class='btn badge bg-success'>".$row1["status"]."</a></span></td>";}
                        echo "<td>
                            <a href='coordinator(1).php?id=" . $row1["id"]. "'/".$id[1].">View Members</a>
                            <a href='view_profile.php?id=" . $row1["id"]. "' id=". $row1["id"].">View Info</a>
                            </td>
                    </tr>";
                }    
            }
        }
    } else {
      echo "0 results";
    }
}else{
    
    $sql = "SELECT * FROM voters where pos='cluster leader'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row1 = $result->fetch_assoc()) {
            echo "<tr>"; ?>
                <td><?php echo $row1['name']; ?> &nbsp;&nbsp;&nbsp;<span class="badge bg-secondary"><?php echo $row1['standing']; ?></span></td>
                <td><?php echo $row1["address"]; ?></td>
                <td><?php echo $row1['pcn']; ?></td>
                <td><?php echo $row1["pos"]; ?></td>
               <?php if($row["status"]!="Voted"){  ?>
                <td><span class="badge bg-danger"><a href="update.php?id=<?php echo $exp[$loop];?>" class="btn badge bg-danger"><?php echo $row1['status']; ?></a></span></td>
                
<?php
                }else{
                    echo "<td><span class='badge bg-success'><a href='update.php?id=".$row1["id"]."' class='btn badge bg-success'>".$row1["status"]."</a></span></td>";}
                echo "<td>
                    <a href='coordinator(1).php?id=". $row1["id"]."'>View Coordinator</a>
                    <a href='view_profile.php?id=" . $row1["id"]. "' id=". $row1["id"].">View Info</a>
                    </td>
            </tr>";
        }
    } else {
      echo "0 results";
    }
}
        
    
    $conn->close();

?>