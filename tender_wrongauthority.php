
<?php session_start();


if (isset($_SESSION["logid"])) {
   $logid = $_SESSION['logid'];
 } else {
   header("location:login.php");
};

if (isset($_GET["tnd_number"])) {
    $paramid = trim($_GET["tnd_number"]);
    $_SESSION['paramid'] = $paramid;
};



require_once "config.php";

if (isset($_SESSION['paramid']) && !empty(trim($_SESSION['paramid']))) {
    // Get URL parameter
    $id =  $_SESSION['paramid'];
    // Prepare a select statement
    $sql = "SELECT * FROM tenders_test.tenders t 
        left join tenders_test.tender_types tt on tt.tend_type_id = t.tnd_type
        left join tenders_test.contractors cnt on t.tnd_contractor_id= cnt.cnt_id
        left join tenders_test.segments seg on seg.segm_id= t.tnd_segment_id WHERE tnd_number = ?";
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
                $tnd_modification_date = $row1["tnd_record_modification_date"];
                $tnd_creation_date = $row1["tnd_record_creation_date"];
                $tnd_modification_emp = $row1["tnd_modification_worker"];
                $tnd_creation_emp = $row1["tnd_creation_worker"];
            } else {

                exit();
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
                    <div class="alert alert-danger "> <?php echo" Nie masz uprawnień do tej operacji. Przetarg został założony przez " . $tnd_creation_emp  ; ?> </div>
                    <a href="tenders.php" class="btn btn-secondary">Powrót</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>