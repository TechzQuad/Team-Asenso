<?php
session_start();
include 'incl/config.php';

$conn = new mysqli($servername, $username, $password, $dbname);
unset($_SESSION['id']);

if (isset( $_POST['login'] ) ) {
    $uname = $_POST['uname'];
    $explode = explode('@',$uname);
    
    $query = "SELECT * FROM `users` WHERE `username` = '$uname'";
    $result_object = mysqli_query($conn, $query);
    $user_data = mysqli_fetch_assoc($result_object);
    
    
    $query1 = "SELECT * FROM `election` WHERE `id` = '".$explode[1]."'";
    $result = mysqli_query($conn, $query1);
    $data = mysqli_fetch_assoc($result);
    $explode_name = explode(',', $data['name']);
    $log = $explode_name[0] ."@".$data['id'];
   if(is_null($data)) {
        echo "<script>
                    swal({
                        icon: 'success',
                        });
                    window.location.href='scan.php';
                </script>"; 
       
   }else{
       if($log==$uname){
           $_SESSION['id'] = $data['id'];
           $hash_id = md5($data['id']);
           echo "
            <script>
                window.location.href='user.php?id=$hash_id';
            </script>";
       }
       
   }
}
?>