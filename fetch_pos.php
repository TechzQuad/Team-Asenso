

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
    $query = "SELECT * FROM election WHERE pos='' && name LIKE '%{$_POST['query']}%' LIMIT 20";
        $result = mysqli_query($conn, $query);
         
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
             echo "<option value='".$row['name']."'>";
            }
        }else {
            echo "<p style='color:red'>User not found...</p>";
        }
}   
    

 

?>