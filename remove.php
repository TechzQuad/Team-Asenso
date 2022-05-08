<?php
include 'incl/config.php';
//load the ar library
include 'phpqrcode/qrlib.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$id=$_GET['id'];
    $d1sql = "DELETE FROM attendance WHERE id=$id";
    if ($conn->query($d1sql) === TRUE) {
      echo "<script>
            alert('Record deleted successfully');
            window.location.href='attendance.php';
          </script>";
    } else {
      echo "Error deleting record: " . $conn->error;
    }    
$conn->close();
?>