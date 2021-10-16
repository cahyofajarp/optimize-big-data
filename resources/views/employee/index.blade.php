<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="loading" class="d-none"
            style="
            position: fixed;
            top: 350px;
            margin: 0 auto;
            width: 14%;
            text-align:center;
            font-weight:100;
            font-size:20px;
            background: #fff;
            
            "
            >Loading ... </div>
            
            <div id="data_table">   
                <table class="table table-striped table-responsive" id="myTable">
                    <thead class="thead-inverse">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Company Origin</th>
                            <th>Position Title</th>
                            <th>Last Education</th>
                            <th>Born Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>

                        @foreach ($employees as $key => $employee)
                            <tr>
                                <td></td>
                                {{-- <td>{{ ++$key + ($employees->currentPage()-1) * $employees->perPage() }}</td> --}}
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->company_origin }}</td>
                                <td>{{ $employee->position_title }}</td>
                                <td>{{ $employee->last_education }}</td>
                                <td>{{ $employee->born_date }}</td>
                            </tr>
                            
                        <?php $no++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
{{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready( function () {
        var t = $('#myTable').DataTable( {
            "columnDefs": [ {
                "searchable": true,
                "orderable": true,
                "targets": 0
            } ],
            "order": [[ 1, 'asc' ]]
        } );
    
        t.on( 'order.dt search.dt', function () {
            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    } );
</script>

<script>

    // let pageData = 1;


    // loadData(pageData);

    // function loadData(page){
    //     $.ajax({
    //         type: 'GET',
    //         url : '/employees?page='+page,
    //         beforeSend:function() {
    //             $('#loading').removeClass('d-none');
    //         },
    //         success : function(data) {
    //             $('#loading').addClass('d-none');
                
    //             $('#data_table').html(data);
    //         },
            
    //         error:function(error){
    //             console.log(error);
    //         }
        
    //     });
    // }


    // $('#loading').removeClass('d-none');

    // $(document).ready(function() {
    //     $(document).on('click','.pagination a',function(event) {
    //         event.preventDefault();
            
    //         let page = $(this).attr('href').split('page=')[1];
            
    //         // $('.page-link').c;
    //         // if($(this).text() == page){
    //         //     $('.page-item').removeClass('active'); 
    //         //     $(this).closest('.page-item').addClass('active');       
    //         // }
    //         var url = $(this).attr('href');  
    //         fetch_data(page);
    //         window.history.pushState("", "", url);

    //     })

    //     function fetch_data(page) {
    //             $.ajax({
    //             type: 'GET',
    //             url : '/employees?page='+page,
    //             data : {
    //                 _token : '{{ csrf_token() }}',
    //                 page: page
    //             },
    //             beforeSend:function() {
    //                 $('#loading').removeClass('d-none');
    //             },
    //             success : function(data) {
    //                 $('#loading').addClass('d-none');
                    
    //                  $('#data_table').html(data);
    //                 // let html = '';
    //                 // for(let i=0; i < data.html.data.length;i++){
    //                 //     html += 
    //                 //     `
    //                 //     <tr>
    //                 //         <td>`+data.html.data[i].id+`</td>
    //                 //         <td>`+data.html.data[i].name+`</td>
    //                 //         <td>`+data.html.data[i].company_origin+`</td>
    //                 //         <td>`+data.html.data[i].position_title+`</td>
    //                 //         <td>`+data.html.data[i].last_education+` </td>
    //                 //         <td>`+data.html.data[i].born_date+`</td>
    //                 //     </tr>
    //                 //     `;
    //                 // }
    //                 // $('#data_fetch').html(html);

    //             }
    //         });
    //     }
    // })
</script>
</body>
</html>