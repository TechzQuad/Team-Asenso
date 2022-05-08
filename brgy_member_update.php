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
date_default_timezone_set('Asia/Manila');
$time=date('h:i:s A');
$id = $_GET['id'];

$sql = "SELECT *, SUBSTRING_INDEX(pos, ' ', 1) as co, SUBSTRING_INDEX(pos, ' & ', -1) as lead FROM election where id='$id'";
$result = $conn->query($sql);
$data =  $result->fetch_assoc();

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
                location = 'brgy-view.php?brgy=".$data['brgy']."';
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
                location = 'brgy-view.php?brgy=".$data['brgy']."';
                });
                });
				</script>";
    } else {
      echo "Error updating record: " . $conn->error;
        }
        
    }

?>


</body>
</html>