

<?php

include 'incl/config.php';
// include 'incl/auth.php';
// //load the ar library
// include 'phpqrcode/qrlib.php';

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
    date_default_timezone_set('Asia/Manila');
    $time=date('h:i:s A');
    if($data['status'] == "voted" ){
         echo "not voted";
       
    }else{
        $sql2 = "INSERT INTO `tbl_time` (`voter_id`, `real_time`) VALUES ('$id','$time')";
        if ($conn->query($sql2) === TRUE) {
            $sql1 = "UPDATE election SET status='voted' WHERE id='$id'";
                    
            if ($conn->query($sql1) === TRUE) {
             echo "voted";
           
            } else {
              echo "Error updating record: " . $conn->error;
            }
        }
    }


// if(isset($_POST['att'])){
//     date_default_timezone_set('Asia/Manila');
//     $date=date('Y-m-d h:i');
//     $date1=date('Y-m-d');
    
//     $sql_date = "SELECT * FROM election_date";
//     $result_date = $conn->query($sql_date);
//     $data_date =  $result_date->fetch_assoc();
    
//     $date2 =$data_date['date'];
    
//     $sql = "SELECT * FROM attendance where v_id='$id' && date like '$date1%'";
//     $result = $conn->query($sql);
//     $data1 =  $result->fetch_assoc();
//     if($data1['v_id'] == $id && $date1 != $date2 ){
//   echo "<script language = 'javascript'>
//     				swal({title: 'Checked Already!',
//                     text: '',
//                     type : 'warning',
//                     showConfirmButton: false,
//                   timer: 1000,
//                     },
//                     function(){
//                     setTimeout(function(){
//                     history.back();
//                     });
//                     });
//     				</script>";
            
//     }else{
//         if($date1 != $date2 ){
//             $sql2 = "INSERT INTO `attendance`(`id`, `v_id`, `date`) VALUES ('','$id','$date')";
//             if ($conn->query($sql2) === TRUE) {
//              echo "<script language = 'javascript'>
//     				swal({title: 'Attendance Check!',
//                     text: '',
//                     type : 'success',
//                     showConfirmButton: false,
//                   timer: 1500,
//                     },
//                     function(){
//                     setTimeout(function(){
//                     history.back();
//                     });
//                     });
//     				</script>";
                
//             } else {
//               echo "Error: " . $sql . "<br>" . $conn->error;
//             }
//         }
//     }
// }

?>

