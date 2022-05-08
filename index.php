<?php
include('incl/auth.php');
require_once 'incl/config.php';
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);}
$sql_brgy = "SELECT brgy,count(*) as no from election WHERE pos!='' GROUP BY brgy";
$result_brgy = mysqli_query($conn, $sql_brgy);
$sql_st = "SELECT brgy,
sum(CASE WHEN status = 'voted' THEN 1 ELSE 0 END) AS vot,
sum(CASE WHEN status = 'not voted' THEN 1 ELSE 0 END) AS novot FROM election WHERE pos!='' GROUP BY brgy";
$result_st = mysqli_query($conn, $sql_st);?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include'incl/links.php';?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<link href="incl/swa/dist/sweetalert.css" rel="stylesheet" type="text/css">
<script src="incl/swa/dist/sweetalert.min.js" type="text/javascript"></script>
<style>.shadow-boxing{box-shadow:4px 4px 1px #c2d6d6}</style>
<script>
        $(document).ready(function () {

            setInterval( function() {
                $("#live_voted").load(location.href + " #live_voted");
             },2000 );

        });
          $(document).ready(function () {

            setInterval( function() {
                $("#live_notvoted").load(location.href + " #live_notvoted");
             },2000 );

        });
        $(document).ready(function () {

            setInterval( function() {
                $("#live_voted_p").load(location.href + " #live_voted_p");
             },6000 );

        });
        $(document).ready(function () {

            setInterval( function() {
                $("#live_notvoted_p").load(location.href + " #live_notvoted_p");
             },7000 );

        });
          $(document).ready(function () {

            setInterval( function() {
                $("#live_win_p").load(location.href + " #live_win_p");
             },11000 );

        });
        $(document).ready(function () {

            setInterval( function() {
                $("#live_loss_p").load(location.href + " #live_loss_p");
             },12000 );

        });
        $(document).ready(function () {

            setInterval( function() {
                $("#live_cong").load(location.href + " #live_cong");
             },15000 );

        });
        $(document).ready(function () {

            setInterval( function() {
                $("#live_coffee").load(location.href + " #live_coffee");
             },20000 );

        });
         window.setInterval('refresh()', 60000); 	
    function refresh() {
        window .location.reload();
    }
        //PIE charts
        google.charts.load('current', {'packages':['corechart']});  
        google.charts.setOnLoadCallback(drawChart);  
        function drawChart()  
        {  
        var datas = google.visualization.arrayToDataTable([  
            ['brgy', 'no'],  
            <?php  
            while($row = mysqli_fetch_array($result_brgy))  
            {  
               echo "['".$row["brgy"]."', ".$row["no"]."],";  
            }  
            ?>  
        ]);  
    var optionss = {  
          title: 'Total Supporters per Barangay',  
          //is3D:true,  
         };  
    var chart = new google.visualization.PieChart(document.getElementById('chart_div'));  
    chart.draw(datas, optionss);  
}  
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawStuff);
    function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ['Baranggay', 'Voted', 'Not Voted'],
          <?php  
            while($row = mysqli_fetch_array($result_st))  
            {  
               echo "['".$row["brgy"]."', ".$row["vot"].", ".$row["novot"]."],";  
            }  
            ?> 
        ]);
        var options = {
          width: 800,
          chart: {
            title: 'Supporters Status per Barangay',
            subtitle: 'Voted | Not Voted'
          },
          bars: 'vertical', // Required for Material Bar Charts.
          series: {
            0: { axis: 'distance' }, // Bind series 0 to an axis named 'distance'.
            1: { axis: 'brightness' } // Bind series 1 to an axis named 'brightness'.
          },
          axes: {
            x: {
              distance: {label: 'parsecs'}, // Bottom x-axis.
              brightness: {side: 'top', label: 'apparent magnitude'} // Top x-axis.
            }
          }
        };
      var chart = new google.charts.Bar(document.getElementById('dual_x_div'));
      chart.draw(data, options);
    };</script>
</head>
<?php
    $id_session = $_SESSION['id'];
    $id_sql = "SELECT * FROM users where id='$id_session' AND position='admin'";
    $id_result = $conn->query($id_sql);
    $id_data =  $id_result->fetch_assoc();
    $sqlclus = "SELECT count(*) AS totalclus FROM election where pos LIKE '%Cluster%'";
    $resultclus = $conn->query($sqlclus);
    $dataclus =  $resultclus->fetch_assoc();
    $sqlcoor = "SELECT count(*) AS totalcoor FROM election where pos LIKE '%Coordinator%'";
    $resultcoor = $conn->query($sqlcoor);
    $datacoor =  $resultcoor->fetch_assoc();
    $sqllead = "SELECT count(*) AS totallead FROM election where pos LIKE '%Leader%' and pos!='Cluster Precint Leader'";
    $resultlead = $conn->query($sqllead);
    $datalead =  $resultlead->fetch_assoc();
    $sqlmem = "SELECT count(*) AS totalmem FROM election where pos LIKE '%Member%'";
    $resultmem = $conn->query($sqlmem);
    $datamem =  $resultmem->fetch_assoc();
    $sql = "SELECT count(*) AS total FROM election where status='voted'";
    $result = $conn->query($sql);
    $data =  $result->fetch_assoc();
    $sql1 = "SELECT count(*) AS total FROM election where status='not voted'";
    $result1 = $conn->query($sql1);
    $data1 =  $result1->fetch_assoc();
    $sql2 = "SELECT * ,(SELECT count(*) AS total1 FROM election  where status='voted') * 100/(SELECT count(*) AS total FROM election where pos!='') as total3 FROM election";
    $result2 = $conn->query($sql2);
    $data2 =  $result2->fetch_assoc();
    $sql6 = "SELECT count(*) as bb FROM election where pos!='' AND pos!='DECEASED'";
    $result6 = $conn->query($sql6);
    $data6 =  $result6->fetch_assoc();
    $sql7 = "SELECT count(*) as totv FROM election";
    $result7 = $conn->query($sql7);
    $data7 =  $result7->fetch_assoc();
    $sql3 = "SELECT * ,(SELECT count(*) AS t1 FROM election where status='not voted' and pos!='') * 100/(SELECT count(*) AS total2 FROM election WHERE pos!='') as t FROM election ";
    $result3 = $conn->query($sql3);
    $data3 =  $result3->fetch_assoc();
    $sql8 = "SELECT (SELECT count(*) AS t1 FROM election where status='voted' and pos!='') * 100/(SELECT count(*) AS total2 FROM election ) as tt,
    (SELECT count(*) AS t1 FROM election where status='not voted') * 100/(SELECT count(*) AS total2 FROM election ) as tt2
    FROM election";
    $result8 = $conn->query($sql8);
    $data8 =  $result8->fetch_assoc();
    $query = "SELECT status, count(*) as number FROM election GROUP BY status";  
    $result4 = mysqli_query($conn, $query);  
    $quer = "SELECT pos, count(*) as numb FROM election GROUP BY pos";  
    $result5 = mysqli_query($conn, $quer);
    ?>
<?php $mini=50; $percent_wp=round($data8['tt']); echo $percent_wp;?>
<body class="body-bc" id="live_chart">
    <?php
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
				</script>";}?>
<?php include'incl/nav.php';?>
<div class="container-fluid" style="background-color:#ffffff;margin-top:5px"><br><div id='live_cong'>
<?php if($percent_wp >= $mini){echo"<center><img src='https://img1.picmix.com/output/stamp/thumb/6/2/3/4/534326_39fd0.gif' /><img src='https://www.icegif.com/wp-content/uploads/congratulations-icegif-2.gif' width='600' height='200'/><img src='https://img1.picmix.com/output/stamp/normal/0/4/3/4/534340_49c64.gif' /></center>";}else{ echo "";}?></div>
 <div class="row" >
  <div class="col-sm-2">
    <div class="card shadow-boxing" style="background-color: #008080;margin-bottom:20px">
      <div class="card-body">
        <h6 class="card-title" style="color:#FFFFFF; font-size: 15.2px;">Non Supporters&nbsp;<span class="badge bg-warning" style="float:right;"><?php $pp = (($data7['totv']-$data6['bb'])/$data7['totv']) * 100; echo round($pp) . '%'; ?></span></h6>
        <p class="card-text" style="font-size:30px;color:#FFFFFF"><del><?php echo $data7['totv']-$data6['bb'];?></del><small style="font-size:19px"><a href="non_sup?status=ns" class="badge rounded-pill" ?>view</a></small></p>
      </div>
    </div>
  </div>
    <div class="col-sm-2">
    <div class="card shadow-boxing" style="background-color: #008080;margin-bottom:20px">
      <div class="card-body">
        <h6 class="card-title" style="color:#FFFFFF">Supporters &nbsp;<span class="badge bg-info" style="float:right;"><?php $pp = ($data6['bb']/$data7['totv']) * 100; echo round($pp) . '%'; ?></span></h6>
        <p class="card-text" style="font-size:30px;color:#FFFFFF"><strong>
 <?php echo $data6['bb'];?></strong><small style="font-size:19px"><a href="non_sup?status=s" class="badge rounded-pill" ?>view</a></small></p>
      </div>
    </div>
  </div>
    <div class="col-sm-2">
    <div class="card shadow-boxing" style="background-color: #008080;margin-bottom:20px">
      <div class="card-body">
        <h6 class="card-title" style="color:#FFFFFF">Cluster Leaders</h6>
        <p class="card-text" style="font-size:30px;color:#FFFFFF"><strong><?php echo $dataclus['totalclus'];?></strong><small style="font-size:19px"><a href="position_all" class="badge rounded-pill" ?>view</a></small></p>
      </div>
    </div>
  </div>
  <div class="col-sm-2">
    <div class="card shadow-boxing" style="background-color: #008080;margin-bottom:20px">
      <div class="card-body">
        <h6 class="card-title" style="color:#FFFFFF">Coordinators</h6>
        <p class="card-text" style="font-size:30px;color:#FFFFFF"><strong><?php echo $datacoor['totalcoor'];?></strong><small style="font-size:19px"><a href="position_all?pos=Coordinator" class="badge rounded-pill" ?>view</a></small></p>
      </div>
    </div>
  </div>
   <div class="col-sm-2">
    <div class="card shadow-boxing" style="background-color: #008080;margin-bottom:20px">
      <div class="card-body">
        <h6 class="card-title" style="color:#FFFFFF">Leaders</h6>
        <p class="card-text" style="font-size:30px;color:#FFFFFF"><strong><?php echo $datalead['totallead'];?></strong><small style="font-size:19px"><a href="position_all?pos=Leader" class="badge rounded-pill" ?>view</a></small></p>
      </div>
    </div>
  </div>
   <div class="col-sm-2">
    <div class="card shadow-boxing" style="background-color: #008080;margin-bottom:20px">
      <div class="card-body">
        <h6 class="card-title" style="color:#FFFFFF">Members</h6>
        <p class="card-text" style="font-size:30px;color:#FFFFFF"><strong><?php echo $datamem['totalmem'];?> </strong><small style="font-size:19px"><a href="position_all?pos=Member" class="badge rounded-pill" ?>view</a></small></p>
      </div>
    </div>
  </div>
</div>
<div class="row" style="margin-left:5px">
  <div class="col-sm-3">   
 <div class="card border-info mb-3 shadow-boxing" style="max-width: 18rem;border-top-right-radius:50px;border-bottom-left-radius:40px">
  <div class="card-header bg-info border-info" style="border-top-right-radius:50px"><h3 style="color:#ffffff">VOTED</h3></div>
  <div class="card-body text-info">
    <h4 class="card-title label-info badge rounded-pill bg-info" style="font-size:35px"><strong id="live_voted"><?php echo $data['total'];?></strong></h4>
    <p class="card-text" style="font-size:77px" id="live_voted_p"><?php $percent=round($data2['total3']); echo $percent; ?> %</p>
  </div>
  <div class="card-footer bg-info border-info" style="border-top-right-radius:50px;border-bottom-left-radius:50px"><a href="voted" style="color:#ffffff;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="19" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
  <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
  <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
</svg>&nbsp;View<span class="spinner-grow spinner-grow-sm" style="margin-left:115px"></span> LIVE</a></div>
</div>  
</div>
  <div class="col-sm-3">   
 <div class="card border-secondary mb-3 shadow-boxing" style="max-width: 18rem;border-top-right-radius:50px;border-bottom-left-radius:40px">
  <div class="card-header bg-secondary border-secondary" style="border-top-right-radius:50px"><h3 style="color:#ffffff">NOT VOTED</h3></div>
  <div class="card-body text-secondary">
    <h4 class="card-title label-secondary badge rounded-pill bg-secondary" style="font-size:35px"><strong id="live_notvoted"><?php echo $data6['bb']-$data['total'];?></strong></h4>
    <p class="card-text" style="font-size:77px" id="live_notvoted_p"><?php $percent1=round($data3['t']); echo $percent1;?> %</p>
  </div>
  <div class="card-footer bg-secondary border-secondary" style="border-top-right-radius:50px;border-bottom-left-radius:50px"><a href="status?status=not voted" style="color:#ffffff"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="19" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
  <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
  <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
</svg>&nbsp;View<span class="spinner-grow spinner-grow-sm" style="margin-left:115px"></span> LIVE</a></div>
</div>  
</div>
<div class="col-sm-3">   
 <div class="card border-success mb-3 shadow-boxing" style="max-width: 18rem;border-top-left-radius:50px;border-bottom-right-radius:40px">
  <div class="card-header bg-success border-success" style="border-top-left-radius:50px"><h3 style="color:#ffffff">&nbsp;WINNING %</h3></div>
  <div class="card-body text-success">
    <h4 class="card-title label-success badge rounded-pill bg-success" style="font-size:35px">Out of <?php echo $data7['totv'];?></h4>
    <p class="card-text" style="font-size:64px;margin-bottom:19px" id="live_win_p"><?php $percent_wp=round($data8['tt']); echo $percent_wp; ?> % <img class="img" src="https://downtownls.org/wp-content/uploads/uparrow.gif" wdth="30px" height="35px"/></p>
  </div>
  <div class="card-footer bg-success border-success" style="border-top-left-radius:50px;border-bottom-right-radius:50px"><a href="#"  style="color:#ffffff"><span class="spinner-grow spinner-grow-sm" style="margin-left:170px"></span> LIVE</a></div>
</div>  
</div>
<div class="col-sm-3">   
 <div class="card border-danger mb-3 shadow-boxing" style="max-width: 18rem;border-top-left-radius:50px;border-bottom-right-radius:40px">
  <div class="card-header bg-danger border-danger" style="border-top-left-radius:50px"><h3 style="color:#ffffff">&nbsp;LOSSING %</h3></div>
  <div class="card-body text-danger">
    <h4 class="card-title label-danger badge rounded-pill bg-danger" style="font-size:35px">Out of <?php echo $data7['totv'];?></h4>
    <p class="card-text" style="font-size:64px;margin-bottom:19px" id="live_loss_p"><?php $percent_lp=round($data8['tt2']); echo $percent_lp; ?> % <img class="img" src="https://upload.wikimedia.org/wikipedia/commons/8/89/Red-animated-arrow-down.gif" wdth="30px" height="35px"/></p>
  </div>
  <div class="card-footer bg-danger border-danger" style="border-top-left-radius:50px;border-bottom-right-radius:50px"><a href="#"  style="color:#ffffff"><span class="spinner-grow spinner-grow-sm" style="margin-left:170px"></span> LIVE</a></div>
</div>  
</div>
</div>
<div class="row" style="background-color:#ffffff;margin-right:5px">
<div class="col-md-5">
      <!--Divs that will hold each control and chart-->
      <div id="chart_div" style="width: 500px; height: 500px;"></div>
   </div>
    <div class="col-md-7 table-responsive">
    <div id="dual_x_div" style="width: 500px; height: 500px;"></div>
   </div>
  </div><br><?php include'incl/footer.php';?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
</body>
</html>