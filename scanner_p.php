
<!DOCTYPE html>
<html lang="en">
<head>
<?php include'incl/links.php';?>
<script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>  
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>

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
                <h1></h1>
                <div class="col-md-6">
                    <video id="preview" width= "100%" ></video>
                </div>
                <div class="col-md-6">
                    <input type="text" id="text" readonly="" placeholder="Scan QR Code" class="form-control">
                </div>
            </center>
             
        </div>
       <script>
           let scanner = new Instascan.Scanner({ video: document.getElementById('preview')})
           Instascan.Camera.getCameras().then(function(cameras){
               if(cameras.length > 0){
                   scanner.start(cameras[1]);
               }else{
                   alert('no camera found');
               }
           }).catch(function(e){
               console.error(e);
           });
           
           scanner.addListener('scan', function(c){
               document.getElementById('text').value=c;
               window.location.href = c;
           });
           
       </script>
       
       
    </body>
</html>


