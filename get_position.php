

<?php
//fetch.php
require_once 'incl/config.php';



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
/*
* Write your logic to manage the data
* like storing data in database
*/

$pos = $_GET['pos'];
$id = explode("/", $pos);
$pos_exp=explode(".",$id[0]);
$sql = "SELECT * FROM election where id='".$id[1]."'";
$result = $conn->query($sql);
$data =  $result->fetch_assoc();
$brgy_exp = explode(" ",$data['bargy']);
if($pos_exp[0] == 'Coordinator'){
    echo"<label>Name of Cluster Precint Leader</label>";
    echo "<select type='name' name='cname' class='form-control ihover' id='search' required>
							<option value=''></option>";
    $query = "SELECT * FROM election WHERE pos like '%Cluster Precint Leader%' AND brgy='".$data['brgy']."' order by name ";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($user = mysqli_fetch_array($result)) {
              echo"<option value='".$user['name']."'>".$user['name']."</option>";
            }
      }
}else if($pos_exp[0] == 'Leader'){
    echo"<label>Name of Coordinator</label>";
    echo "<select type='name' name='cname' class='form-control ihover' id='search' required>
							<option value=''></option>";
    $query = "SELECT * FROM election WHERE pos like '%Coordinator%' AND brgy='".$data['brgy']."' order by name";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($user = mysqli_fetch_array($result)) {
              echo"<option value='".$user['name']."'>".$user['name']."</option>";
            }
      }
}else if($pos_exp[0] == 'Member'){
    echo"<label>Name of Leader</label>";
    echo "<select type='name' name='cname' class='form-control ihover' id='search' required>
							<option value=''></option>";
    $query = "SELECT * FROM election WHERE pos like '%Leader%' AND brgy='".$data['brgy']."' order by name";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($user = mysqli_fetch_array($result)) {
              echo"<option value='".$user['name']."'>".$user['name']."</option>";
            }
      }
} 

 

?>