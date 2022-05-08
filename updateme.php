<!DOCTYPE html>
<html lang="en">
<head>
  <?php include'incl/links.php';?>
</head>
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

    $sql = "SELECT * FROM election where id='$id'";
    $result = $conn->query($sql);
    $data =  $result->fetch_assoc();

        $sql1 = "UPDATE election SET status='voted' WHERE id='$id'";
        if ($conn->query($sql1) === TRUE) {
        echo "<script>
                alert('updated successfully!!');
                window.close();
            </script> ";
    } else {
      echo "Error updating record: " . $conn->error;
    }
    
    
    
?>
<div class="container-fluid mt-3">
    <center>
        <h1>Updated successfully !</h1><br><br>
        <h2>Thank you for Voted</h2>
      <br>
    </center>    
</div>

<br><br>
<div class="row">
<?php include'incl/footer.php';?>
</div>



</body>
</html>