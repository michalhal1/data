<?php
session_start();

if (isset($_GET["tnd_id"])) {
    $paramid = trim($_GET["tnd_id"]);
    $_SESSION['paramid'] = $paramid;
};


if (isset($_SESSION["logid"])) {
    $logid = $_SESSION['logid'];
} else {
    header("location:login.php");
};


echo "<div style='text-align:right'>";
echo "<div style='padding-right:30px';>";
echo $_SESSION['logid'];
?>

<a href="log_out.php" title="Wyloguj się" data-toggle="tooltip"><span class="fa fa-sign-out"></span></a>

</div>
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

<style>
   

    .wrapper {
        width: auto;
        white-space: nowrap;
        padding-right: 5%;
        margin-left: 100px;
    }

    table tr td:last-child {
        width: auto;
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

    if (isset($_GET["tnd_id"]) && !empty(trim($_GET["tnd_id"]))) {
        $id =  trim($_GET["tnd_id"]);
        $query = "
        Select tnd_number, cnt_name, job_number, job_id, case when length (trim(job_name))>35 then concat(left(job_name,35), if(right(left(job_name,35),1)='.', '', '...')) else job_name end as job_name, reg_name, concat(merch_name, ' ', merch_surname) as merchant_name, sal_type_name, prod_name, job_deadline
        from tenders_test.tenders
        join tenders_test.contractors on cnt_id = tnd_contractor_id
        left join tenders_test.tenders_jobs on tnd_id = job_tnd_id
        left join tenders_test.regions on job_region=reg_id
        left join tenders_test.merchants on job_merchant_id=merch_id
        left join tenders_test.sales_types on job_sales_type=sal_type_id
        left join tenders_test.products on job_product_id=prod_id
        WHERE tnd_id = ?
        order by 3";
        if ($stmt = mysqli_prepare($link, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $param_tnd_id);
            $param_tnd_id = $id;
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
            }

            //$result = mysqli_query($link, $query);
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
        <th>Produkt</th>
        <th>Liczba miesięcy</th>
        <th>Akcja</th>
        </tr>
        ';


                while ($row = mysqli_fetch_array($result)) {
                    $output .= '
            <tr>
            <td width=60>' . $row["job_number"] . '</td>
            <td nowrap>' . $row["job_name"] . '</td>  
            <td nowrap>' . $row["merchant_name"] . '</td>
            <td nowrap>' . $row["reg_name"] . '</td> 
            <td nowrap>' . $row["sal_type_name"] . '</td>
            <td nowrap>' . $row["prod_name"] . '</td>
            <td nowrap>' . $row["job_deadline"] . '</td>
            <td width=300>
            <a href="job_update.php?job_id=' . $row['job_id'] . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>
            <a href="job_delete.php?job_id=' . $row['job_id'] . '" class="mr-3" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>
            <a href="offerors.php?job_id=' . $row['job_id'] . '" title="Dodaj oferenta" data-toggle="tooltip"><span class="fa fa-handshake-o"></span></a>
            </td>
            </tr>
            ';

                    $zamawiajacy = $row['cnt_name'];
                    $numerZadania = $row["job_number"];
                    $tnd_number = $row["tnd_number"];
                }
            }
        } else {
            echo 'Data Not Found';
        }
    }

    if (($numerZadania > 0)) {
        echo $output;
    }

    ?>


    <style>
        .input-group-prepend {
            width: 55%;
            padding-right: 5%;
        }

        .btn {
            margin: 0px 0px 10px 10px;
        }

        .container {
            min-width: auto;
        }
    </style>

    <div class="container">
        <br />
        <h2 align="center">Zadania przetargowe</h2><br />
        <div class="form-row">

            <div class="input-group-prepend">
                <span class="input-group-addon"></span>
                <h5 align="center">Jesteś w przetargu: <?php echo  $tnd_number . " - " . $zamawiajacy; ?> </h5></br>
            </div>

            <a href="job_create.php?tnd_id=<?php echo $_SESSION['paramid'] ?>" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Nowe zadanie przetargowe</a>
            <a href="tenders.php" class="btn btn-secondary ml-2">Powrót</a>
        </div>
        </br>
        <?php
        if (($numerZadania <= 0)) {
            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
        }
        ?>
    </div>
    <br />
    <div id="result"></div>

</body>

</html>