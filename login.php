<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Team Asenso</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include'incl/links.php';?>
    <link href="incl/swa/dist/sweetalert.css" rel="stylesheet" type="text/css">
<script src="incl/swa/dist/sweetalert.min.js" type="text/javascript"></script>  
</head>
<style>
body {
    margin: 0;
    padding: 0;
    font-family: arial;
}
.loginform {
    background: #ffffff;
    width: 450px;
    color: #4caf50;
    top: 50%;
    left: 50%;
    position: absolute;
    transform: translate(-50%,-50%);
    box-sizing: border-box;
    padding: 40px 30px;
    border-radius: 20px;
    box-shadow: 0px 10px 29px 0px #e0e0e0;
}
.loginform p{
    margin: 0;
    padding: 0;
    font-weight: bold;
    font-family: "Papyrus";
    font-weight: bold;
}
.loginform h2 {
    font-size: 30px;
    margin: 30px 0px;
    text-transform: uppercase;
    font-weight: normal;
    text-align: center;
}
.loginform input{
    width: 100%;
    margin-bottom: 30px;
    font-family: "lucida handwriting";
    text-align: center;

}

.loginform input:hover{
    box-shadow: 0px 10px 29px 0px #e0e0e0;

}

.avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    overflow: hidden;
    margin: 0 auto;
    position: absolute;
    top: -55px;
    left: 0px;
    right: 0px;
    border: 6px solid #e6e6e6;
}
.avatar img {
    width: 100%;
    height: auto;
}
.loginform input[type="text"], input[type="password"]
{
    border: none;
    border-bottom: 1px solid #1e5220;
    background: transparent;
    outline: none;
    height: 40px;
    color: #333;
    font-size: 16px;
    border-radius: 50px;
}
.aa {
    border: none;
    border-bottom: 1px solid #1e5220;
    background: transparent;
    outline: none;
    height: 40px;
    color: #333;
    font-size: 16px; 
    width: 100%;
    text-align: center;
    font-family: "lucida handwriting";
    border-radius: 50px;
}
.aa:hover{
    box-shadow: 0px 10px 29px 0px #e0e0e0;

}
.ss{
    font-family: "lucida handwriting";
    font-weight: bold;
    color:#4CAF50;
}
.loginform input[type="submit"] {
    background: #4CAF50;
    color: #fff;
    font-size: 20px;
    padding: 7px 15px;
    border-radius: 20px;
    transition: 0.4s;
    border: none;
}
.loginform input[type="submit"]:hover {
    cursor: pointer;
    background: #1f5822;
}

.loginform button {
    background: #0099cc;
    color: #fff;
    font-size: 20px;
    padding: 7px 15px;
    border-radius: 20px;
    transition: 0.4s;
    border: none;
    width: 100%;
    font-family: "lucida handwriting";
}
.loginform button:hover {
    cursor: pointer;
    box-shadow: 0px 10px 29px 0px #1f5822;
}



.loginform a {
    text-decoration: none;
    font-size: 15px;
    line-height: 20px;
    color: #1e5220;
}
.loginform .have-not {
    float: right;
}
.loginform a:hover {
    color: #4caf50;
}

/*-- Responsive CSS --*/
@media(max-width: 576px) {
.loginform {
    width: 90%;
}
.loginform a {
    display: block;
    text-align: center;
    float: inherit !important;
    margin: 10px 0px;
}
}
  
</style>
 
<body> 
<?php
include 'incl/config.php';

$conn = new mysqli($servername, $username, $password, $dbname);
unset($_SESSION['id']);
unset($_SESSION['username']);



if (isset( $_POST['login'] ) ) {
    $uname = $_POST['username'];
    $pass = $_POST['password'];
    
    $query = "SELECT * FROM `users` WHERE `username` = '$uname'";
    $result_object = mysqli_query($conn, $query);
    $user_data = mysqli_fetch_assoc($result_object);
    
    if (is_null($user_data)) {
       echo "<script language = 'javascript'>
				swal({title: 'Failed To Login!',
                text: 'Incorrect email or password',
                type : 'error',
                showConfirmButton: false,
                timer: 1500,
                },
                function(){
                setTimeout(function(){
                location = '';
                });
                });
				</script>";
    }else {
        
        if($pass == $user_data['password']){
            
            if($user_data['position'] == "scanner"){
                $_SESSION['id'] = $user_data['id'];
                $_SESSION['username'] = $user_data['username'];
                echo "<script language = 'javascript'>
    				swal({title: 'Welcome!',
                    text: 'Team Asenso',
                    type : 'success',
                    showConfirmButton: false,
                    timer: 1000,
                    },
                    function(){
                    setTimeout(function(){
                    location = 'scanner.php';
                    });
                    });
    				</script>";            
            
            }else if($user_data['position']=="admin"){
                $_SESSION['id'] = $user_data['id'];
                $_SESSION['username'] = $user_data['username'];
                 echo "<script language = 'javascript'>
    				swal({title: 'Welcome!',
                    text: 'Team Asenso',
                    type : 'success',
                    showConfirmButton: false,
                    timer: 1000,
                    },
                    function(){
                    setTimeout(function(){
                    location = 'index.php';
                    });
                    });
    				</script>";

            }else{
                echo "<script language = 'javascript'>
    				swal({title: 'Failed To Login!',
                    text: 'Incorrect email or password',
                    type : 'error',
                    showConfirmButton: false,
                   timer: 1500,
                    },
                    function(){
                    setTimeout(function(){
                    location = '';
                    });
                    });
    				</script>";
                }  
            }else {
               echo "<script language = 'javascript'>
    				swal({title: 'Failed To Login!',
                    text: 'Incorrect email or password',
                    type : 'error',
                    showConfirmButton: false,
                   timer: 1500,
                    },
                    function(){
                    setTimeout(function(){
                    location = '';
                    });
                    });
    				</script>";
            }
            
        
    }
}

?> 
    <div class="loginform">
        <!-- Avatar Image -->
        <div class="avatar">
            <img src="pics/off_logo.png" alt="Avatar">
        </div>
      <h2>Team Asenso</h2>
        <!-- Start Form -->
        <form role="form-group" class="align-center" method="post" action="">
            <p>Username</p>
            <input type="text" name="username" placeholder="Enter Username" required>
            <p>Password</p> 
            <input type="password" name="password" placeholder="Enter Password" required>
            <input type="submit" name="login" value="Login">
            <button hidden type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" >Login Users</button>
        </form>        
    </div>
    
    
        <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title ss" id="staticBackdropLabel">Login Users</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
        <form role="form-group" class="align-center" method="post" action="login_pro.php">
        <div class="modal-body">
            <input type="email" name="uname" class="aa" placeholder="Enter Username" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary" value="Login" name="login">
        </div>
        </form>
        </div>
      </div>
    </div>
  
    
</body>
</html>








