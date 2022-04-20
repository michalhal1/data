<?php session_start();


if (isset($_SESSION["logid"])) {
    $logid = $_SESSION['logid'];
} else {
    header("location:login.php");
};

if (isset($_GET["off_id"])) {
    $paramid = trim($_GET["off_id"]);
    $_SESSION['paramid'] = $paramid;
};


//pobieramy dane z bazt, potrzebny nam jest uzytkonik , który stworzył przetarg
require_once "config.php";

if (isset($_SESSION['paramid']) && !empty(trim($_SESSION['paramid']))) {
    // Get URL parameter
    $id =  $_SESSION['paramid'];
    // Prepare a select statement
    $sql = "select distinct off_job_id, off_creation_work from tenders_test.offerors where off_id = ?";
    if ($stmt1 = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt1, "s", $param_id);

        // Set parameters
        $param_id = $id;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt1)) {
            $result1 = mysqli_stmt_get_result($stmt1);

            if (mysqli_num_rows($result1) == 1) {
                /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
                //$tnd_number = $tnd_NIP = $tnd_contractor = $tnd_type = $tnd_segment = $tnd_announce_date = $tnd_submit_date =  "";
                // Retrieve individual field value

                $off_creation_work = $row1["off_creation_work"];
                $off_job_id = $row1["off_job_id"];
            } else {

                // exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
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
                    <div class="alert alert-danger "> <?php echo " Nie masz uprawnień do tej operacji. Oferta został wprowadzona przez " . $off_creation_work; ?> </div>
                    <a href="offerors.php?job_id= <?php echo urlencode($off_job_id); ?>" class="btn btn-secondary">Powrót</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>