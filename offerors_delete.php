<?php session_start();

//zmienna sesyjna , po kliknięciu w stronę zapamiętuje parametr
if (isset($_SESSION["logid"])) {
    $logid = $_SESSION['logid'];
} else {
    header("location:login.php");
};

if (isset($_GET["off_id"])) {
    $paramid = trim($_GET["off_id"]);
    $_SESSION['paramid'] = $paramid;
};



require_once "config.php";
// Process delete operation after confirmation


$jobid_sql = "select distinct off_job_id, off_creation_work from offerors where off_id = ?";


if ($stmt4 = mysqli_prepare($link, $jobid_sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt4, "i", $param_job);
    $param_job =  $_SESSION['paramid'];
    if (mysqli_stmt_execute($stmt4)) {
        $result_jobid = mysqli_stmt_get_result($stmt4);
        $row1 = mysqli_fetch_array($result_jobid);
        //
        if (!$row1 == NULL) {
            $result_jobid = $row1['off_job_id'];
            $result_creation_work = $row1['off_creation_work'];
        } else {
            $result_jobid = null;
            $result_creation_work = null; 
        }
    }
}

$_SESSION['jobid'] = $result_jobid;
$_SESSION['offid'] = $_GET["off_id"];


//sprawdzamy, czy aktualne użytkownik na sesji to ten sam, który założył przetarg LUB czy aktualny użytkownik jest adminem -- jeżeli tak nie jest przychodzimy do else
    if (isset($_POST["off_id"]) and !empty($_POST["off_id"]) and ($result_creation_work  == $_SESSION['logid'] or $_SESSION['logid'] == 'Administrator')   ) {
        // Include config file
        
    
        require_once "config.php";
  

        // Prepare a delete statement
        $sql = "DELETE FROM offerors WHERE off_id = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_id);
            // Set parameters
            $param_id = trim($_POST["off_id"]);
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records deleted successfully. Redirect to landing page
                header("location: offerors.php?job_id=" . $_POST["job_id"]   );
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
                echo  mysqli_stmt_error($stmt);
            }
        }
    
    } else {
        // Check existence of id parameter
        if (empty(trim($_GET["off_id"]))) {
            // URL doesn't contain id parameter. Redirect to error page
            header("location: error.php");
            exit(); 
        } else {
              // jeżeli aktualny użytkownik nie założył przetargu ani nie jest administratorem przechodzimy do tender_wrongauthority.php
            if($result_creation_work <> $_SESSION['logid'] and $_SESSION['logid'] <> 'Administrator') {
            header("location: offerors_wrongauthority.php?off_id=" .  $_GET["off_id"]);
        }
    }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Delete Record</title>
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
                        <h2 class="mt-5 mb-3">Usuń przetarg z bazy</h2>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="alert alert-danger">
                                <input type="hidden" name="off_id" value="<?php echo trim($_GET["off_id"]); ?>" />
                                <input type="hidden" name="job_id" value="<?php echo $result_jobid; ?>" />
                                <p>Czy na pewno chcesz usunąć ten rekord?</p>
                                <p>
                                    
                                    <input type="submit" value="Tak" class="btn btn-danger">
                                    <a href="offerors.php?job_id=<?php echo $result_jobid ?>" class="btn btn-secondary">Nie</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>