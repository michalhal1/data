<?php session_start();

if (isset($_GET["job_id"])) {
    $paramid = trim($_GET["job_id"]);
    $_SESSION['paramid'] = $paramid;
};?>

<?php echo $_SESSION['paramid'] ?>
<html>

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>

    <style>
        .input-group-prepend {
            width: 55%;
            padding-right: 5%;
        }

        .btn {
            margin: 0px 0px 10px 10px;

        }
    </style>


    <div class="container">
        <br />
        <h2 align="center">Zadania przetargowe</h2><br />
        <div class="form-row">

            <div class="input-group-prepend">
                <span class="input-group-addon"></span>
            </div>

            <a href="offeror_create.php?job_id=<?php echo $_SESSION['paramid'] ?>" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Nowa oferta</a>

        </div>
        <br />
        <div id="result"></div>
    </div>
</body>

</html>


<style>
     .wrapper {
        width: 1200px;
        white-space: nowrap;
    }

    .wrapper {
        width: 85%;
        padding-right: 5%;
        margin-left: 100px;
    }


    table tr td:last-child {
        width: 700px;
        padding: 0px;
        white-space: nowrap;
    }
</style>

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


    $query = "
 SELECT tnd_number, case when length(trim(cnt_name))>25 then concat(left(cnt_name,25), if(right(left(cnt_name,25),1)='.', '', '...')) else cnt_name end as cnt_name, tnd_NIP, tnd_submit_date, tnd_announce_date, tend_type_name, segm_name, tnd_creation_worker FROM tenders_test.tenders
 left join tenders_test.contractors on cnt_id=tnd_contractor_id
 left join tenders_test.tender_types on tend_type_id=tnd_type
 left join tenders_test.segments on segm_id=tnd_segment_id";

    $result = mysqli_query($link, $query);
    if (mysqli_num_rows($result) > 0) {
        $output .= '
    <div class = "wrapper">
    <div class="table-responsive">
    <table class="table table bordered">
    <tr>
     <th>Numer zadania</th>
     <th>Przedmiot zamówienia</th>
     <th>Handlowiec</th>
     <th>Region</th>
     <th>Typ sprzedaży</th>
     <th>Liczba miesięcy</th>
     <th>Oddział</th>
     <th>Akcja</th>
    </tr>
 ';
        while ($row = mysqli_fetch_array($result)) {
            $output .= '
   <tr>
    <td width=60>' . $row["tnd_number"] . '</td>
    <td nowrap>' . $row["cnt_name"] . '</td>
    <td>' . $row["tnd_NIP"] . '</td>   
    <td nowrap>' . $row["tnd_submit_date"] . '</td>
    <td nowrap>' . $row["tnd_announce_date"] . '</td>
    <td nowrap>' . $row["tend_type_name"] . '</td>
    <td nowrap>' . $row["tnd_creation_worker"] . '</td>
     <td width=100>
     <a href="update.php?tnd_number=' . $row['tnd_number'] . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>
     <a href="delete.php?tnd_number=' . $row['tnd_number'] . '" class="mr-3" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>
     <a href="tasks.php?tnd_number=' . $row['tnd_number'] . '" title="Dodaj oferenta" data-toggle="tooltip"><span class="fa fa-handshake-o"></span></a>
    </td>
    </tr>
  ';
        }
        echo $output;
    } else {
        echo 'Data Not Found';
    }

    ?>


    </div>
    </div>
    </div>
    </div>
</body>

</html>