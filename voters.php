<!DOCTYPE html>
<html lang="en">
<head>
<?php include'incl/links.php';?>
</head>
<body>
<?php include'incl/nav.php';?>


<div class="container mt-3">
  <h1>Voter's Table</h1><a href="#" class="btn btn-secondary pull-right">Browse QR>></a>
  <table class="table table-bordered">
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
    <tr>
        <td>Mark Corral Banilarskie &nbsp;AC</td>
        <td>Bandila Proper</td>
        <td>220A</td>
        <td>Member</td>
        <td><span class="badge bg-success">Voted</span></td>
        <td><a href="#">View Info</a></td>
      </tr>
      <tr>
        <td>Mark Corral Banilarskie</td>
        <td>Bandila Proper</td>
        <td>220A</td>
        <td>Leader</td>
        <td><span class="badge bg-danger">Not Voted</span></td>
        <td><a href="#">View Info</a>&nbsp;<a href="#">View Members</a></td>
      </tr>
      <tr>
        <td>Mark Corral Jolinarskie</td>
        <td>Bandila Proper</td>
        <td>220A</td>
        <td>Coordinator</td>
        <td><span class="badge bg-success">Voted</span></td>
        <td><a href="#">View Info</a>&nbsp;<a href="#">View Leaders</a></td>
      </tr>
      <tr>
        <td>Mark Corral hanskie &nbsp;C</td>
        <td>Bandila Proper</td>
        <td>220A</td>
        <td>Cluster Leader</td>
        <td><span class="badge bg-success">Voted</span></td>
        <td><a href="#">View Info</a>&nbsp;<a href="#">View Coordinators</a></a></td>
      </tr>
    </tbody>
  </table>
</div>
<br><br>
<div class="row">
<?php include'incl/footer.php';?>
</div>
</body>
</html>