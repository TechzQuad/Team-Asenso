<?php
include '../incl/config.php';
$id=$_GET['id'];


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$query = "delete from attendance where id='$id'";
if (mysqli_query($conn, $query)) {
    echo "<script>
            alert('Record deleted successfully');
            window.location.href='attendance.php';
          </script>";
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
    
?>