<?php session_start();

//przekazujemy te parametry - zmienne sesyjne
if (isset($_SESSION["logid"])) {
    $logid = $_SESSION['logid'];
} else {
    header("location:login.php");
};

if (isset($_GET["job_id"])) {
    $paramid = trim($_GET["job_id"]);
    $_SESSION['paramid'] = $paramid;
};


// Include config file
require_once "config.php";


// tutaj pobieramy sobie tnd_id, ponieważ w URL bazujemy na job_id
$tnd_id_sql = "select distinct job_tnd_id from tenders_jobs where job_id = ?";

if ($stmt = mysqli_prepare($link, $tnd_id_sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $param_jobid);
        $param_jobid =  $_SESSION['paramid'];
    if (mysqli_stmt_execute($stmt)) {
        $result_tnd_id = mysqli_stmt_get_result($stmt);
        $row1 = mysqli_fetch_array($result_tnd_id);
        //
        if (!$row1 == NULL) {
            $result_tnd_id = $row1[0];
        } else {
            $result_tnd_id = null;
        }
    }
}

$_SESSION['tndid'] = $result_tnd_id;


// nadajemy do zmiennej log_number kolejny numer zadania w danym przetargu
$sql = "SELECT max(job_number)+1 as number_lp, job_tnd_id FROM tenders_jobs WHERE job_tnd_id = ? GROUP BY job_tnd_id";

if ($stmt1 = mysqli_prepare($link, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt1, "i", $param_tnd_id);

    // Set parameters
    $param_tnd_id = $_SESSION['tndid'];

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt1)) {
        $result = mysqli_stmt_get_result($stmt1);

        if (mysqli_num_rows($result) == 1) {
            /* Fetch result row as an associative array. Since the result set
            contains only one row, we don't need to use while loop */
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            //$tnd_number = $tnd_NIP = $tnd_contractor = $tnd_type = $tnd_segment = $tnd_announce_date = $tnd_submit_date =  "";
            // Retrieve individual field value
            $log_number = $row["number_lp"];
            } 
        else {
            // URL doesn't contain valid id. Redirect to error page
            $log_number = 1;
            }
        } 
    else {
    echo "Oops! Something went wrong. Please try again later.";
    }
mysqli_stmt_close($stmt1);
}

$default_job_number = $log_number;


// tutaj wykonujemy kopiowanie zadania przetargowego
$jobcopy_sql = "insert into tenders_jobs (job_tnd_id, job_number, job_name, job_status, job_resignation_reason, job_resignation_reason_details, job_region, job_department_id, job_merchant_id, job_sales_type, job_deadline, job_current_operator, job_product_id, job_estimated_value, job_units_number, job_property_type_id, job_indexation_type_id, job_takeover23, job_tookover_workers, job_deposit, job_deposit_id, job_deposit_valid_date, job_ZNWU_value, job_contract_type, job_subcontractor, job_internal_areas, job_external_areas, job_qualified_workers, job_weapon, job_intervention_groups, job_criteria_id1, job_criteria_weight1, job_criteria_id2, job_criteria_weight2, job_criteria_id3, job_criteria_weight3, job_criteria_id4, job_criteria_weight4, job_criteria_id5, job_criteria_weight5, job_value_type_id, job_selection_date, job_contractor_budget, job_SAP_chance_number, job_contract_startdate, job_creation_work, job_ZNWU_type, job_eCars, job_differentVAT, job_valueVAT) select job_tnd_id, ? , job_name, job_status, job_resignation_reason, job_resignation_reason_details, job_region, job_department_id, job_merchant_id, job_sales_type, job_deadline, job_current_operator, job_product_id, job_estimated_value, job_units_number, job_property_type_id, job_indexation_type_id, job_takeover23, job_tookover_workers, job_deposit, job_deposit_id, job_deposit_valid_date, job_ZNWU_value, job_contract_type, job_subcontractor, job_internal_areas, job_external_areas, job_qualified_workers, job_weapon, job_intervention_groups, job_criteria_id1, job_criteria_weight1, job_criteria_id2, job_criteria_weight2, job_criteria_id3, job_criteria_weight3, job_criteria_id4, job_criteria_weight4, job_criteria_id5, job_criteria_weight5, job_value_type_id, job_selection_date, job_contractor_budget, job_SAP_chance_number, job_contract_startdate, ?, job_ZNWU_type, job_eCars, job_differentVAT, job_valueVAT from tenders_jobs where job_id = ?";

if ($stmt2 = mysqli_prepare($link, $jobcopy_sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt2, "isi", $param_jobnumber, $param_jobcreationworker, $param_jobid);
    // Set parameters
    $param_jobnumber = $default_job_number;
    $param_jobcreationworker = $logid;
    $param_jobid =  $_SESSION['paramid'];
    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt2)) {
        // Records deleted successfully. Redirect to landing page
        header("location: tasks.php?tnd_id=" . $_SESSION['tndid']);
        exit();
    } else {
        echo "Oops! Something went wrong. Please try again later.";
        echo  mysqli_stmt_error($stmt2);
    }
}

?>

