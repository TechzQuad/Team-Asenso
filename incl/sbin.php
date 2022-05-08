
<?php if($row['brgy']=='Tabun-ac' || $data['brgy']=='Tabun-ac'){?>
<div class="col-sm-6" style="margin-bottom:69.8px;">
    <div class="card mb-6 b"  style="max-width:347px; border:2px solid #000000;margin-left:5px;border-radius:5px; text-align:center;">
        <div class="col-mb-2">
            <center>
            <p style="background:white;background-color:#C10000;color:#ffffff"><strong style='text-align:center;margin-left:50px'>SAMPLE BALLOT</strong><small style="float: right; margin-right: 5px">&nbsp;<?php echo $row['pn'];?></small></p>
            <img src="<?php echo $file;?>" class="img img-thumbnail img-rounded img-circle" style="width:100px; height: 100px; float:center;">
            <p style="text-align:center; font-size:15px;"><?php echo $row['name'];?></p><hr>
            <p style="font-size:10px; text-align:center;"><strong>MAY 9, 2022 NATIONAL AND LOCAL ELECTIONS</strong></p>
            <img src="pics/tabun-ac_bbm_angkla.png" class="img" width="340px" height="948px"><br>
          </center>
        </div>
      </div>
     </div>
    
    
     <?php }elseif($row['brgy']=='San Jose' || $data['brgy']=='San Jose'){?>
     <div class="col-sm-6" style="margin-bottom:69.8px;">
    <div class="card mb-6 b"  style="max-width:347px; border:2px solid #000000;margin-left:5px;border-radius:5px; text-align:center;">
        <div class="col-mb-2">
            <center>
            <p style="background:white;background-color:#C10000;color:#ffffff"><strong style='text-align:center;margin-left:50px'>SAMPLE BALLOT</strong><small style="float: right; margin-right: 5px">&nbsp;<?php echo $row['pn'];?></small></p>
            <img src="<?php echo $file;?>" class="img img-thumbnail img-rounded img-circle" style="width:100px; height: 100px; float:center;">
            <p style="text-align:center; font-size:15px;"><?php echo $row['name'];?></p><hr>
            <p style="font-size:10px; text-align:center;"><strong>MAY 9, 2022 NATIONAL AND LOCAL ELECTIONS</strong></p>
            <img src="pics/sanjose_lacson_ako.png" class="img" width="340px" height="948px"><br>
          </center>
        </div>
      </div>
     </div>
     
      <?php }elseif($row['brgy']=='Gen. Luna' || $data['brgy']=='Gen. Luna'){?>
     <div class="col-sm-6" style="margin-bottom:69.8px;">
    <div class="card mb-6 b"  style="max-width:347px; border:2px solid #000000;margin-left:5px;border-radius:5px; text-align:center;">
        <div class="col-mb-2">
            <center>
            <p style="background:white;background-color:#C10000;color:#ffffff"><strong style='text-align:center;margin-left:50px'>SAMPLE BALLOT</strong><small style="float: right; margin-right: 5px">&nbsp;<?php echo $row['pn'];?></small></p>
            <img src="<?php echo $file;?>" class="img img-thumbnail img-rounded img-circle" style="width:100px; height: 100px; float:center;">
            <p style="text-align:center; font-size:15px;"><?php echo $row['name'];?></p><hr>
            <p style="font-size:10px; text-align:center;"><strong>MAY 9, 2022 NATIONAL AND LOCAL ELECTIONS</strong></p>
            <img src="pics/genluna_lacson_angkla.png" class="img" width="340px" height="948px"><br>
          </center>
        </div>
      </div>
     </div>
     
     
     
    <?php }else{?>
     <div class="col-sm-6" style="margin-bottom:69.8px;">
    <div class="card mb-6 b"  style="max-width:347px; border:2px solid #000000;margin-left:5px;border-radius:5px; text-align:center;">
        <div class="col-mb-2">
            <center>
            <p style="background:white;background-color:#C10000;color:#ffffff"><strong style='text-align:center;margin-left:50px'>SAMPLE BALLOT</strong><small style="float: right; margin-right: 5px">&nbsp;<?php echo $row['pn'];?></small></p>
            <img src="<?php echo $file;?>" class="img img-thumbnail img-rounded img-circle" style="width:100px; height: 100px; float:center;">
            <p style="text-align:center; font-size:15px;"><?php echo $row['name'];?></p><hr>
            <p style="font-size:10px; text-align:center;"><strong>MAY 9, 2022 NATIONAL AND LOCAL ELECTIONS</strong></p>
            <img src="pics/sb.png" class="img" width="340px" height="948px"><br>
          </center>
        </div>
      </div>
     </div>
     <?php }?>