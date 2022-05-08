
<?php
    include('incl/auth.php');
    require_once 'incl/config.php';
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "SELECT brgy,count(*) as t, 
    sum(CASE WHEN status = 'voted' && pos!='' THEN 1 ELSE 0 END) AS sv,
    sum(CASE WHEN status = 'not voted' && pos!='' THEN 1 ELSE 0 END) AS snv, 
    sum(CASE WHEN status = 'voted' && pos='' THEN 1 ELSE 0 END) AS v,
    sum(CASE WHEN status = 'not voted' && pos='' THEN 1 ELSE 0 END) AS nv
    FROM election GROUP BY brgy";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        $vt=0;$nvt=0;$tvt=0;
    		while($row = $result->fetch_assoc()) {
    		$svt += $row['sv'];
    		$snvt += $row['snv'];
    		$vt += $row['v'];
    		$nvt += $row['nv'];
    		$tvt += $row['t'];
    		$tt = $row['sv'] + $row['snv'] + $row['v'] + $row['nv'];
?>  
        <tr>
			<td><?=$row['brgy'];?></td>
			<td style="text-align:center"><?=$row['sv'];?></td>
			<td style="text-align:center"><?=$row['snv'];?></td>
			<td style="text-align:center"><?=$row['v'];?></td>
			<td style="text-align:center"><?=$row['nv'];?></td>
			<td style="text-align:center"><?=$tt;?></td>
		</tr>
	
<?php
         }?>
         	<tr>
			<td style="font-weight: bold;">Total</td>
			<td style="font-weight: bold;text-align:center"><?php echo $svt;?></td>
			<td style="font-weight: bold;text-align:center"><?php echo $snvt;?></td>
			<td style="font-weight: bold;text-align:center"><?php echo $vt;?></td>
			<td style="font-weight: bold;text-align:center"><?php echo $nvt;?></td>
			<td style="font-weight: bold;text-align:center"><?php echo $tvt;?></td>
		</tr>
    <?php	}else {
    		echo "0 results";
    	}

  
?>  
       














