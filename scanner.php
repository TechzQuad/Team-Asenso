
<!DOCTYPE html>
<html lang="en">
<head>
<?php include'incl/links.php';?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<link href="incl/swa/dist/sweetalert.css" rel="stylesheet" type="text/css">
<script src="incl/swa/dist/sweetalert.min.js" type="text/javascript"></script> 

<?php include'incl/auth.php';
    session_start();
    $id_session = $_SESSION['id'];
?>
</head>

<html>
    <body>
        <?php //include'nav.php';?>
        <div class="container-fluid" style="margin-top:25px">
            <center>
                <h1>You're Allowed to Scan Now!</h1>   
                <img  style="margin-top:40px" class="img-fluid img-thumbnail" src="https://www.kaspersky.com/content/en-global/images/repository/isc/2020/9910/a-guide-to-qr-codes-and-how-to-scan-qr-codes-1.jpg"/>
                <img  style="margin-top:0px" class="img-fluid" src="https://media.istockphoto.com/vectors/checkmark-icon-check-mark-vector-isolated-illustration-vector-id1205148147?k=20&m=1205148147&s=612x612&w=0&h=6WoITHTxFwIBVnfODxsh7wAzU3-AZFkg0YZ5U_8COqw="/>
            </center>
             
        </div>
       
    </body>
</html>


