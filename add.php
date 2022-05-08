<?php
	require_once 'incl/config.php';
	


    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
	if(ISSET($_POST['save'])){
	    
        $id = $_GET['id'];  
		$name = $_POST['name'];
		$preno = $_POST['preno'];
		$brgy = $_POST['brgy'];
		$prk = $_POST['prk'];
		$standing= $_POST['standing'];
		
		$sql = "SELECT * FROM election WHERE name='$name'";
        $qry = mysqli_query($conn,$sql);
        $data = mysqli_fetch_array($qry);
        
        $sql1 = "SELECT * FROM election WHERE id='$id'";
        $qry1 = mysqli_query($conn,$sql1);
        $data1 = mysqli_fetch_array($qry1);
		if($name == $data['name']){
		    echo "<script>
                    alert('Already Exist!!');
                    window.location.href='cluster.php';
                </script>";
		    
		}else{
		    if($data1['pos']=='Cluster Precint Leader'){
                $sql = "INSERT INTO `election`(`id`, `name`, `pn`, `pos`, `leader_id`, `coordinator_id`, `cluster_id`, `prk`, `brgy`, `standing`, `status`, `remarks`) VALUES ('','$name','$preno','Coordinator','','','$id','$prk','$brgy','$standing','not voted','')";
                
                if ($conn->query($sql) === TRUE) {
        
                    echo "<script>
                    alert('Successfully added!');
                    
                    window.location.href='position.php?id=$id';
                    </script>";
        
                } else {
                  echo "Error: " . $sql . "<br>" . $conn->error;
                }
        	}else{
        	    $sql = "INSERT INTO `election`(`id`, `name`, `pn`, `pos`, `leader_id`, `coordinator_id`, `cluster_id`, `prk`, `brgy`, `standing`, `status`, `remarks`) VALUES ('','$name','$preno','Cluster Precint Leader','','','','$prk','$brgy','$standing','not voted','')";
        	    if ($conn->query($sql) === TRUE) {
        
                    echo "<script>
                    alert('Successfully added!');
                    
                    window.location.href='position.php';
                    </script>";
        
                } else {
                  echo "Error: " . $sql . "<br>" . $conn->error;
                }
        	}
        	
		}
    }
        
        
    if(ISSET($_POST['save_coor'])){
		$name = $_POST['name'];
		$preno = $_POST['preno'];
		$add = $_POST['address'];
		$sql = "SELECT * FROM voters WHERE name='$name'";
        $qry = mysqli_query($conn,$sql);
        $data = mysqli_fetch_array($qry);
        
        if($name == $data['name']){
		    echo "<script>
                    alert('Already Exist!!');
                    window.location.href='coordinator.php?id=". $id . "';
                </script>";
		    
		}else{
		    $sql = "INSERT INTO `voters` VALUES('', '','$name', '$add', '$preno', 'COORDINATOR', '$id', '', '', 'Not Voted', '', '')";
            if ($conn->query($sql) === TRUE) {
    
                echo "<script>
                alert('Successfully added!');
                
              window.location.href='coordinator.php?id=". $id . "';
                </script>";

        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
            }
    
        }
    }
        
   if(ISSET($_POST['save_lead'])){
		$name = $_POST['name'];
		$preno = $_POST['preno'];
		$add = $_POST['address'];
		
		$sql = "SELECT * FROM voters WHERE name='$name'";
        $qry = mysqli_query($conn,$sql);
        $data = mysqli_fetch_array($qry);
        
        if($name == $data['name']){
		    echo "<script>
                    alert('Already Exist!!');
                    window.location.href='coordinator.php?id=". $id . "';
                </script>";
		    
		}else{
        $sql = "INSERT INTO `voters` VALUES('', '','$name', '$add', '$preno', 'LEADER', '', '$id', '', 'Not Voted', '', '')";

        if ($conn->query($sql) === TRUE) {

            echo "<script>
            alert('Successfully added!');
            
          window.location.href='leader.php?id=". $id . "';
            </script>";

        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
            }
		}
    }  
    
    
    
    if(ISSET($_POST['save_mem'])){
		$name = $_POST['name'];
		$preno = $_POST['preno'];
		$add = $_POST['address'];
		$stand = $_POST['stand'];
		
		$sql = "SELECT * FROM voters WHERE name='$name'";
        $qry = mysqli_query($conn,$sql);
        $data = mysqli_fetch_array($qry);
    
        if($name == $data['name']){
		    echo "<script>
                    alert('Already Exist!!');
                    window.location.href='member.php?id=". $id . "';
                </script>";
		    
		}else{
            $sql = "INSERT INTO `voters` VALUES('', '$stand','$name', '$add', '$preno', 'MEMBER', '', '', '$id', 'Not Voted', '', '')";
    
            if ($conn->query($sql) === TRUE) {
    
                echo "<script>
                alert('Successfully added!');
                
              window.location.href='member.php?id=". $id . "';
                </script>";
    
            } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }  
    }
?>













