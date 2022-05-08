<?php
include('incl/auth.php');

require_once 'incl/config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$ids = $_GET['id'];
$id = explode('/',$_GET['id']);
$sql1 = "SELECT *, SUBSTRING_INDEX(pos, ' ', 1) as co, SUBSTRING_INDEX(pos, ' & ', -1) as lead, SUBSTRING_INDEX(pos, ' & ', 1) as mem FROM election WHERE id='".$id[0]."'";
$qry = mysqli_query($conn,$sql1);
$data = mysqli_fetch_array($qry);
$cluster_id=$data['cluster_id'];
$count=count($id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include'incl/links.php';?>
<link href="incl/swa/dist/sweetalert.css" rel="stylesheet" type="text/css">
<script src="incl/swa/dist/sweetalert.min.js" type="text/javascript"></script> 
<style>
    .a{
        text-decoration: none;
    }
    .a:hover{
        color: white; 
        text-shadow: 2px 2px red;
    }
    
    
</style>
</head>
<body>   
<?php 
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

include'incl/nav.php';?>
<div class="container mt-3">
<!--coordinator table    -->
  <?php if(($data['pos'] == 'Cluster Precint Leader' || $data['mem'] == 'Cluster Precint Leader') && $count<3){?>
<nav>
</nav>
<h1>Coordinator Table</h1> 
<!--Leader Table-->
<?php }else if(($data['co'] == 'Coordinator' || $data['lead'] == 'Coordinator') &&  $count == 2){?>
<nav>
</nav>
  <h1> Leader Table</h1>
<!--member table  -->
  <?php }else if(($data['co'] == 'leader' || $data['co'] == 'Leader' || $data['lead'] == 'Leader') && $count == 3){?>
<nav>
</nav>
  <h1> Member Table</h1>
<!--Cluster Leader Precint table-->
<?php }else{?>
<nav>
</nav>
  <h1> Cluster Precint Leader Table</h1>
<?php }?>  
<a href="qr.php?id=<?php echo $ids;?>" class="btn btn-secondary pull-right" target="_blank">Browse QR>></a>
<a href="sample_ballot.php?id=<?php echo $ids;?>" class="btn btn-secondary pull-right" target="_blank">Browse Sample Ballot>></a><br><br>
 <table id="kram" class="display" style="width:100%">
    <thead>
      <tr>
        <th>Name</th>
        <th>Address</th>
        <th>Precinct #</th>
        <th>Position</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
<?php
//coordinator table
if(($data['pos'] == 'Cluster Precint Leader' || $data['pos'] == 'Cluster Precint Leader & Coordinator' || $data['pos'] == 'Cluster Precint Leader & Leader') && $count==1 && $id[0] != $id[1]){
    $sql = "SELECT * FROM election where
    (pos like '%Coordinator%') &&
    cluster_id='".$id[0]."' && 
    pos!='Cluster Precint Leader' order by pos";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        
            while($row = $result->fetch_assoc()) {
                
                if($row['remarks']!=""){
                    echo "<tr style='background-color:red;'><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
                    <td>".$row["brgy"].", ".$row["prk"] ."</td>
                    <td>".$row["pn"]."</td>
                    <td>".$row["pos"]."</td>";
                    if($row["status"]!="voted"){
                        echo "<td><span class='badge bg-danger'>".$row["status"]."</span></td>";
                    }else{
                        echo "<td><span class='badge bg-success'><a href='update.php?id=".$row["id"]."' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                        
                    }
                    echo "<td>
                        <a class='badge bg-success' href='position.php?id=" . $row["id"]."/".$id[0]. "' id=". $row["id"].">View Leaders</a>
                        <a class='badge bg-primary' href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                        </td>
                        </tr>";
                }else{  
                echo "<tr><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
                    <td>".$row["brgy"].", ".$row["prk"] ."</td>
                    <td>".$row["pn"]."</td>
                    <td>".$row["pos"]."</td>";
                    if($row["status"]!="voted"){
                        echo "<td><span class='badge bg-danger'><a href='update.php?id=".$row["id"]."' class='btn badge bg-danger a'>".$row["status"]."</a></span></td>";
                    }else{
                        echo "<td><span class='badge bg-success'><a href='update.php?id=".$row["id"]."' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                        
                    }
                    echo "<td>
                        <a class='badge bg-success' href='position.php?id=" . $row["id"]."/".$id[0]."' id=". $row["id"].">View Leaders</a>
                        <a class='badge bg-primary' href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                        </td>
                        </tr>";
            }
        }
    } else {
      echo "0 results";
    }


// leader table 
}else if(($data['co'] == 'Coordinator' || $data['lead'] == 'Coordinator') &&  $count == 2){
    $sql = "SELECT * FROM election where (pos like '%Leader%') && coordinator_id='".$id[0]."' && pos!='Cluster Precint Leader' && pos!='Cluster Precint Leader & Coordinator'";
    $result = $conn->query($sql);
    
    
    if ($result->num_rows > 0) {
        
            while($row = $result->fetch_assoc()) {
                if($row['remarks']!=""){
                    echo "<tr style='background-color:red;'><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
                    <td>".$row["brgy"].", ".$row["prk"] ."</td>
                    <td>".$row["pn"]."</td>
                    <td>".$row["pos"]."</td>";
                    if($row["status"]!="voted"){
                        echo "<td><span class='badge bg-danger'>".$row["status"]."</span></td>";
                    }else{
                        echo "<td><span class='badge bg-success'><a href='update.php?id=".$row["id"]."' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                    }
                    echo "<td>
                        <a class='badge bg-success' href='position.php?id=" . $row["id"]."/".$id[0]."/".$id[1]. "' id=". $row["id"].">View Leaders</a>
                        <a class='badge bg-primary' href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                        </td>
                        </tr>";
            }else{  
                echo "<tr><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
                    <td>".$row["brgy"].", ".$row["prk"] ."</td>
                    <td>".$row["pn"]."</td>
                    <td>".$row["pos"]."</td>";
                    if($row["status"]!="voted"){
                        echo "<td><span class='badge bg-danger'><a href='update.php?id=".$row["id"]."' class='btn badge bg-danger a'>".$row["status"]."</a></span></td>";
                    }else{
                        echo "<td><span class='badge bg-success'><a href='update.php?id=".$row["id"]."' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                        
                    }
                    echo "<td>
                        <a class='badge bg-success' href='position.php?id=" . $row["id"]."/".$ids. "' id=". $row["id"].">View Members</a>
                        <a class='badge bg-primary' href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                        </td>
                        </tr>";
            }
        }
    } else {
      echo "0 results";
    }
    
    
    
    
//member table
}else if(($data['co'] == 'leader' || $data['co'] == 'Leader' || $data['lead'] == 'Leader') && $count == 3){
    
    $sql = "SELECT * FROM election where (pos like '%Member%') && leader_id='".$id[0]."'";
    $result = $conn->query($sql);
    
    
    if ($result->num_rows > 0) {
        
            while($row = $result->fetch_assoc()) {
                if($row['remarks']!=""){
                    echo "<tr style='background-color:red;'><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
                    <td>".$row["brgy"].", ".$row["prk"] ."</td>
                    <td>".$row["pn"]."</td>
                    <td>".$row["pos"]."</td>";
                    if($row["status"]!="voted"){
                        echo "<td><span class='badge bg-danger'>".$row["status"]."</span></td>";
                    }else{
                        echo "<td><span class='badge bg-success'><a href='update.php?id=".$row["id"]."' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                    }
                    echo "<td>
                        <a href='position.php?id=" . $row["id"]."/".$id[0]."/".$id[1]. "' id=". $row["id"].">View Leaders</a>
                        <a href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                        </td>
                        </tr>";
            }else{  
                echo "<tr><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
                    <td>".$row["brgy"].", ".$row["prk"] ."</td>
                    <td>".$row["pn"]."</td>
                    <td>".$row["pos"]."</td>";
                    if($row["status"]!="voted"){
                        echo "<td><span class='badge bg-danger'><a href='update.php?id=".$row["id"]."' class='btn badge bg-danger a'>".$row["status"]."</a></span></td>";
                    }else{
                        echo "<td><span class='badge bg-success'><a href='update.php?id=".$row["id"]. "' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
                        
                    }
                    echo "<td>
                        <a class='badge bg-success' href='position.php?id=" . $row["id"]."/".$ids. "' id=". $row["id"]." hidden>View Members</a>
                        <a class='badge bg-primary' href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
                        </td>
                        </tr>";
            }
        }
    } else {
      echo "0 results";
    }
    
    

//cluster leader precint table    
}else{
    $sql = "SELECT * FROM election where pos like '%Cluster Precint Leader%' order by pn";
    $result = $conn->query($sql);
    
    
    if ($result->num_rows > 0) {
     
      while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["name"]." &nbsp;&nbsp;&nbsp;<span class='badge bg-secondary'>".$row["standing"]."</span></td>
        <td>".$row["brgy"].", ".$row["prk"] ."</td>
        <td>".$row["pn"]."</td>
        <td>".$row["pos"]."</td>";
        if($row["status"]!="voted"){
            echo "<td><span class='badge bg-danger'><a href='update.php?id=".$row["id"]."' class='btn badge bg-danger a'>".$row["status"]."</a></span></td>";
        }else{
            echo "<td><span class='badge bg-success'><a href='update.php?id=".$row["id"]."' class='btn badge bg-success a'>".$row["status"]."</a></span></td>";
            
        }
     echo "<td>
     <a class='badge bg-success' href='position.php?id=" . $row["id"]."' id=". $row["id"].">View Coordinators</a>
     <a class='badge bg-primary' href='view_profile.php?id=" . $row["id"]. "' id=". $row["id"].">View Info</a>
     </td>
        </tr>";
      }
      
    } else {
      echo "0 results";
    }
}

$conn->close();
?>

    
    </tbody>
</table>  

<?php if($data['co'] == 'leader' || $data['co'] == 'Leader' || $data['lead'] == 'Cluster Precint Leader & Leader'){ ?>
<button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" >
      Add Member
</button><br><br>
<?php }?>
</div>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-body">
						<div class="table-responsive">
                            <table class="table table-bordered" id="crud_table">
                                <tr>
                                      <th width="30%">Name</th>
                                      <th width="5%"></th>
                                </tr>
                                <tr>
                                    <td  contenteditable="false" id="name" class="name">
                                    </td>
                                    <td></td>
                                    
                                </tr>
                            </table>
                            
                            
                            <div align="right">
                                <button type="button" name="add" id="add" class="btn btn-success btn-xs">+</button>
                            </div>
                		</div>
					</div>
					<div style="clear:both;"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
						<button name="save" id="save" class="btn btn-primary">Submit</button>
					</div>
				</div>
		</div>
	</div>
<br><br>
<div class="row">
<?php include'incl/footer.php';?>
</div>

<script>
    $(document).ready(function(){
         var count = 1;
         $('#add').click(function(){
          count = count + 1;
          var html_code = "<tr id='row"+count+"'>";
           html_code += "<td contenteditable='true' id='name' class='name'> <datalist id='output' ></datalist></td>";
           html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'>-</button></td>";   
           html_code += "</tr>";  
           $('#crud_table').append(html_code);
         });
        $(document).on('click', '.remove', function(){
            var delete_row = $(this).data("row");
            $('#' + delete_row).remove();
        });
        
         $('#save').click(function(){
          var name = [];
            $('.name').each(function(){
           name.push($(this).text());
          });
          $.ajax({
           url:"insert.php?id=<?php echo $ids;?>",
           method:"POST",
           data:{name:name},
           success:function(data){
               alert(data) ;
               location.reload();
            $("td[contentEditable='true']").text("");
            for(var i=2; i<= count; i++)
            {
             $('tr#'+i+'').remove();
            }
           }
          });
         });
        
        
    //     $("#name").keyup(function(){
    //       var query = $(this).val();
    //       if (query != "") {
    //         $.ajax({
    //           url: 'fetch_pos.php',
    //           method: 'POST',
    //           data: {query:query},
    //           success: function(data){
    //             $('#output').html(data);
    //             $('#output').css('display', 'block');
 
    //             $("#search").focusout(function(){
    //                 $('#output').css('display', 'none');
    //             });
    //             $("#search").focusin(function(){
    //                 $('#output').css('display', 'block');
    //             });
    //           }
    //         });
    //       } else {
    //       $('#output').css('display', 'none');
    //     }
    //   });
        
        
        
         
    });
</script>


</body>
</html>