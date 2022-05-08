<?php
    include 'incl/config.php';
    //load the ar library
    include 'phpqrcode/qrlib.php';
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $ids = $_GET['id'];
    $sql1 = "SELECT * FROM election WHERE id='$ids'";
    $qry = mysqli_query($conn,$sql1);
    $data = mysqli_fetch_array($qry);
    
    
    //data to be stored in qr
    $text = "https://onetechzquad.tech/update_status.php?id=". $data['id'] . "&&name=" . $data['name'];
      
    //file path
    $file = "img/". $data['id'];
      
    //other parameters
    $ecc = 'H';
    $pixel_size = 2;
    $frame_size = 2;
      
    // Generates QR Code and Save as PNG
    QRcode::png($text, $file, $ecc, $pixel_size, $frame_size);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include'incl/links.php';?>
</head>
<style>
    .b {
       
    }
    h5{
        font-family:Arial Black;
        background: white;
    }
@media print {
    #PrintButton {
        display :  none;
    }
    .page-break{
        page-break-after: always;
    }

}
</style>
<script language="javascript" type="text/javascript">
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML = 
              "<html><head><title></title></head><body>" + 
              divElements + "</body>";
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;
             
        };
</script>
<body>
    
<div class="container-fluid mt-3 d-print-inline-flex table-responsive" id="printablediv">
    <center><button id="PrintButton" class="bi bi-printer btn-success" onclick="PrintPage()">Print</button></center><br>
    <div class="col-sm-4" style="margin-bottom:20px">
    <div class="card mb-3 b"  style="max-width:317px;max-height:202px; border:2px solid #000000;margin-left:10px;border-radius:5px; text-align:center;">
        <div class="col-mb-2">
            <center>
            <p style="text-align:center; background:white;background-color:#C10000;color:#ffffff"><strong>Team Asenso!</strong></p>
          <img src="<?php echo $file;?>" class="img img-thumbnail img-rounded img-circle" style="padding:5px;width:100px">
          </center>
        </div>
        <div class="col-mb-4">
            <div class="card-body">
                <h5 class="card-title" style="text-align:center; font-size: 14px;background-color:#C10000;padding:2px;border-radius:20px;color:#ffffff"><?php echo $data['name'];?></h5>
            </div>
        </div>
      </div>
     </div>  
    
    
</div>

<script type="text/javascript">
	function PrintPage() {
		window.print();
	}
</script>  
</body>
</html>