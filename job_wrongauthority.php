<?php session_start();


if (isset($_SESSION["logid"])) {
    $logid = $_SESSION['logid'];
} else {
    header("location:login.php");
};

if (isset($_GET["job_id"])) {
    $paramid = trim($_GET["job_id"]);
    $_SESSION['paramid'] = $paramid;
};



//pobieramy dane z bazt, potrzebny nam jest uzytkonik , który stworzył przetarg

require_once "config.php";
// Process delete operation after confirmation


$jobid_sql = "select distinct job_tnd_id, job_creation_work from tenders_test.tenders_jobs where job_id = ?";


if ($stmt4 = mysqli_prepare($link, $jobid_sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt4, "i", $param_job);
    $param_job =  $_SESSION['paramid'];
    if (mysqli_stmt_execute($stmt4)) {
        $result_jobid = mysqli_stmt_get_result($stmt4);
        $row1 = mysqli_fetch_array($result_jobid);
        //
        if (!$row1 == NULL) {
            $result_tndid = $row1['job_tnd_id'];
            $result_creation_work = $row1['job_creation_work'];
        } else {
            $result_tndid = null;
            $result_creation_work = null;
        }
    }
}


?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3"> </h2>
                    <div class="alert alert-danger "> <?php echo " Nie masz uprawnień do tej operacji. Oferta został wprowadzona przez " . $result_creation_work; ?> </div>
                    <a href="tasks.php?tnd_id= <?php echo   $result_tndid; ?>" class="btn btn-secondary">Powrót</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>