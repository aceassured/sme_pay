<?php
//   if (($_SERVER['PHP_AUTH_USER'] != 'specialuser') || ($_SERVER['PHP_AUTH_PW'] != 'secretpassword')) {
//       header('WWW-Authenticate: Basic Realm="Secret Stash"');
//       header('HTTP/1.0 401 Unauthorized');
//       print('You must provide the proper credentials!');
//       exit;
//   } 
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
    ($_SERVER['PHP_AUTH_USER'] != 'specialuser' || $_SERVER['PHP_AUTH_PW'] != 'secretpassword')) {
    header('WWW-Authenticate: Basic realm="Restricted Area"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'You must enter a valid username and password to access this page';
    exit;
}
   
?>


<html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <style>
            body {
                font-family: Nunito,sans-serif;
                font-size: 16px;
                background-color: #f3f3fe;
                color: #2c3345;
            }
            .w-85 {
                width: 85% !important;
            }
        </style>
    </head>
    <body>
        <h2 class="text-center mt-4 mx-auto">Transaction list</h2>
        <div class="card w-85 mt-3 mx-auto">

            <div class="card-body p-2">
                <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Name</th>
                          <th scope="col">Invoice No</th>
                          <th scope="col">Amount</th>
                          <th scope="col">Company</th>
                          <th scope="col">Reference No</th>
                          <th scope="col">Comments</th>
                          <th scope="col">Status</th>
                          <th scope="col">Created at</th>
                        </tr>
                      </thead>
                      <tbody>
                          
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
        <script>
            $(document).ready(() => {
                $.ajax({
                    type: "GET",
                    contentType: "application/json; charset=utf-8",
                    url: 'connect.php',
                    success: function (response) {
                        $.each(response  , function(i, record) {
                            let created_at = new Date(record.created_at);
                            console.log(record);
                           var tr = '<tr>'+
                                        '<td scope="row">'+(i+1)+'</td>'+
                                        '<td>'+record.first_name+" "+record.last_name+'</td>'+
                                        '<td>'+record.invoice_no+'</td>'+
                                        '<td>'+record.amount+'</td>'+
                                        '<td>'+record.company+'</td>'+
                                        '<td>'+record.reference_no+'</td>'+
                                        '<td>'+record.comments+'</td>'+
                                        '<td>'+(record.status == 1 ? 'Success' : 'Failure')+'</td>'+
                                        '<td>'+created_at.toLocaleString()+'</td>'+
                                    '</tr>'
                           $('tbody').append(tr);
                        });
                    }
            
                });
            })
        </script>
    </body>
</html>