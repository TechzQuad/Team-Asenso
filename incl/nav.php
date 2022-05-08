<nav class="navbar navbar-expand-sm fixed-top" style="padding:0;background-color:#3d5c5c">
  <div class="container-fluid">
   <a class="navbar-brand text-white" href="https://onetechzquad.tech"><i class="fa fa-graduation-cap fa-lg mr-2"></i>Team Asenso</a>
    <button style="color:#ffffff" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
      <span style="color:#ffffff" class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse pull" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="https://onetechzquad.tech">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://onetechzquad.tech/position">Supporters Breakdown</a>
        </li>
 <div class="btn-group">
  <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:#ffffff">
Members Per Barangay
  </button>
  <ul class="dropdown-menu">
                <a class="dropdown-item" href="https://onetechzquad.tech/brgy-view?brgy=Bandila">Bandila</a>
                <a class="dropdown-item" href="https://onetechzquad.tech/brgy-view?brgy=Bug-ang">Bug-ang</a>
                <a class="dropdown-item" href="https://onetechzquad.tech/brgy-view?brgy=Gen. Luna">Gen. Luna</a>
                 <a class="dropdown-item" href="https://onetechzquad.tech/brgy-view?brgy=Magticol">Magticol</a>
                <a class="dropdown-item" href="https://onetechzquad.tech/brgy-view?brgy=Poblacion">Poblacion</a>
                <a class="dropdown-item" href="https://onetechzquad.tech/brgy-view?brgy=Salamanca">Salamanca</a>
                 <a class="dropdown-item" href="https://onetechzquad.tech/brgy-view?brgy=San Isidro">San Isidro</a>
                <a class="dropdown-item" href="https://onetechzquad.tech/brgy-view?brgy=San Jose">San Jose</a>
                <a class="dropdown-item" href="https://onetechzquad.tech/brgy-view?brgy=Tabun-ac">Tabun-ac</a>
  </ul>
</div>
 <div class="btn-group">
  <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:#ffffff">
Overall Reports
  </button>
  <ul class="dropdown-menu">
                <a class="dropdown-item" href="https://onetechzquad.tech/voters" hidden>Cluster Precint Leader Report</a>
                <a class="dropdown-item" href="https://onetechzquad.tech/brgy_reports"hidden>Reports per Barangay</a>
                <a class="dropdown-item" href="https://onetechzquad.tech/sspb">Supporters Status per Barangay</a>
                <a class="dropdown-item" href="https://onetechzquad.tech/sspc">Supporters Status per Cluster Precinct Leader</a>
                <a class="dropdown-item" href="https://onetechzquad.tech/precinct">Supporters Status per Precinct</a>
                 <a class="dropdown-item" href="https://onetechzquad.tech/voted">Voted Supporters Time Record</a>
                <a class="dropdown-item" href="https://onetechzquad.tech/oop/attendance">Meeting Attendance</a>
  </ul>
</div>
<li class="nav-item">
            <a class="nav-link" href="https://onetechzquad.tech/search">Search Voter</a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" href="https://onetechzquad.tech/login">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<br>
<script type="text/javascript">
    // $(document).ready(function(){
    //   $("#search").keyup(function(){
    //       var query = $(this).val();
    //       if (query != "") {
    //         $.ajax({
    //           url: 'fetch_position_ajax.php',
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
    // });
        function showPosition1(str) {
        var xhttp;    
        if (str == "") {
            document.getElementById("output1").innerHTML = "";
            return;
        }
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              document.getElementById("output1").innerHTML = xhttp.responseText;
              
            }  
        };
        console.log(str);
        xhttp.open("GET", "fetch_position_ajax.php?pos="+st, true);
        xhttp.send();
    }
    
</script>

