<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css"> --}}
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    {{-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> --}}
    <link rel="stylesheet" href="//cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="row" id="data_temp">

    </div>
    
    <div class="ajax-load text-center" style="display:none">
        <i class="mdi mdi-48px mdi-spin mdi-loading"></i> Loading ...
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
{{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script>

let pages = 2;
let current_page = 0;
let bool = false;

$(window).scroll(function (){
    let  height = $(document).height();
    if($(window).scrollTop() + $(window).height() >= height && bool == false){
        bool = true;
        
        $('.ajax-load').show();
        lazyLoad(pages)
        .then(message => {
            bool = false;
        })

        pages++;
    }
})

function lazyLoad(page){
    return new Promise((resolve,reject) => {
         $.ajax({
            url: '?page='+page,
            type:'GET',
            beforeSend:function() {
                $('.ajax-load').show();
            },
            success :function (response){
                $('.ajax-load').hide();

                let html = '';
                for(let i = 0; i < response.html.data.length;i++){
                    html += `<div class="col-md-4 mb-3" > 
                                <div class="card">
                                    <div class="card-header">
                                        Employee Title

                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <tr>
                                                <th>ID</th>
                                                <td>:</td>
                                                <td>`+response.html.data[i].id+`</td>
                                            </tr> 
                                            <tr>
                                                <th>Name</th>
                                                <td>:</td>
                                                <td>`+response.html.data[i].name+`</td>
                                            </tr> 
                                            <tr>
                                                <th>Company Origin</th>
                                                <td>:</td>
                                                <td>`+response.html.data[i].company_origin+`</td>
                                            </tr> 
                                            <tr>
                                                <th>Position Title</th>
                                                <td>:</td>
                                                <td>`+response.html.data[i].position_title+`</td>
                                            </tr> 
                                            <tr>
                                                <th>Last Education</th>
                                                <td>:</td>
                                                <td>`+response.html.data[i].last_education+`</td>
                                            </tr>
                                            <tr>
                                                <th>Born Date</th>
                                                <td>:</td>
                                                <td>`+response.html.data.born_date+`</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            `
                }

                $('#data_temp').append(html);
                resolve(true);

            }
        });
    })
}

loadData(1);

async function loadData(page){
   await $.ajax({
        url: '?page='+page,
        type:'GET',
        beforeSend:function() {
            $('.ajax-load').show();
        },
        success :function (response){
            $('.ajax-load').hide();

            let html = '';

            for(let i = 0; i < response.html.data.length;i++){
                html += `<div class="col-md-4 mb-3" > 
                            <div class="card">
                                <div class="card-header">
                                    Employee Title

                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <tr>
                                            <th>ID</th>
                                            <td>:</td>
                                            <td>`+response.html.data[i].id+`</td>
                                        </tr> 
                                        <tr>
                                            <th>Name</th>
                                            <td>:</td>
                                            <td>`+response.html.data[i].name+`</td>
                                        </tr> 
                                        <tr>
                                            <th>Company Origin</th>
                                            <td>:</td>
                                            <td>`+response.html.data[i].company_origin+`</td>
                                        </tr> 
                                        <tr>
                                            <th>Position Title</th>
                                            <td>:</td>
                                            <td>`+response.html.data[i].position_title+`</td>
                                        </tr> 
                                        <tr>
                                            <th>Last Education</th>
                                            <td>:</td>
                                            <td>`+response.html.data[i].last_education+`</td>
                                        </tr>
                                        <tr>
                                            <th>Born Date</th>
                                            <td>:</td>
                                            <td>`+response.html.data[i].born_date+`</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        `
            }

            $('#data_temp').html(html);
        }
    });
}
</script>
</body>
</html>