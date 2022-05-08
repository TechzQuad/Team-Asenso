<?php

    include 'incl/config.php';
    include 'incl/auth.php';
    
    
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
        echo "<script language='javascript' type='text/javascript'>
                alert('updated successfully!!')
                window.location.href='update_status.php?id=$id';
                
            </script> ";
            echo "<script language='javascript' type='text/javascript'>7
                window.close();
                </script>
            ";
    } else {
      echo "Error updating record: " . $conn->error;
    }
?>