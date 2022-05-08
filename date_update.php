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

if(ISSET($_POST['update_date'])){
    $date = $_POST['date'];
    echo $date;
     $sql1 = "UPDATE election_date SET date='$date'";
        if ($conn->query($sql1) === TRUE) {
          echo "<script>
                    alert('updated successfully!!');
                    window.location.href='set_election_date.php';
                </script> ";
        } else {
          echo "Error updating record: " . $conn->error;
        }
}


?>