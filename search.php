



<!DOCTYPE html>
<html lang="en">
<head>
<?php include'incl/links.php';?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link href="incl/swa/dist/sweetalert.css" rel="stylesheet" type="text/css">
<script src="incl/swa/dist/sweetalert.min.js" type="text/javascript"></script> 
<style>
      
</style>
<script>

    $(document).ready(function(){
        $("#search").keyup(function(){
            $.ajax({
              url: 'fetch_position_ajax.php',
              type: 'post',
              data: {search: $(this).val()},
              success: function(output){
                  $("#output").html(output);
              }
            });
        });
    });
    
</script> 
</head>
<body>   

<?php
include('incl/auth.php');

require_once 'incl/config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


    $id_session = $_SESSION['id'];
    $id_sql = "SELECT * FROM users where id='$id_session' AND position='admin'";
    $id_result = $conn->query($id_sql);
    $id_data =  $id_result->fetch_assoc();
    if($id_session==$id_data['id']){
        session_start();
    }else{
        unset($_SESSION['id']);
        unset($_SESSION['username']);
        echo "<script language = 'javascript'>
				swal({title: 'Failed To Login!',
                text: 'You cant access this Page',
                type : 'error',
                showConfirmButton: false,
                timer: 1000,
                },
                function(){
                setTimeout(function(){
                location = 'login.php';
                });
                });
				</script>";
    }

?>
<?php include'incl/nav.php';?>
<div class="container mt-3">
<br><br>
  <form>
     <label><h4>Search Here>></h4></label>
    <input type="text" class="form-control form-control-lg" id="search" placeholder="Search...">
    <div id="output"></div>
  </form>
</div><br>
<div class="row">
<?php include'incl/footer.php';?>
</div>
</body>
</html>