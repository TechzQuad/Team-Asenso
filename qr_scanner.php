
<!DOCTYPE html>
<html>
<head>
	<title>JQuery HTML5 QR Code Scanner</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
</head>
<body>
  
    <h1>JQuery HTML5 QR Code Scanner</h1>
    
    <video id="preview"></video>
    <input type="text" name="text" id="text" readonly="" class="form-control">
    
    <script type="text/javascript">
      let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), mirror: false });
      scanner.addListener('scan', function (content) {
        alert(content);
      });
      Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
          scanner.start(cameras[1]);
        } else {
          console.error('No cameras found.');
        }
      }).catch(function (e) {
        console.error(e);
      });
      scanner.addListener('scan',function(c){
          document.getElementById("text").value=c;
          
      })
    </script>
   
</body>
</html>