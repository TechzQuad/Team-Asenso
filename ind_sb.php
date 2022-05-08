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
@page  
{ 
    size:8.5in 13in;
    /* this affects the margin in the printer settings */ 
    margin: 0mm 0 0 0mm; 
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
    <?php if($row['brgy']=='Tabun-ac' || $data['brgy']=='Tabun-ac'){?>
<div class="col-sm-6" style="margin-bottom:69.8px;">
    <div class="card mb-6 b"  style="max-width:347px; border:2px solid #000000;margin-left:5px;border-radius:5px; text-align:center;">
        <div class="col-mb-2">
            <center>
            <p style="background:white;background-color:#C10000;color:#ffffff"><strong style='text-align:center;margin-left:50px'>SAMPLE BALLOT</strong><small style="float: right; margin-right: 5px">&nbsp;<?php echo $data['pn'];?></small></p>
            <img src="<?php echo $file;?>" class="img img-thumbnail img-rounded img-circle" style="width:100px; height: 100px; float:center;">
            <p style="text-align:center; font-size:15px;"><?php echo $data['name'];?></p><hr>
            <p style="font-size:10px; text-align:center;"><strong>MAY 9, 2022 NATIONAL AND LOCAL ELECTIONS</strong></p>
            <img src="pics/tabun-ac_bbm_angkla.png" class="img" width="340px" height="928px"><br>
          </center>
        </div>
      </div>
     </div>
    
    
     <?php }elseif($row['brgy']=='San Jose' || $data['brgy']=='San Jose'){?>
     <div class="col-sm-6" style="margin-bottom:69.8px;">
    <div class="card mb-6 b"  style="max-width:347px; border:2px solid #000000;margin-left:5px;border-radius:5px; text-align:center;">
        <div class="col-mb-2">
            <center>
            <p style="background:white;background-color:#C10000;color:#ffffff"><strong style='text-align:center;margin-left:50px'>SAMPLE BALLOT</strong><small style="float: right; margin-right: 5px">&nbsp;<?php echo $data['pn'];?></small></p>
            <img src="<?php echo $file;?>" class="img img-thumbnail img-rounded img-circle" style="width:100px; height: 100px; float:center;">
            <p style="text-align:center; font-size:15px;"><?php echo $data['name'];?></p><hr>
            <p style="font-size:10px; text-align:center;"><strong>MAY 9, 2022 NATIONAL AND LOCAL ELECTIONS</strong></p>
            <img src="pics/sanjose_lacson_ako.png" class="img" width="340px" height="928px"><br>
          </center>
        </div>
      </div>
     </div>
     
      <?php }elseif($row['brgy']=='Gen. Luna' || $data['brgy']=='Gen. Luna'){?>
     <div class="col-sm-6" style="margin-bottom:69.8px;">
    <div class="card mb-6 b"  style="max-width:347px; border:2px solid #000000;margin-left:5px;border-radius:5px; text-align:center;">
        <div class="col-mb-2">
            <center>
            <p style="background:white;background-color:#C10000;color:#ffffff"><strong style='text-align:center;margin-left:50px'>SAMPLE BALLOT</strong><small style="float: right; margin-right: 5px">&nbsp;<?php echo $data['pn'];?></small></p>
            <img src="<?php echo $file;?>" class="img img-thumbnail img-rounded img-circle" style="width:100px; height: 100px; float:center;">
            <p style="text-align:center; font-size:15px;"><?php echo $data['name'];?></p><hr>
            <p style="font-size:10px; text-align:center;"><strong>MAY 9, 2022 NATIONAL AND LOCAL ELECTIONS</strong></p>
            <img src="pics/genluna_lacson_angkla.png" class="img" width="340px" height="928px"><br>
          </center>
        </div>
      </div>
     </div>
     
     
     
    <?php }else{?>
     <div class="col-sm-6" style="margin-bottom:69.8px;">
    <div class="card mb-6 b"  style="max-width:347px; border:2px solid #000000;margin-left:5px;border-radius:5px; text-align:center;">
        <div class="col-mb-2">
            <center>
            <p style="background:white;background-color:#C10000;color:#ffffff"><strong style='text-align:center;margin-left:50px'>SAMPLE BALLOT</strong><small style="float: right; margin-right: 5px">&nbsp;<?php echo $data['pn'];?></small></p>
            <img src="<?php echo $file;?>" class="img img-thumbnail img-rounded img-circle" style="width:100px; height: 100px; float:center;">
            <p style="text-align:center; font-size:15px;"><?php echo $data['name'];?></p><hr>
            <p style="font-size:10px; text-align:center;"><strong>MAY 9, 2022 NATIONAL AND LOCAL ELECTIONS</strong></p>
            <img src="pics/sb.png" class="img" width="340px" height="928px"><br>
          </center>
        </div>
      </div>
     </div>
     <?php }?>
<script type="text/javascript">
	function PrintPage() {
		window.print();
	}
</script> 
</div>
</body>
</html>