 <?php




    //fetch.php
    require_once "config.php";
    $output = '';

    if (isset($_POST["query"])) {
        $search = mysqli_real_escape_string($link, $_POST["query"]);
        $query = "
 SELECT tnd_id, tnd_number,  case when length(trim(cnt_name))>30 then concat(left(cnt_name,30), if(right(left(cnt_name,30),1)='.', '', '...')) else cnt_name end as cnt_name, 
  cnt_NIP, tnd_submit_date, tnd_announce_date, tend_type_name, segm_name, tnd_creation_worker FROM tenders_test.tenders
 left join tenders_test.contractors on cnt_id=tnd_contractor_id
 left join tenders_test.tender_types on tend_type_id=tnd_type
 left join tenders_test.segments on segm_id=tnd_segment_id
  WHERE tnd_NIP LIKE '%" . $search . "%'
  OR tnd_announce_date LIKE '%" . $search . "%' 
  OR tnd_number LIKE '%" . $search . "%' ";
    } else {
        $query = "
 SELECT tnd_id, tnd_number,case when length(trim(cnt_name))>30 then concat(left(cnt_name,30), if(right(left(cnt_name,30),1)='.', '', '...')) else cnt_name end as cnt_name, cnt_NIP, tnd_submit_date, tnd_announce_date, tend_type_name, segm_name, tnd_creation_worker FROM tenders_test.tenders
 left join tenders_test.contractors on cnt_id=tnd_contractor_id
 left join tenders_test.tender_types on tend_type_id=tnd_type
 left join tenders_test.segments on segm_id=tnd_segment_id";
    }
    $result = mysqli_query($link, $query);
    if (mysqli_num_rows($result) > 0) {
        $output .= '
  <div class="table-responsive">
   <table class="table table bordered">
    <tr>
     <th>Numer przetargu</th>
     <th >Zamawiający</th>
     <th>NIP</th>
     <th>Data ogłoszenia</th>
     <th>Data złożenia</th>
     <th>Typ</th>
     <th>Dodał</th>
     <th>Akcja</th>
    </tr>
 ';
        while ($row = mysqli_fetch_array($result)) {
            $output .= '
   <tr>
    <td width=60>' . $row["tnd_number"] . '</td>
    <td nowrap>' . $row["cnt_name"] . '</td>
    <td>' . $row["cnt_NIP"] . '</td>
    <td nowrap>' . $row["tnd_submit_date"] . '</td>
    <td nowrap>' . $row["tnd_announce_date"] . '</td>
    <td nowrap>' . $row["tend_type_name"] . '</td>
    <td nowrap>' . $row["tnd_creation_worker"] . '</td>
     <td width=300>
     <a href="tender_update.php?tnd_number=' . $row['tnd_number'] . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>
     <a href="tender_delete.php?tnd_number=' . $row['tnd_number'] . '" class="mr-3" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>
     <a href="tasks.php?tnd_id=' . $row['tnd_id'] . '" title="Dodaj zadanie przetargowe" data-toggle="tooltip"><span class="fa fa-paperclip"></span></a>
</td>
   </tr>
  ';
        }
        echo $output;
    } else {
        echo 'Data Not Found';
    }

    ?>



 <!DOCTYPE html>
 <html lang="en">

 <head>

     <meta charset="UTF-8">
     <title>Dashboard</title>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
     <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



     <style>
         .wrapper {
             width: 1200px;
             white-space: nowrap;


         }

         .table-responsive {
             table-layout: fixed;
             width: 100%;


         }

         table tr td:last-child {
             width: auto;
             padding: 0px;
             white-space: nowrap;
         }

         .a {
             max-width: 20px;

         }
     </style>





     <script>
         $(document).ready(function() {
             $('[data-toggle="tooltip"]').tooltip();
         });
     </script>
 </head>

 <body>

     <!-- <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left"></h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Nowy przetarg</a>
                    </div> -->




     </div>
     </div>
     </div>
     </div>
 </body>

 </html>