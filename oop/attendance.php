
<!DOCTYPE html>
<html lang="en">
<head>
<?php include'../incl/links.php';?>

</head>
<body>   
    
    
<?php include'../incl/nav.php';?>
<br>
<div class="container mt-3">
    <div class="row">
        <div class="col-md-12">
    <!--<table id="voters" class="display" style="width:100%">-->
    <!--<thead>-->
    <!--  <tr>-->
    <!--    <th>Name</th>-->
    <!--    <th>Cluster Presinct #</th>-->
    <!--    <th>Position</th>-->
    <!--    <th>Address</th>-->
    <!--    <th>date</th>-->
    <!--    <th>Action</th>-->
    <!--  </tr>-->
    <!--</thead>-->
    <!--<tbody>-->
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Result</label>
                    </div>
                    <select class="custom-select" id="date">
                        <option value="">Choose Date...</option>
                    </select>
                    <button id="filter" class="btn btn-sm btn-outline-info">Filter</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mt-2 mb-2">
                    <!-- Table -->
                    <div class="table">
                        <table class="table table-striped" id="record_table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Cluster Presinct #</th>
                                    <th>Position</th>
                                    <th>Address</th>
                                    <th>date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br>
<div class="row">
<?php include'../incl/footer.php';?>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->

<script>
  

      function fetch(date) {
        $.ajax({
            url: "record.php",
            type: "post",
            data: {
                date:date
            },
            dataType: "json",
            success: function(data) {
                var i = 1;
                
                $('#record_table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    "data": data,
                    "responsive": true,
                    "columns": [
                        {
                            "data": "name"
                        },
                        {
                            "data": "pn"
                        },
                        {
                            "data": "pos",
                            
                        },
                        {
                            "data": "brgy",
                            
                            render : function(data, type, row) {
                                  return data + ','
                            }
                        },
                        {
                            "data": "date"
                        
                        },
                        {
                            "data" : 'id',
                            render : function(data, type, row) {
                                  return '<a class="btn-sm btn-danger" href="javascript:del_id('+ data +')">Delete</button>'
                            } 
                        }
                        
                    ]
                });
            }
        });
    }
    fetch();  
    
    
function del_id(id)
{
    if(confirm('Sure to delete this record ?'))
{
    window.location='delete.php?id='+id
}
}
    
    
    function fetch_date() {
        $.ajax({
            url: "fetch_date.php",
            type: "post",
            dataType: "json",
            success: function(data) {
                var stdBody = "";
                for (var key in data) {
                    stdBody += `<option value="${data[key]['date']}">${data[key]['date']}</option>`;
                }
                $("#date").append(stdBody);
            }
        });
    }
    fetch_date();
    
    $(document).on("click", "#filter", function(e) {
        e.preventDefault();
        var date = $("#date").val();
        if (date !== "") {
            $('#record_table').DataTable().destroy();
            console.log(date);
           fetch(date);
        } else {
            $('#record_table').DataTable().destroy();
            fetch();
        }
    }); 
    
    
</script>

</body>
</html>















