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
            width: auto;
            white-space: nowrap;


        }

        table tr td:last-child {
            width: 10%;
            padding: 0px;
            white-space: nowrap;
        }

        .table-responsive {
             table-layout: fixed;
             width: 100%;


         }

         .a {
             max-width: 20%;

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


    <?php
    //fetch.php
    require_once "config.php";
    $output = '';

    if (isset($_POST["query"])) {
        $search = mysqli_real_escape_string($link, $_POST["query"]);
        $query = "SELECT offnames_id, offnames_name, case when offnames_isimpel=1 then 'tak' else 'nie' end as offnames_isimpel from offerors_names WHERE offnames_active=1
    and (offnames_name LIKE '%" . $search . "%'" . "or case when offnames_isimpel=1 then 'tak GI' else 'nie' end LIKE '%" . $search . "%')";
   
    } else {
        $query = "SELECT offnames_id, offnames_name, case when offnames_isimpel=1 then 'tak' else 'nie' end as offnames_isimpel from offerors_names WHERE offnames_active=1";
    }
    $result = mysqli_query($link, $query);
    if (mysqli_num_rows($result) > 0) {
        $output .= '
  <div class="table-responsive">
   <table class="table table bordered">
    <tr>
     <th>Nazwa</th>
     <th>Grupa Impel</th>
     <th>Akcja</th>
    </tr>
 ';
        while ($row = mysqli_fetch_array($result)) {
            $output .= '
   <tr>
    <td class="a" nowrap>' . $row["offnames_name"] . '</td>
    <td nowrap>' . $row["offnames_isimpel"] . '</td>
    <td width=100>
    <a href="offname_update.php?offnames_id=' . $row['offnames_id'] . '" class="mr-3" title="Edytuj rekord" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>
    <a href="offname_delete.php?offnames_id=' . $row['offnames_id'] . '" class="mr-3" title="Usuń rekord" data-toggle="tooltip"><span class="fa fa-trash"></span></a>
   
     </td>
     
</td>
   </tr>
  ';
        }
        echo $output;
    } else {
        echo 'Nie znaleziono rekordów';
    }

    ?>


    </div>
    </div>
    </div>
    </div>
</body>

</html>