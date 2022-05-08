<!DOCTYPE html>
<html lang="en">
<head>
    <title>Team Asenso</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include'incl/links.php';?>
    <link href="incl/swa/dist/sweetalert.css" rel="stylesheet" type="text/css">
<script src="incl/swa/dist/sweetalert.min.js" type="text/javascript"></script>  
</head>
<html>
    <body>
        

<?php 
include 'incl/config.php';
include 'incl/auth.php';
//load the ar library
include 'phpqrcode/qrlib.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$id=$_GET['id'];

       
if(isset($_POST['save'])){
    $name = $_POST['name'];
    $brgy= $_POST['brgy'];
    $prk=$_POST['prk'];
    $pos=$_POST['pos'];
    $preno=$_POST['preno'];
    $cname =$_POST['cname'];
    
    if($pos == "Cluster Precint Leader.Coordinator"){
        $pos1 = explode("." , $pos);
        $pos_implode = implode(" & ", $pos1);
    }else if($pos == "Cluster Precint Leader.Leader"){
        $pos1 = explode("." , $pos);
        $pos_implode = implode(" & ", $pos1);
    }else if($pos == "Cluster Precint Leader.Member"){
        $pos1 = explode("." , $pos);
        $pos_implode = implode(" & ", $pos1);
    }else if($pos == "Coordinator.Leader"){
        $pos1 = explode("." , $pos);
        $pos_implode = implode(" & ", $pos1);
    }else if($pos == "Coordinator.Member"){
        $pos1 = explode("." , $pos);
        $pos_implode = implode(" & ", $pos1);
    }else if($pos == "Leader.Member"){
        $pos1 = explode("." , $pos);
        $pos_implode = implode(" & ", $pos1);
    }
    
    
    $sql = "SELECT *,  SUBSTRING_INDEX(pos, ' & ', 1) as position, SUBSTRING_INDEX(pos, ' ', 1) as position_1 FROM election where name='$cname'";
    $result = $conn->query($sql);
    $data =  $result->fetch_assoc();
    if($data['pos'] == 'Cluster Precint Leader' || $data['position'] == 'Cluster Precint Leader'){
        
        if($pos_implode == "Coordinator & Leader"){
            $sql1 = "UPDATE election SET name = '$name', pos='$pos_implode', pn='$preno',cluster_id='".$data['id']."' ,coordinator_id='$id', leader_id='$id'   WHERE id='$id'";
            if ($conn->query($sql1) === TRUE) {
                echo "<script language = 'javascript'>
    				swal({title: 'Updated Successfully!!',
                    text: 'Team M&M | Team Asenso',
                    type : 'success',
                    showConfirmButton: false,
                    timer: 1000,
                    },
                    function(){
                    setTimeout(function(){
                    location = 'view_profile.php?id=$id';
                    });
                    });
    				</script>";
            } else {
              echo "Error updating record: " . $conn->error;
            }
        }else if($pos_implode == "Coordinator & Member"){
            $sql1 = "UPDATE election SET name = '$name', pos='$pos_implode', pn='$preno',cluster_id='".$data['id']."' ,coordinator_id='$id', leader_id='' WHERE id='$id'";
            if ($conn->query($sql1) === TRUE) {
                echo "<script language = 'javascript'>
    				swal({title: 'Updated Successfully!!',
                    text: 'Team M&M | Team Asenso',
                    type : 'success',
                    showConfirmButton: false,
                    timer: 1000,
                    },
                    function(){
                    setTimeout(function(){
                    location = 'view_profile.php?id=$id';
                    });
                    });
    				</script>";
            } else {
              echo "Error updating record: " . $conn->error;
            }
        }else{
            $sql1 = "UPDATE election SET pos='Coordinator', pn='$preno',cluster_id='".$data['id']."' ,coordinator_id='$id', leader_id='' WHERE id='$id'";
            if ($conn->query($sql1) === TRUE) {
                echo "<script language = 'javascript'>
    				swal({title: 'Updated Successfully!!',
                    text: 'Team M&M | Team Asenso',
                    type : 'success',
                    showConfirmButton: false,
                    timer: 1000,
                    },
                    function(){
                    setTimeout(function(){
                    location = 'view_profile.php?id=$id';
                    });
                    });
    				</script>";
            } else {
              echo "Error updating record: " . $conn->error;
            }
        }
    }else if($data['pos'] == 'Coordinator' || $data['position'] == 'Coordinator' || $data['position_1'] == 'Coordinator'){
        if($pos_implode == "Leader & Member"){
            $sql1 = "UPDATE election SET name = '$name', pos='$pos_implode', pn='$preno',cluster_id='".$data['cluster_id']."' ,coordinator_id='".$data['id']."', leader_id='$id' WHERE id='$id'";
            if ($conn->query($sql1) === TRUE) {
                echo "<script language = 'javascript'>
    				swal({title: 'Updated Successfully!!',
                    text: 'Team M&M | Team Asenso',
                    type : 'success',
                    showConfirmButton: false,
                    timer: 1000,
                    },
                    function(){
                    setTimeout(function(){
                    location = 'view_profile.php?id=$id';
                    });
                    });
    				</script>";
            } else {
              echo "Error updating record: " . $conn->error;
            }
        }else{
            $sql1 = "UPDATE election SET name = '$name', pos='Leader', pn='$preno',cluster_id='".$data['cluster_id']."' ,coordinator_id='".$data['id']."', leader_id='$id'   WHERE id='$id'";
            if ($conn->query($sql1) === TRUE) {
                echo "<script language = 'javascript'>
    				swal({title: 'Updated Successfully!!',
                    text: 'Team M&M | Team Asenso',
                    type : 'success',
                    showConfirmButton: false,
                    timer: 1000,
                    },
                    function(){
                    setTimeout(function(){
                    location = 'view_profile.php?id=$id';
                    });
                    });
    				</script>";
            } else {
              echo "Error updating record: " . $conn->error;
            }
        }
        
    }
    else if($data['pos'] == 'Leader' || $data['position'] == 'Leader' || $data['position_1'] == 'Leader'){
        $sql1 = "UPDATE election SET pos='$pos', pn='$preno', cluster_id='".$data['cluster_id']."' ,coordinator_id='".$data['coordinator_id']."', leader_id='".$data['id']."'   WHERE id='$id'";
        if ($conn->query($sql1) === TRUE) {
            echo "<script language = 'javascript'>
				swal({title: 'Updated Successfully!!',
                text: 'Team M&M | Team Asenso',
                type : 'success',
                showConfirmButton: false,
                timer: 1000,
                },
                function(){
                setTimeout(function(){
                location = 'view_profile.php?id=$id';
                });
                });
				</script>";
        } else {
          echo "Error updating record: " . $conn->error;
        }
    }
    else{
        if($pos_implode == "Cluster Precint Leader & Coordinator"){
            $sql1 = "UPDATE election SET name = '$name', pos='$pos_implode', pn='$preno', cluster_id='$id', coordinator_id='', leader_id=''  WHERE id='$id'";
            if ($conn->query($sql1) === TRUE) {
                echo "<script language = 'javascript'>
    				swal({title: 'Updated Successfully!!',
                    text: 'Team M&M | Team Asenso',
                    type : 'success',
                    showConfirmButton: false,
                    timer: 1000,
                    },
                    function(){
                    setTimeout(function(){
                    location = 'view_profile.php?id=$id';
                    });
                    });
    				</script>";
            } else {
              echo "Error updating record: " . $conn->error;
            }    
        }else if($pos_implode == "Cluster Precint Leader & Leader"){
            $sql1 = "UPDATE election SET name = '$name', pos='$pos_implode', pn='$preno', cluster_id='$id', coordinator_id='', leader_id=''  WHERE id='$id'";
            if ($conn->query($sql1) === TRUE) {
                echo "<script language = 'javascript'>
    				swal({title: 'Updated Successfully!!',
                    text: 'Team M&M | Team Asenso',
                    type : 'success',
                    showConfirmButton: false,
                    timer: 1000,
                    },
                    function(){
                    setTimeout(function(){
                    location = 'view_profile.php?id=$id';
                    });
                    });
    				</script>";
            } else {
              echo "Error updating record: " . $conn->error;
            }  
        
        }else if($pos_implode == "Cluster Precint Leader & Member"){
            $sql1 = "UPDATE election SET name = '$name', pos='$pos_implode', pn='$preno', cluster_id='$id', coordinator_id='', leader_id=''  WHERE id='$id'";
            if ($conn->query($sql1) === TRUE) {
               echo "<script language = 'javascript'>
    				swal({title: 'Updated Successfully!!',
                    text: 'Team M&M | Team Asenso',
                    type : 'success',
                    showConfirmButton: false,
                    timer: 1000,
                    },
                    function(){
                    setTimeout(function(){
                    location = 'view_profile.php?id=$id';
                    });
                    });
    				</script>";
            } else {
              echo "Error updating record: " . $conn->error;
            }  
        
        }else{
            $sql1 = "UPDATE election SET name = '$name', pos='$pos', pn='$preno', cluster_id='$id', coordinator_id='', leader_id=''  WHERE id='$id'";
            if ($conn->query($sql1) === TRUE) {
                echo "<script language = 'javascript'>
    				swal({title: 'Updated Successfully!!',
                    text: 'Team M&M | Team Asenso',
                    type : 'success',
                    showConfirmButton: false,
                    timer: 1000,
                    },
                    function(){
                    setTimeout(function(){
                    location = 'view_profile.php?id=$id';
                    });
                    });
    				</script>";
            } else {
              echo "Error updating record: " . $conn->error;
            } 
        }
    }
    
}    
    
?>

    </body>
</html>