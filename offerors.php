<?php session_start();

if (isset($_GET["job_id"])) {
    $paramid = trim($_GET["job_id"]);
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

 <a href="log_out.php" title="Wyloguj się"  data-toggle="tooltip"><span class="fa fa-sign-out"></span></a>
   

<html>

<head>
    <meta charset="UTF-8">
    <title>Baza Przetargowa</title>
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
    }

    .wrapper {
        width: 90%;
        padding-right: 3%;
        margin-left: 100px;
    }


    table tr td:last-child {
        width: 10%;
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

    if (isset($_GET["job_id"]) && !empty(trim($_GET["job_id"]))) {
        $id =  trim($_GET["job_id"]);
        $query = "
        Select tnd_id, tnd_number, cnt_name, job_number, off_id, job_id, offnames_name, off_contract_value, jobval_name, off_tnd_name
        from tenders_test.tenders_jobs
        left join tenders_test.job_value_types on job_value_type_id = jobval_type_id
        left join tenders_test.offerors on job_id = off_job_id
        left join tenders_test.offerors_names on off_leading_offeror = offnames_id
        left join tenders_test.offerors_tender_output on off_output = off_tnd_out
        left join tenders_test.tenders on tnd_id = job_tnd_id
        left join tenders_test.contractors on tnd_contractor_id = cnt_id
        WHERE job_id = ?";
        if ($stmt = mysqli_prepare($link, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $param_job_id);
            $param_job_id = $id;
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
        <th>Nazwa oferenta</th>
        <th>Wartość</th>
        <th>Typ wartości</th>
        <th>Wynik</th>
        <th>Akcja</th>
        </tr>
        ';
        
        while ($row = mysqli_fetch_array($result)) {
            $output .= '
            <tr>
            <td width nowrap>' . $row["offnames_name"] . '</td>
            <td nowrap>' . $row["off_contract_value"] . '</td>   
            <td nowrap>' . $row["jobval_name"] . '</td>
            <td nowrap>' . $row["off_tnd_name"] . '</td>
            <td width=300>
            <a href="offerors_update.php?off_id=' . $row['off_id'] . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>
            <a href="offerors_delete.php?off_id=' . $row['off_id'] . '" class="mr-3" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>
            </td>
            </tr>
            ';

            $numerPrzetargu = $row['tnd_number'];
            $zamawiajacy = $row['cnt_name'];
            $numerZadania = $row['job_number'];
            $numerOferenta =$row["off_id"];
            $tnd_number =$row["tnd_id"];
        }
        }
        } 
    else {
    echo 'Data Not Found';
    }
    }

    if (($numerOferenta > 0)) {
        echo $output;
    }

    ?>

    <style>
        .input-group-prepend {
            width: 65%;
            padding-right: 5%;
        }

        .btn {
            margin: 0px 0px 5px 5px;

        }
    </style>


    <div class="container">
        <br />
        <h2 align="center">Oferty</h2><br />
        <div class="form-row">

            <div class="input-group-prepend">
                <span class="input-group-addon"></span>
                <h5 align="center">Jesteś w przetargu: <?php echo $numerPrzetargu . " - " . $zamawiajacy . " - " . $numerZadania; ?> </h5></br>
            </div>

            <a href="offeror_create.php?job_id=<?php echo $_SESSION['paramid'] ?>" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Nowa oferta</a>
            <a href="tasks.php?tnd_id=<?php echo $tnd_number ?>" class="btn btn-secondary ml-2">Powrót</a>
        </div>
        <br />
        <?php 
        if (($numerOferenta <= 0)) {
            echo '<div class="alert alert-danger"><em>Brak ofert do tego zadania</em></div>';
            } 
        ?>
    </div>
    <br />   
    <div id="result"></div>
</body>

</html>