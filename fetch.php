

<?php
//fetch.php
include 'incl/config.php';
$conn = new mysqli($servername, $username, $password, $dbname);
 
/*
* Write your logic to manage the data
* like storing data in database
*/
if (isset($_POST['query'])) {
    $id = $_GET['id'];
    $pos = $_POST['query'];
    $sql = "SELECT * FROM election where id='$id'";
    $result = $conn->query($sql);
    $data =  $result->fetch_assoc();
    
    $sql1 = "SELECT * FROM election where id='".$data['cluster_id']."'";
    $result1 = $conn->query($sql1);
    $data1 =  $result1->fetch_assoc();
    
    $sql2 = "SELECT * FROM election where id='".$data['coordinator_id']."'";
    $result2 = $conn->query($sql2);
    $data2 =  $result2->fetch_assoc();
    
    // echo "<script>alert('".$data2['name']."');</script>";
    
    if($data1['pos']=='Cluster Precint Leader'){    
        $query = "SELECT * FROM election WHERE pos='Cluster Precint Leader' && name LIKE '%{$_POST['query']}%' order by name LIMIT 20";
        $result = mysqli_query($conn, $query);
     
        if (mysqli_num_rows($result) > 0) {
            while ($user = mysqli_fetch_array($result)) {
                echo"<option value='".$user['name']."'>";
            }
      } else {
        echo "<p style='color:red'>User not found...</p>";
      }
    }else if($data2['pos']=='COORDINATOR'){
        $query = "SELECT * FROM election WHERE pos='COORDINATOR' && name LIKE '{$_POST['query']}%' LIMIT 20";
        $result = mysqli_query($conn, $query);
         
        if (mysqli_num_rows($result) > 0) {
            while ($user = mysqli_fetch_array($result)) {
             echo "<option value='".$user['name']."'>";
            }
        }else {
            echo "<p style='color:red'>User not found...</p>";
        }
    }else{
        $query = "SELECT * FROM voters WHERE pos='LEADER' && name LIKE '{$_POST['query']}%' LIMIT 200";
        $result = mysqli_query($conn, $query);
         
        if (mysqli_num_rows($result) > 0) {
            while ($user = mysqli_fetch_array($result)) {
             echo "<option value='".$user['name']."'>";
            }
        }else {
            echo "<p style='color:red'>User not found...</p>";
        }
        
    }

}   
    

 

?>