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

$sql = "SELECT * FROM voters where id='$id'";
$result = $conn->query($sql);
$data =  $result->fetch_assoc();

    if($data['status'] == 'Not Voted'){
        $sql1 = "UPDATE voters SET status='Voted' WHERE id='$id'";
        if ($conn->query($sql1) === TRUE) {
      echo "<script>
                alert('updated successfully!!');
                window.location.href='member.php?id=". $data["leader_id"] . "';
            </script> ";
    } else {
      echo "Error updating record: " . $conn->error;
    }
    }else{
        $sql1 = "UPDATE voters SET status='Not Voted' WHERE id='$id'";
        if ($conn->query($sql1) === TRUE) {
      echo "<script>
                alert('successfully updated to Not Voted!!');
                window.location.href='member.php?id=". $data["leader_id"] . "';
            </script> ";
    } else {
      echo "Error updating record: " . $conn->error;
    }
        
    }  
    
    
?>
