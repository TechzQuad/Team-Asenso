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

date_default_timezone_set('Asia/Manila');
$time=date('h:i:s A');
$id=$_GET['id'];
$sql = "SELECT *, SUBSTRING_INDEX(pos, ' ', 1) as co, SUBSTRING_INDEX(pos, ' & ', -1) as lead FROM election where id='$id'";
$result = $conn->query($sql);
$data =  $result->fetch_assoc();
 if($data['pos']=='Coordinator' || $data['co'] =='Coordinator' || $data['lead']=='Coordinator'){
    if($data['status'] == 'not voted'){
        $sql2 = "INSERT INTO `tbl_time` (`voter_id`, `real_time`) VALUES ('$id','$time')";
        $sql1 = "UPDATE election SET status='voted' WHERE id='$id'";
        if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
        echo "<script language = 'javascript'>
				swal({title: 'Updated Successfully to Voted!!',
                text: '',
                type : 'success',
                showConfirmButton: false,
                timer: 1500,
                },
                function(){
                setTimeout(function(){
                location = 'position.php?id=".$data['cluster_id']."';
                });
                });
				</script>";
    } else {
      echo "Error updating record: " . $conn->error;
    }
    }else{
        $sql_delete = "delete from `tbl_time` where voter_id='$id'";
        $sql1 = "UPDATE election SET status='not voted' WHERE id='$id'";
        if ($conn->query($sql1) === TRUE && $conn->query($sql_delete) === TRUE) {
            echo "<script language = 'javascript'>
				swal({title: 'Updated Successfully to Not Voted!!',
                text: '',
                type : 'success',
                showConfirmButton: false,
                timer: 1500,
                },
                function(){
                setTimeout(function(){
                location = 'position.php?id=".$data['cluster_id']."';
                });
                });
				</script>";
    } else {
      echo "Error updating record: " . $conn->error;
        }
        
    }
}else if($data['pos']=='Leader' ||  $data['pos']=='leader' || $data['co']=='Leader' ||  $data['co']=='leader' || $data['lead']=='Leader' ||  $data['lead']=='leader'){
    if($data['status'] == 'not voted'){
        $sql2 = "INSERT INTO `tbl_time` (`voter_id`, `real_time`) VALUES ('$id','$time')";
        $sql1 = "UPDATE election SET status='voted' WHERE id='$id'";
        if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
            echo "<script language = 'javascript'>
				swal({title: 'Updated Successfully to Voted!!',
                text: '',
                type : 'success',
                showConfirmButton: false,
                timer: 1500,
                },
                function(){
                setTimeout(function(){
                location = 'position.php?id=".$data['coordinator_id']."/".$data['cluster_id']."';
                });
                });
				</script>";
    } else {
      echo "Error updating record: " . $conn->error;
    }
    }else{
        $sql_delete = "delete from `tbl_time` where voter_id='$id'";
        $sql1 = "UPDATE election SET status='not voted' WHERE id='$id'";
        if ($conn->query($sql1) === TRUE && $conn->query($sql_delete) === TRUE) {
            echo "<script language = 'javascript'>
				swal({title: 'Updated Successfully to Not Voted!!',
                text: '',
                type : 'success',
                showConfirmButton: false,
                timer: 1500,
                },
                function(){
                setTimeout(function(){
                location = 'position.php?id=".$data['coordinator_id']."/".$data['cluster_id']."';
                });
                });
				</script>";
    } else {
      echo "Error updating record: " . $conn->error;
        }
        
    }
}else if($data['pos']=='Member'){
    if($data['status'] == 'Not Voted'){
        $sql2 = "INSERT INTO `tbl_time` (`voter_id`, `real_time`) VALUES ('$id','$time')";
        $sql1 = "UPDATE election SET status='voted' WHERE id='$id'";
        if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
        echo "<script language = 'javascript'>
				swal({title: 'Updated Successfully to Voted!!',
                text: '',
                type : 'success',
                showConfirmButton: false,
                timer: 1500,
                },
                function(){
                setTimeout(function(){
                location = 'position.php?id=".$data['leader_id']."/".$data['coordinator_id']."/".$data['cluster_id']."';
                });
                });
				</script>";
    } else {
      echo "Error updating record: " . $conn->error;
    }
    }else{
        $sql_delete = "delete from `tbl_time` where voter_id='$id'";
        $sql1 = "UPDATE election SET status='not voted' WHERE id='$id'";
        if ($conn->query($sql1) === TRUE && $conn->query($sql_delete) === TRUE) {
            echo "<script language = 'javascript'>
				swal({title: 'Updated Successfully to Not Voted!!',
                text: '',
                type : 'success',
                showConfirmButton: false,
                timer: 1500,
                },
                function(){
                setTimeout(function(){
                location = 'position.php?id=".$data['leader_id']."/".$data['coordinator_id']."/".$data['cluster_id']."';
                });
                });
				</script>";
    } else {
      echo "Error updating record: " . $conn->error;
        }
    }
}else{
    if($data['status'] == 'not voted'){
       $sql2 = "INSERT INTO `tbl_time` (`voter_id`, `real_time`) VALUES ('$id','$time')";
        $sql1 = "UPDATE election SET status='voted' WHERE id='$id'";
        if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
            echo "<script language = 'javascript'>
				swal({title: 'Updated Successfully to Voted!!',
                text: '',
                type : 'success',
                showConfirmButton: false,
                timer: 1500,
                },
                function(){
                setTimeout(function(){
                location = 'position.php';
                });
                });
				</script>";
    } else {
      echo "Error updating record: " . $conn->error;
    }
    }else{
        $sql_delete = "delete from `tbl_time` where voter_id='$id'";
        $sql1 = "UPDATE election SET status='not voted' WHERE id='$id'";
        if ($conn->query($sql1) === TRUE && $conn->query($sql_delete) === TRUE) {
            echo "<script language = 'javascript'>
				swal({title: 'Updated Successfully to Not Voted!!',
                text: '',
                type : 'success',
                showConfirmButton: false,
                timer: 1500,
                },
                function(){
                setTimeout(function(){
                location = 'position.php';
                });
                });
				</script>";
    } else {
      echo "Error updating record: " . $conn->error;
        }
        
    }
}

?>
</body>
</html>