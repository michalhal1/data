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

// Include config file
require_once "config.php";


// tutaj pobieramy sobie tnd_id, ponieważ w URL bazujemy na job_id
$tnd_id_sql = "select distinct job_tnd_id from tenders_jobs where job_id = ?";

if ($stmt = mysqli_prepare($link, $tnd_id_sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $param_job);
        $param_job =  $_SESSION['paramid'];
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



// Define variables and initialize with empty values
$jobnumber = $jobname = $jobproduct = $jobpropertyname = $jobsalestype = $jobdeadline = $jobregion = $jobdepartment = $jobmerchant = $jobSAPnumber = $jobstatus = $jobresignationreason = $jobresignationreasondetails = $jobestimatedvalue = $jobvaluetype = $jobunitsnumber = $jobcontractorbudget = $jobdeposit = $jobdeposittype = $jobdepositvaliddate = $jobcurrentoperator = $jobindexname = $jobtakeover23 = $jobtookoverworkers = $jobZNWUtype = $jobZNWUvalue = $jobcontracttype = $jobsubcontractor = $jobinternalareas = $jobexternalareas = $jobqualifiedworkers = $jobweapon = $jobinterventiongroups = $jobcriterianame1 = $jobcriteriaweight1 = $jobcriterianame2 = $jobcriteriaweight2 = $jobcriterianame3 = $jobcriteriaweight3 = $jobcriterianame4 = $jobcriteriaweight4 = $jobcriterianame5 = $jobcriteriaweight5 = NULL;
$jobnumber_err = $jobname_err = $jobproduct_err = $jobpropertyname_err = $jobsalestype_err = $jobdeadline_err = $jobregion_err = $jobdepartment_err = $jobmerchant_err = $jobSAPnumber_err = $jobstatus_err = $jobresignationreason_err = $jobresignationreasondetails_err = $jobestimatedvalue_err = $jobvaluetype_err = $jobunitsnumber_err = $jobcontractorbudget_err = $jobdeposit_err = $jobdeposittype_err = $jobdepositvaliddate_err = $jobcurrentoperator_err = $jobindexname_err = $jobtakeover23_err = $jobtookoverworkers_err = $jobZNWUtype_err = $jobZNWUvalue_err = $jobcontracttype_err = $jobsubcontractor_err = $jobinternalareas_err = $jobexternalareas_err = $jobqualifiedworkers_err = $jobweapon_err = $jobinterventiongroups_err = $jobcriterianame1_err = $jobcriteriaweight1_err = $jobcriterianame2_err = $jobcriteriaweight2_err = $jobcriterianame3_err = $jobcriteriaweight3_err = $jobcriterianame4_err = $jobcriteriaweight4_err = $jobcriterianame5_err = $jobcriteriaweight5_err = NULL;
$jobproduct_text = $jobpropertyname_text = $jobsalestype_text = $jobregion_text = $jobdepartment_text = $jobmerchant_text = $jobstatus_text = $jobresignationreason_text = $jobresignationreasondetails_text = $jobvaluetype_text = $jobdeposittype_text = $jobcurrentoperator_text = $jobindexname_text = $jobtakeover23_text = $jobZNWUtype_text = $jobcontracttype_text = $jobsubcontractor_text = $jobqualifiedworkers_text = $jobweapon_text = $jobinterventiongroups_text = $jobcriterianame1_text = $jobcriterianame2_text = $jobcriterianame3_text = $jobcriterianame4_text = $jobcriterianame5_text = NULL;

// nadajemy do zmiennej log_number kolejny numer zadania w danym przetargu
//$sql = "SELECT max(job_number)+1 as number_lp, job_tnd_id FROM tenders_jobs WHERE job_tnd_id = ? GROUP BY job_tnd_id";

//if ($stmt = mysqli_prepare($link, $sql)) {
    // Bind variables to the prepared statement as parameters
    //mysqli_stmt_bind_param($stmt, "i", $param_tnd_id);

    // Set parameters
    //$param_tnd_id = $paramid;

    // Attempt to execute the prepared statement
    //if (mysqli_stmt_execute($stmt)) {
        //$result1 = mysqli_stmt_get_result($stmt);

        //if (mysqli_num_rows($result1) == 1) {
            /* Fetch result row as an associative array. Since the result set
            contains only one row, we don't need to use while loop */
            //$row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
            //$tnd_number = $tnd_NIP = $tnd_contractor = $tnd_type = $tnd_segment = $tnd_announce_date = $tnd_submit_date =  "";
            // Retrieve individual field value
            //$log_number = $row["number_lp"];
            //} 
        //else {
            // URL doesn't contain valid id. Redirect to error page
            //$log_number = 1;
            //}
        //} 
    //else {
    //echo "Oops! Something went wrong. Please try again later.";
    //}
//mysqli_stmt_close($stmt);
//}

//$default_job_number = $log_number;


// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate jobnumber
    $input_job_number = trim($_POST["jobnumber"]);
    if (empty($input_job_number)) {
        $jobnumber_err = "Wpisz numer przetargu";} 
    else {
        $jobnumber = $input_job_number;
    }

    //validate jobname
    $input_job_name = trim($_POST["jobname"]);
    if (empty($input_job_name)) {
        $jobname_err = "Wpisz nazwę zamawiającego";}
    elseif (strlen($input_job_name) <= 3) {
        $jobname_err = "Wpisz poprawną nazwę zamawiającego";} 
    else {
        $jobname = $input_job_name;
    }

    //validate jobproduct
    $input_job_product = trim($_POST["jobproduct"]);
    if (empty($input_job_product)) {
        $jobproduct_err = "Wybierz produkt";
    } else {
        $jobproduct = $input_job_product;
    }

    //validate jobpropertyname
    $input_job_propertyname = trim($_POST["jobpropertyname"]);
    if (empty($input_job_propertyname)) {
        $jobpropertyname_err = "Wybierz rodzaj obiektu";
    } else {
        $jobpropertyname = $input_job_propertyname;
    }

     //validate jobsalestype
     $input_job_salestype = trim($_POST["jobsalestype"]);
     if (empty($input_job_salestype)) {
         $jobsalestype_err = "Wybierz typ sprzedaży";
     } else {
         $jobsalestype = $input_job_salestype;
     }

    //validate jobdeadline
    $input_job_deadline = trim($_POST["jobdeadline"]);
    if (empty($input_job_deadline)) {
        $jobdeadline_err = "Wybierz termin realizacji";
    } elseif (!is_numeric($input_job_deadline)) {
        $jobdeadline_err = "Wpisz wartość liczbową";
    } else {
        $jobdeadline = $input_job_deadline;
    }

    //validate jobregion
    $input_job_region = trim($_POST["jobregion"]);
    if (empty($input_job_region)) {
        $jobregion_err = "Wybierz region";
    } else {
        $jobregion = $input_job_region;
    }

    //validate jobdepartment
    $input_job_department = trim($_POST["jobdepartment"]);
    if (empty($input_job_department)) {
        $jobdepartment_err = "Wybierz oddział";
    } else {
        $jobdepartment = $input_job_department;
    }

    //validate jobmerchant
    $input_job_merchant = trim($_POST["jobmerchant"]);
    if (empty($input_job_merchant)) {
        $jobmerchant_err = "Wybierz handlowca";
    } else {
        $jobmerchant = $input_job_merchant;
    }

    //validate jobSAPnumber
    $input_job_SAPnumber = trim($_POST["jobSAPnumber"]);
    if (empty($input_job_SAPnumber)) {
        $jobSAPnumber_err = "Wpisz numer szansy";
    } elseif (!is_numeric($input_job_SAPnumber)) {
        $jobSAPnumber_err = "Wpisz numer szansy";
    } elseif (strlen($input_job_SAPnumber) != 10 || !ctype_digit($input_job_SAPnumber)) {
        $jobSAPnumber_err = "Wpisz poprawny numer szansy";
    } else {
        $jobSAPnumber = $input_job_SAPnumber;
    }

    //validate jobstatus
    $input_job_status = trim($_POST["jobstatus"]);
    if (empty($input_job_status)) {
        $jobstatus_err = "Wybierz status";
    } else {
        $jobstatus = $input_job_status;
    }

    //validate jobresignationreason
    $input_job_resignationreason = trim($_POST["jobresignationreason"]);
    if (empty($input_job_resignationreason)) {
        $jobresignationreason_err = "Wybierz powód rezygnacji";
    } else {
        $jobresignationreason = $input_job_resignationreason;
    }

    //validate jobresignationreasondetails
    $input_job_resignationreasondetails = trim($_POST["jobresignationreasondetails"]);
    if (empty($input_job_resignationreasondetails)) {
        $jobresignationreasondetails_err = "Wpisz szczegółowy powód rezygnacji";
    } else {
        $jobresignationreasondetails = $input_job_resignationreasondetails;
    }

    //validate jobestimatedvalue
    $input_job_estimatedvalue = trim($_POST["jobestimatedvalue"]);
    if (empty($input_job_estimatedvalue)) {
        $jobestimatedvalue_err = "Wpisz wartość szacunkową";
    } elseif (!is_numeric($input_job_estimatedvalue)) {
        $jobestimatedvalue_err = "Wpisz wartość szacunkową";
    } else {
        $jobestimatedvalue = $input_job_estimatedvalue;
    }

    //validate jobvaluetype
    $input_job_valuetype = trim($_POST["jobvaluetype"]);
    if (empty($input_job_valuetype)) {
        $jobvaluetype_err = "Wybierz typ wartości";
    } else {
        $jobvaluetype = $input_job_valuetype;
    }

    //validate jobunitsnumber
    $input_job_unitsnumber = trim($_POST["jobunitsnumber"]);
    if (empty($input_job_unitsnumber)) {
        $jobunitsnumber_err = "Wpisz liczbę jednostek";
    } elseif (!is_numeric($input_job_unitsnumber)) {
        $jobunitsnumber_err = "Wpisz liczbę jednostek";
    } else {
        $jobunitsnumber = $input_job_unitsnumber;
    }

    //validate jobcontractorbudget
    $input_job_contractorbudget = trim($_POST["jobcontractorbudget"]);
    if (empty($input_job_contractorbudget)) {
        $jobcontractorbudget_err = "Wpisz budżet zamawiającego";
    } elseif (!is_numeric($input_job_contractorbudget)) {
        $jobcontractorbudget_err = "Wpisz budżet zamawiającego";
    } else {
        $jobcontractorbudget = $input_job_contractorbudget;
    }

    //validate jobdeposit
    $input_job_deposit = trim($_POST["jobdeposit"]);
    if (empty($input_job_deposit)) {
        $jobdeposit_err = "Wpisz kwotę wadium";
    } elseif (!is_numeric($input_job_deposit)) {
        $jobdeposit_err = "Wpisz kwotę wadium";
    } else {
        $jobdeposit = $input_job_deposit;
    }

    //validate jobdeposittype
    $input_job_deposittype = trim($_POST["jobdeposittype"]);
    if (empty($input_job_deposittype)) {
        $jobdeposittype_err = "Wybierz rodzaj wadium";
    } else {
        $jobdeposittype = $input_job_deposittype;
    }

    //validate jobdepositvaliddate
    $input_job_depositvaliddate = trim($_POST["jobdepositvaliddate"]);
    if (empty($input_job_depositvaliddate)) {
        $jobdepositvaliddate_err = "Wybierz datę ważności wadium";
    } else {
        $jobdepositvaliddate = $input_job_depositvaliddate;
    }

    //validate jobcurrentoperator
    $input_job_currentoperator = trim($_POST["jobcurrentoperator"]);
    if (empty($input_job_currentoperator)) {
        $jobcurrentoperator_err = "Wybierz aktualnego wykonawcę";
    } else {
        $jobcurrentoperator = $input_job_currentoperator;
    }

    //validate jobindexname
    $input_job_indexname = trim($_POST["jobindexname"]);
    if (empty($input_job_indexname)) {
        $jobindexname_err = "Uzupełnij pole waloryzacja";
    } else {
        $jobindexname = $input_job_indexname;
    }

    //validate jobtakeover23
    $input_job_takeover23 = trim($_POST["jobtakeover23"]);
    if (empty($input_job_takeover23)) {
        $jobtakeover23_err = "Uzupełnij pole przejęcie23";
    } else {
        $jobtakeover23 = $input_job_takeover23;
    }

    //validate jobtookoverworkers
    $input_job_tookoverworkers = trim($_POST["jobtookoverworkers"]);
    if (empty($input_job_tookoverworkers)) {
        $jobtookoverworkers_err = "Uzupełnij liczbę pracowników przejmowanych";
    } elseif (!is_numeric($input_job_tookoverworkers)) {
        $jobtookoverworkers_err = "Uzupełnij liczbę pracowników przejmowanych";
    } else {
        $jobtookoverworkers = $input_job_tookoverworkers;
    }

    //validate jobZNWUtype
    $input_job_ZNWUtype = trim($_POST["jobZNWUtype"]);
    if (empty($input_job_ZNWUtype)) {
        $jobZNWUtype_err = "Uzupełnij pole rodzaj ZNWU";
    } else {
        $jobZNWUtype = $input_job_ZNWUtype;
    }

    //validate jobZNWUvalue
    $input_job_ZNWUvalue = trim($_POST["jobZNWUvalue"]);
    if (empty($input_job_ZNWUvalue)) {
        $jobZNWUvalue_err = "Uzupełnij pole wartość ZNWU";
    } elseif (!is_numeric($input_job_ZNWUvalue)) {
        $jobZNWUvalue_err = "Uzupełnij pole wartość ZNWU";
    } else {
        $jobZNWUvalue = $input_job_ZNWUvalue;
    }

    //validate jobcontracttype
    $input_job_contracttype = trim($_POST["jobcontracttype"]);
    if (empty($input_job_contracttype)) {
        $jobcontracttype_err = "Uzupełnij pole rodzaj umowy";
    } else {
        $jobcontracttype = $input_job_contracttype;
    }

    //validate jobsubcontractor
    $input_job_subcontractor = trim($_POST["jobsubcontractor"]);
    if (empty($input_job_subcontractor)) {
        $jobsubcontractor_err = "Uzupełnij pole podwykonawstwo";
    } else {
        $jobsubcontractor = $input_job_subcontractor;
    }

    //validate jobinternalareas
    $input_job_internalareas = trim($_POST["jobinternalareas"]);
    if (empty($input_job_internalareas)) {
        $jobinternalareas_err = "Uzupełnij pole tereny wewnętrzne";
    } elseif (!is_numeric($input_job_internalareas)) {
        $jobinternalareas_err = "Uzupełnij pole tereny wewnętrzne";
    } else {
        $jobinternalareas = $input_job_internalareas;
    }

    //validate jobexternalareas
    $input_job_externalareas = trim($_POST["jobexternalareas"]);
    if (empty($input_job_externalareas)) {
        $jobexternalareas_err = "Uzupełnij pole tereny zewnętrzne";
    } elseif (!is_numeric($input_job_externalareas)) {
        $jobexternalareas_err = "Uzupełnij pole tereny zewnętrzne";
    } else {
        $jobexternalareas = $input_job_externalareas;
    }

    //validate jobqualifiedworkers
    $input_job_qualifiedworkers = trim($_POST["jobqualifiedworkers"]);
    if (empty($input_job_qualifiedworkers)) {
        $jobqualifiedworkers_err = "Uzupełnij pole podwykonawstwo";
    } else {
        $jobqualifiedworkers = $input_job_qualifiedworkers;
    }

    //validate jobweapon
    $input_job_weapon = trim($_POST["jobweapon"]);
    if (empty($input_job_weapon)) {
        $jobweapon_err = "Uzupełnij pole podwykonawstwo";
    } else {
        $jobweapon = $input_job_weapon;
    }

    //validate jobinterventiongroups
    $input_job_interventiongroups = trim($_POST["jobinterventiongroups"]);
    if (empty($input_job_interventiongroups)) {
        $jobinterventiongroups_err = "Uzupełnij pole podwykonawstwo";
    } else {
        $jobinterventiongroups = $input_job_interventiongroups;
    }
    
    //validate jobcriterianame1
    $input_job_criterianame1 = trim($_POST["jobcriterianame1"]);
    if (empty($input_job_criterianame1)) {
        $jobcriterianame1_err = "Uzupełnij pole kryterium wyboru";
    } else {
        $jobcriterianame1 = $input_job_criterianame1;
    }

    //validate jobcriteriaweight1
    $input_job_criteriaweight1 = trim($_POST["jobcriteriaweight1"]);
    if (empty($input_job_criteriaweight1)) {
        $jobcriteriaweight1_err = "Uzupełnij pole waga kryterium";
    } elseif (!is_numeric($input_job_criteriaweight1)) {
        $jobcriteriaweight1_err = "Uzupełnij pole waga kryterium";
    } else {
        $jobcriteriaweight1 = $input_job_criteriaweight1;
    }

    //validate jobcriterianame2
    $input_job_criterianame2 = trim($_POST["jobcriterianame2"]);
    if (empty($input_job_criterianame2)) {
        $jobcriterianame2_err = "Uzupełnij pole kryterium wyboru";
    } else {
        $jobcriterianame2 = $input_job_criterianame2;
    }

    //validate jobcriteriaweight2
    $input_job_criteriaweight2 = trim($_POST["jobcriteriaweight2"]);
    if (empty($input_job_criteriaweight2)) {
        $jobcriteriaweight2_err = "Uzupełnij pole waga kryterium";
    } elseif (!is_numeric($input_job_criteriaweight2)) {
        $jobcriteriaweight2_err = "Uzupełnij pole waga kryterium";
    } else {
        $jobcriteriaweight2 = $input_job_criteriaweight2;
    }

    //validate jobcriterianame3
    $input_job_criterianame3 = trim($_POST["jobcriterianame3"]);
    if (empty($input_job_criterianame3)) {
        $jobcriterianame3_err = "Uzupełnij pole kryterium wyboru";
    } else {
        $jobcriterianame3 = $input_job_criterianame3;
    }

    //validate jobcriteriaweight3
    $input_job_criteriaweight3 = trim($_POST["jobcriteriaweight3"]);
    if (empty($input_job_criteriaweight3)) {
        $jobcriteriaweight3_err = "Uzupełnij pole waga kryterium";
    } elseif (!is_numeric($input_job_criteriaweight3)) {
        $jobcriteriaweight3_err = "Uzupełnij pole waga kryterium";
    } else {
        $jobcriteriaweight3 = $input_job_criteriaweight3;
    }

    //validate jobcriterianame4
    $input_job_criterianame4 = trim($_POST["jobcriterianame4"]);
    if (empty($input_job_criterianame4)) {
        $jobcriterianame4_err = "Uzupełnij pole kryterium wyboru";
    } else {
        $jobcriterianame4 = $input_job_criterianame4;
    }

    //validate jobcriteriaweight4
    $input_job_criteriaweight4 = trim($_POST["jobcriteriaweight4"]);
    if (empty($input_job_criteriaweight4)) {
        $jobcriteriaweight4_err = "Uzupełnij pole waga kryterium";
    } elseif (!is_numeric($input_job_criteriaweight4)) {
        $jobcriteriaweight4_err = "Uzupełnij pole waga kryterium";
    } else {
        $jobcriteriaweight4 = $input_job_criteriaweight4;
    }

    //validate jobcriterianame5
    $input_job_criterianame5 = trim($_POST["jobcriterianame5"]);
    if (empty($input_job_criterianame5)) {
        $jobcriterianame5_err = "Uzupełnij pole kryterium wyboru";
    } else {
        $jobcriterianame5 = $input_job_criterianame5;
    }

    //validate jobcriteriaweight5
    $input_job_criteriaweight5 = trim($_POST["jobcriteriaweight5"]);
    if (empty($input_job_criteriaweight5)) {
        $jobcriteriaweight5_err = "Uzupełnij pole waga kryterium";
    } elseif (!is_numeric($input_job_criteriaweight5)) {
        $jobcriteriaweight5_err = "Uzupełnij pole waga kryterium";
    } else {
        $jobcriteriaweight5 = $input_job_criteriaweight5;
    }

    //validate jobcreationworker
    $jobmodificationworker = $logid;


    // TUTAJ MAMY UPDATOWANIE BAZY!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

    if (empty($jobnumber_err) && empty($jobname_err)  && empty($jobproduct_err) && empty($jobpropertyname_err) && empty($jobsalestype_err) && empty($jobdeadline_err) && empty($jobregion_err) && empty($jobdepartment_err) && empty($jobmerchant_err) && empty($jobSAPnumber_err) && empty($jobstatus_err)) {
    // Prepare an insert statement

        $param_job_id = trim($_POST["paramid"]);

        $sql = "UPDATE tenders_jobs SET job_number=?, job_name=?, job_product_id=?, job_property_type_id=?, job_sales_type=?, job_deadline=? ,job_region=?, job_department_id=?, job_merchant_id=?, job_SAP_chance_number=?, job_status=?, job_resignation_reason=?, job_resignation_reason_details=?, job_estimated_value=?, job_value_type_id=?, job_units_number=?, job_contractor_budget=?, job_deposit=?, job_deposit_id=?, job_deposit_valid_date=?, job_current_operator=?, job_indexation_type_id=?, job_takeover23=?, job_tookover_workers=?, job_ZNWU_type=?, job_ZNWU_value=?, job_contract_type=?, job_subcontractor=?, job_internal_areas=?, job_external_areas=?, job_qualified_workers=?, job_weapon=?, job_intervention_groups=?, job_criteria_id1=?, job_criteria_weight1=?, job_criteria_id2=?, job_criteria_weight2=?, job_criteria_id3=?, job_criteria_weight3=?, job_criteria_id4=?, job_criteria_weight4=?, job_criteria_id5=?, job_criteria_weight5=?, job_modification_date = now(), job_modification_work = ? where job_id=?";

        if ($stmt = mysqli_prepare($link, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isiiiiiiiiisididddisiisiidiiddiiiidididididss", $param_jobnumber, $param_jobname, $param_jobproduct, $param_jobpropertyname, $param_jobsalestype, $param_jobdeadline, $param_jobregion, $param_jobdepartment, $param_jobmerchant, $param_jobSAPnumber, $param_jobstatus, $param_jobresignationreason, $param_jobresignationreasondetails, $param_jobestimatedvalue, $param_jobvaluetype, $param_jobunitsnumber, $param_jobcontractorbudget, $param_jobdeposit, $param_jobdeposittype, $param_jobdepositvaliddate, $param_jobcurrentoperator, $param_jobindexname, $param_jobtakeover23, $param_jobtookoverworkers, $param_jobZNWUtype, $param_jobZNWUvalue, $param_jobcontracttype, $param_jobsubcontractor, $param_jobinternalareas, $param_jobexternalareas, $param_jobqualifiedworkers, $param_jobweapon, $param_jobinterventiongroups, $param_jobcriterianame1, $param_jobcriteriaweight1, $param_jobcriterianame2, $param_jobcriteriaweight2, $param_jobcriterianame3, $param_jobcriteriaweight3, $param_jobcriterianame4, $param_jobcriteriaweight4, $param_jobcriterianame5, $param_jobcriteriaweight5, $param_jobmodificationworker, $param_job_id);
               
            $param_jobnumber = $jobnumber;
            $param_jobname = $jobname;
            $param_jobproduct = $jobproduct;
            $param_jobpropertyname = $jobpropertyname;
            $param_jobsalestype = $jobsalestype;
            $param_jobdeadline = $jobdeadline;
            $param_jobregion = $jobregion;
            $param_jobdepartment = $jobdepartment;
            $param_jobmerchant = $jobmerchant;
            $param_jobSAPnumber = $jobSAPnumber;
            $param_jobstatus = $jobstatus;
            $param_jobresignationreason = $jobresignationreason;
            $param_jobresignationreasondetails = $jobresignationreasondetails;
            $param_jobestimatedvalue = $jobestimatedvalue;
            $param_jobvaluetype = $jobvaluetype;
            $param_jobunitsnumber = $jobunitsnumber;
            $param_jobcontractorbudget = $jobcontractorbudget;
            $param_jobdeposit = $jobdeposit;
            $param_jobdeposittype = $jobdeposittype;
            $param_jobdepositvaliddate = $jobdepositvaliddate;
            $param_jobcurrentoperator = $jobcurrentoperator;
            $param_jobindexname = $jobindexname;
            $param_jobtakeover23 = $jobtakeover23;
            $param_jobtookoverworkers = $jobtookoverworkers;
            $param_jobZNWUtype = $jobZNWUtype;
            $param_jobZNWUvalue = $jobZNWUvalue;
            $param_jobcontracttype = $jobcontracttype;
            $param_jobsubcontractor = $jobsubcontractor;
            $param_jobinternalareas = $jobinternalareas;
            $param_jobexternalareas = $jobexternalareas;
            $param_jobqualifiedworkers  = $jobqualifiedworkers;
            $param_jobweapon = $jobweapon;
            $param_jobinterventiongroups = $jobinterventiongroups;
            $param_jobcriterianame1 = $jobcriterianame1;
            $param_jobcriteriaweight1 = $jobcriteriaweight1;
            $param_jobcriterianame2 = $jobcriterianame2;
            $param_jobcriteriaweight2 = $jobcriteriaweight2;
            $param_jobcriterianame3 = $jobcriterianame3;
            $param_jobcriteriaweight3 = $jobcriteriaweight3;
            $param_jobcriterianame4 = $jobcriterianame4;
            $param_jobcriteriaweight4 = $jobcriteriaweight4;
            $param_jobcriterianame5 = $jobcriterianame5;
            $param_jobcriteriaweight5 = $jobcriteriaweight5;
            $param_jobmodificationworker = $jobmodificationworker;
            $param_job_id = $_SESSION['paramid'];
            

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {

                $param_tnd_id = $_SESSION['tndid'];
                // Records created successfully. Redirect to landing page
                //echo "Dodano nowy przetarg";
                header("location: job_update_ok.php?tnd_id=" . $param_tnd_id);
                // echo $_POST['off_winner'];
                // echo trim($_POST["inputname"]); 
                // echo $off_points1;
                exit();}
            else {
                echo "Ups! Wystąpił błąd";
                echo mysqli_stmt_error($stmt);
            }


            // Close statement
            mysqli_stmt_close($stmt);
        }
    } else {

        $selected_jobproduct_sql = "select distinct prod_name from products where prod_active=1 and prod_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobproduct_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobproduct);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobproduct_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobproduct_text);
                //
                if (!$row1 == NULL) {
                    $jobproduct_text = $row1[0];
                } else {
                    $jobproduct_text = NULL;
                }
            }
        }

        $selected_jobpropertyname_sql = "select distinct jobproperty_name from job_properties where jobproperty_active=1 and jobproperty_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobpropertyname_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobpropertyname);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobpropertyname_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobpropertyname_text);
                //
                if (!$row1 == NULL) {
                    $jobpropertyname_text = $row1[0];
                } else {
                    $jobpropertyname_text = NULL;
                }
            }
        }

        $selected_jobsalestype_sql = "select distinct sal_type_name from sales_types where sal_type_active=1 and sal_type_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobsalestype_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobsalestype);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobsalestype_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobsalestype_text);
                //
                if (!$row1 == NULL) {
                    $jobsalestype_text = $row1[0];
                } else {
                    $jobsalestype_text = NULL;
                }
            }
        }
        
        $selected_jobregion_sql = "select distinct reg_name from regions where reg_active=1 and reg_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobregion_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobregion);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobregion_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobregion_text);
                //
                if (!$row1 == NULL) {
                    $jobregion_text = $row1[0];
                } else {
                    $jobregion_text = NULL;
                }
            }
        }  
        
        $selected_jobdepartment_sql = "select distinct dep_name from departments where dep_active=1 and dep_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobdepartment_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobdepartment);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobdepartment_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobdepartment_text);
                //
                if (!$row1 == NULL) {
                    $jobdepartment_text = $row1[0];
                } else {
                    $jobdepartment_text = NULL;
                }
            }
        }

        $selected_jobmerchant_sql = "select distinct concat(merch_name, ' ', merch_surname) as merchant_name from merchants where merch_active=1 and merch_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobmerchant_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobmerchant);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobmerchant_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobmerchant_text);
                //
                if (!$row1 == NULL) {
                    $jobmerchant_text = $row1[0];
                } else {
                    $jobmerchant_text = NULL;
                }
            }
        }

        $selected_jobstatus_sql = "select distinct jobstat_name from job_statuses where jobstat_active=1 and jobstat_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobstatus_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobstatus);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobstatus_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobstatus_text);
                //
                if (!$row1 == NULL) {
                    $jobstatus_text = $row1[0];
                } else {
                    $jobstatus_text = NULL;
                }
            }
        }

        /*
        $selected_jobresignationreason_sql = "select distinct jobresign_group from job_resignations where jobresign_active=1 and jobresign_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobresignationreason_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobresignationreason);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobresignationreason_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobresignationreason_text);
                //
                if (!$row1 == NULL) {
                    $jobresignationreason_text = $row1[0];
                } else {
                    $jobresignationreason_text = NULL;
                }
            }
        }
        */

        $selected_jobresignationreasondetails_sql = "select distinct jobresign_name from job_resignations where jobresign_active=1 and jobresign_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobresignationreasondetails_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobresignationreasondetails);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobresignationreasondetails_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobresignationreasondetails_text);
                //
                if (!$row1 == NULL) {
                    $jobresignationreasondetails_text = $row1[0];
                } else {
                    $jobresignationreasondetails_text = NULL;
                }
            }
        }

        $selected_jobvaluetype_sql = "select distinct jobval_name from job_value_types where jobval_active=1 and jobval_type_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobvaluetype_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobvaluetype);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobvaluetype_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobvaluetype_text);
                //
                if (!$row1 == NULL) {
                    $jobvaluetype_text = $row1[0];
                } else {
                    $jobvaluetype_text = NULL;
                }
            }
        }

        $selected_jobdeposittype_sql = "select distinct jobdeposit_name from job_deposit_types where jobdeposit_active=1 and jobdeposit_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobdeposittype_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobdeposittype);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobdeposittype_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobdeposittype_text);
                //
                if (!$row1 == NULL) {
                    $jobdeposittype_text = $row1[0];
                } else {
                    $jobdeposittype_text = NULL;
                }
            }
        }

        $selected_jobcurrentoperator_sql = "select distinct offnames_name from offerors_names where offnames_active=1 and offnames_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobcurrentoperator_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobcurrentoperator);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobcurrentoperator_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobcurrentoperator_text);
                //
                if (!$row1 == NULL) {
                    $jobcurrentoperator_text = $row1[0];
                } else {
                    $jobcurrentoperator_text = NULL;
                }
            }
        }

        $selected_jobindexname_sql = "select distinct jobindex_name from job_indexation_types where jobindex_active=1 and jobindex_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobindexname_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobindexname);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobindexname_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobindexname_text);
                //
                if (!$row1 == NULL) {
                    $jobindexname_text = $row1[0];
                } else {
                    $jobindexname_text = NULL;
                }
            }
        }

        /*
        $selected_jobtakeover23_sql = "select distinct offnames_name from offerors_names where offnames_active=1 and offnames_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobtakeover23_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobtakeover23);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobtakeover23_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobtakeover23_text);
                //
                if (!$row1 == NULL) {
                    $jobtakeover23_text = $row1[0];
                } else {
                    $jobtakeover23_text = NULL;
                }
            }
        }
        */

        $selected_jobZNWUtype_sql = "select distinct jobZNWU_name from job_ZNWU_types where jobZNWU_active=1 and jobZNWU_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobZNWUtype_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobZNWUtype);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobZNWUtype_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobZNWUtype_text);
                //
                if (!$row1 == NULL) {
                    $jobZNWUtype_text = $row1[0];
                } else {
                    $jobZNWUtype_text = NULL;
                }
            }
        }

        $selected_jobcontracttype_sql = "select distinct jobcontract_name from job_contract_types where jobcontract_active=1 and jobcontract_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobcontracttype_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobcontracttype);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobcontracttype_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobcontracttype_text);
                //
                if (!$row1 == NULL) {
                    $jobcontracttype_text = $row1[0];
                } else {
                    $jobcontracttype_text = NULL;
                }
            }
        }

        $selected_jobsubcontractor_sql = "select distinct jobsubcontractor_name from job_subcontractors where jobsubcontractor_active=1 and jobsubcontractor_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobsubcontractor_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobsubcontractor);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobsubcontractor_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobsubcontractor_text);
                //
                if (!$row1 == NULL) {
                    $jobsubcontractor_text = $row1[0];
                } else {
                    $jobsubcontractor_text = NULL;
                }
            }
        }

        $selected_jobqualifiedworkers_sql = "select distinct jobqualifiedworker_name from job_qualifiedworkers where jobqualifiedworker_active=1 and jobqualifiedworker_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobqualifiedworkers_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobqualifiedworkers);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobqualifiedworkers_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobqualifiedworkers_text);
                //
                if (!$row1 == NULL) {
                    $jobqualifiedworkers_text = $row1[0];
                } else {
                    $jobqualifiedworkers_text = NULL;
                }
            }
        }

        $selected_jobweapon_sql = "select distinct jobweapon_name from job_weapons where jobweapon_active=1 and jobweapon_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobweapon_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobweapon);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobweapon_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobweapon_text);
                //
                if (!$row1 == NULL) {
                    $jobweapon_text = $row1[0];
                } else {
                    $jobweapon_text = NULL;
                }
            }
        }

        $selected_jobinterventiongroups_sql = "select distinct jobinterventiongroup_name from job_interventiongroup_types where jobinterventiongroup_active=1 and jobinterventiongroup_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobinterventiongroups_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobinterventiongroups);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobinterventiongroups_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobinterventiongroups_text);
                //
                if (!$row1 == NULL) {
                    $jobinterventiongroups_text = $row1[0];
                } else {
                    $jobinterventiongroups_text = NULL;
                }
            }
        }

        $selected_jobcriterianame1_sql = "select distinct jobcrit_name from job_criteria where jobcrit_active=1 and jobcrit_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobcriterianame1_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobcriterianame1);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobcriterianame1_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobcriterianame1_text);
                //
                if (!$row1 == NULL) {
                    $jobcriterianame1_text = $row1[0];
                } else {
                    $jobcriterianame1_text = NULL;
                }
            }
        }

        $selected_jobcriterianame2_sql = "select distinct jobcrit_name from job_criteria where jobcrit_active=1 and jobcrit_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobcriterianame2_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobcriterianame2);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobcriterianame2_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobcriterianame2_text);
                //
                if (!$row1 == NULL) {
                    $jobcriterianame2_text = $row1[0];
                } else {
                    $jobcriterianame2_text = NULL;
                }
            }
        }

        $selected_jobcriterianame3_sql = "select distinct jobcrit_name from job_criteria where jobcrit_active=1 and jobcrit_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobcriterianame3_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobcriterianame3);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobcriterianame3_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobcriterianame3_text);
                //
                if (!$row1 == NULL) {
                    $jobcriterianame3_text = $row1[0];
                } else {
                    $jobcriterianame3_text = NULL;
                }
            }
        }

        $selected_jobcriterianame4_sql = "select distinct jobcrit_name from job_criteria where jobcrit_active=1 and jobcrit_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobcriterianame4_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobcriterianame4);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobcriterianame4_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobcriterianame4_text);
                //
                if (!$row1 == NULL) {
                    $jobcriterianame4_text = $row1[0];
                } else {
                    $jobcriterianame4_text = NULL;
                }
            }
        }

        $selected_jobcriterianame5_sql = "select distinct jobcrit_name from job_criteria where jobcrit_active=1 and jobcrit_id = ?";
        if ($stmt = mysqli_prepare($link, $selected_jobcriterianame5_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $jobcriterianame5);

            if (mysqli_stmt_execute($stmt)) {
                $result_jobcriterianame5_text = mysqli_stmt_get_result($stmt);
                $row1 = mysqli_fetch_array($result_jobcriterianame5_text);
                //
                if (!$row1 == NULL) {
                    $jobcriterianame5_text = $row1[0];
                } else {
                    $jobcriterianame5_text = NULL;
                }
            }
        }
    }
}
//jeżeli nie było submita to sćiągnij z bazy dane i załaduj pola
else {
    // Check existence of id parameter before processing further
    if (isset($_SESSION['paramid'])) {
        // Get URL parameter
        $id = $_SESSION['paramid'];
        // Prepare a select statement

        $sql = "SELECT job_tnd_id, job_number, job_name, job_status, jobstat_name, job_resignation_reason, job_resignation_reason_details, jobresign_name, job_region, reg_name, job_department_id, dep_name, job_merchant_id, concat(merch_name, ' ', merch_surname) as merchant_name, job_sales_type, sal_type_name, job_deadline,
        job_current_operator, offnames_name, job_product_id, prod_name, job_estimated_value, job_units_number, job_property_type_id, jobproperty_name,
        job_indexation_type_id, jobindex_name, job_takeover23, job_tookover_workers, job_deposit, job_deposit_id, jobdeposit_name,
        job_deposit_valid_date, job_ZNWU_value, job_contract_type, jobcontract_name, job_subcontractor, jobsubcontractor_name, job_internal_areas, job_external_areas,
        job_qualified_workers, jobqualifiedworker_name, job_weapon, jobweapon_name, job_intervention_groups, jobinterventiongroup_name,
        job_criteria_id1, Crit1.jobcrit_name as jobcrit_name1, job_criteria_weight1, job_criteria_id2, Crit2.jobcrit_name as jobcrit_name2, job_criteria_weight2, job_criteria_id3, Crit3.jobcrit_name as jobcrit_name3, job_criteria_weight3, job_criteria_id4, Crit4.jobcrit_name as jobcrit_name4, job_criteria_weight4, job_criteria_id5, Crit5.jobcrit_name as jobcrit_name5, job_criteria_weight5,
        job_value_type_id, jobval_name, job_selection_date, job_contractor_budget, job_SAP_chance_number, job_contract_startdate, job_creation_date, job_modification_date, job_creation_work, job_modification_work, job_ZNWU_type, jobZNWU_name
        FROM tenders_jobs
        left join job_statuses on job_status=jobstat_id
        left join job_resignations on job_resignation_reason_details=jobresign_id
        left join regions on job_region=reg_id
        left join departments on job_department_id=dep_id
        left join merchants on job_merchant_id=merch_id
        left join sales_types on job_sales_type=sal_type_id
        left join offerors_names on job_current_operator=offnames_id
        left join products on job_product_id=prod_id
        left join job_properties on job_property_type_id=jobproperty_id
        left join job_indexation_types on job_indexation_type_id=jobindex_id
        left join job_deposit_types on job_deposit_id=jobdeposit_id
        left join job_contract_types on job_contract_type=jobcontract_id
        left join job_subcontractors on job_subcontractor=jobsubcontractor_id
        left join job_qualifiedworkers on job_qualified_workers=jobqualifiedworker_id
        left join job_weapons on job_weapon=jobweapon_id
        left join job_interventiongroup_types on job_intervention_groups=jobinterventiongroup_id
        left join job_criteria Crit1 on job_criteria_id1= Crit1.jobcrit_id
        left join job_criteria Crit2 on job_criteria_id2= Crit2.jobcrit_id
        left join job_criteria Crit3 on job_criteria_id3= Crit3.jobcrit_id
        left join job_criteria Crit4 on job_criteria_id4= Crit4.jobcrit_id
        left join job_criteria Crit5 on job_criteria_id5= Crit5.jobcrit_id
        left join job_value_types on job_value_type_id=jobval_type_id
        left join job_ZNWU_types on job_ZNWU_type=jobZNWU_id
        WHERE job_id=?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    //$tnd_number = $tnd_NIP = $tnd_contractor = $tnd_type = $tnd_segment = $tnd_announce_date = $tnd_submit_date =  "";
                    // Retrieve individual field value
                    $jobnumber = $row["job_number"];
                    $jobname = $row["job_name"];
                    $jobproduct = $row["job_product_id"];
                    $jobproduct_text = $row["prod_name"];
                    $jobpropertyname = $row["job_property_type_id"];
                    $jobpropertyname_text = $row["jobproperty_name"];
                    $jobsalestype = $row["job_sales_type"];
                    $jobsalestype_text = $row["sal_type_name"];
                    $jobdeadline = $row["job_deadline"];
                    $jobregion = $row["job_region"];
                    $jobregion_text = $row["reg_name"];
                    $jobdepartment = $row["job_department_id"];
                    $jobdepartment_text = $row["dep_name"];
                    $jobmerchant = $row["job_merchant_id"];
                    $jobmerchant_text = $row["merchant_name"];
                    $jobSAPnumber = $row["job_SAP_chance_number"];
                    $jobstatus = $row["job_status"];
                    $jobstatus_text = $row["jobstat_name"];
                    $jobresignationreason = $row["job_resignation_reason"];
                    $jobresignationreasondetails = $row["job_resignation_reason_details"];
                    $jobresignationreasondetails_text = $row["jobresign_name"];
                    $jobestimatedvalue = $row["job_estimated_value"];
                    $jobvaluetype = $row["job_value_type_id"];
                    $jobvaluetype_text = $row["jobval_name"];
                    $jobunitsnumber = $row["job_units_number"];
                    $jobcontractorbudget = $row["job_contractor_budget"];
                    $jobdeposit = $row["job_deposit"];
                    $jobdeposittype = $row["job_deposit_id"];
                    $jobdeposittype_text = $row["jobdeposit_name"];
                    $jobdepositvaliddate = $row["job_deposit_valid_date"];
                    $jobcurrentoperator = $row["job_current_operator"];
                    $jobcurrentoperator_text = $row["offnames_name"];
                    $jobindexname = $row["job_indexation_type_id"];
                    $jobindexname_text = $row["jobindex_name"];
                    $jobtakeover23 = $row["job_takeover23"];
                    $jobtookoverworkers = $row["job_tookover_workers"];
                    $jobZNWUtype = $row["job_ZNWU_type"];
                    $jobZNWUtype_text = $row["jobZNWU_name"];
                    $jobZNWUvalue = $row["job_ZNWU_value"];
                    $jobcontracttype = $row["job_contract_type"];
                    $jobcontracttype_text = $row["jobcontract_name"];
                    $jobsubcontractor = $row["job_subcontractor"];
                    $jobsubcontractor_text = $row["jobsubcontractor_name"];
                    $jobinternalareas = $row["job_internal_areas"];
                    $jobexternalareas = $row["job_external_areas"];
                    $jobqualifiedworkers = $row["job_qualified_workers"];
                    $jobqualifiedworkers_text = $row["jobqualifiedworker_name"];
                    $jobweapon = $row["job_weapon"];
                    $jobweapon_text = $row["jobweapon_name"];
                    $jobinterventiongroups = $row["job_intervention_groups"];
                    $jobinterventiongroups_text = $row["jobinterventiongroup_name"];
                    $jobcriterianame1 = $row["job_criteria_id1"];
                    $jobcriterianame1_text = $row["jobcrit_name1"];
                    $jobcriteriaweight1 = $row["job_criteria_weight1"];
                    $jobcriterianame2 = $row["job_criteria_id2"];
                    $jobcriterianame2_text = $row["jobcrit_name2"];
                    $jobcriteriaweight2 = $row["job_criteria_weight2"];
                    $jobcriterianame3 = $row["job_criteria_id3"];
                    $jobcriterianame3_text = $row["jobcrit_name3"];
                    $jobcriteriaweight3 = $row["job_criteria_weight3"];
                    $jobcriterianame4 = $row["job_criteria_id4"];
                    $jobcriterianame4_text = $row["jobcrit_name4"];
                    $jobcriteriaweight4 = $row["job_criteria_weight4"];
                    $jobcriterianame5 = $row["job_criteria_id5"];
                    $jobcriterianame5_text = $row["jobcrit_name5"];
                    $jobcriteriaweight5 = $row["job_criteria_weight5"];
                    
                } else {
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>



<!-- HTML!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Nowy przetarg</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 90%;
            margin: 0 auto;
            padding-top: 0px;
            padding-left: 50px;
        }
    </style>
</head>

<body>

    <div class="wrapper">
        <div class="container-fluid">
            <h2 class="mt-5">Edytuj zadanie przetargowe</h2>
            <p>Uzupełnij formularz i zatwierdź</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                
                <div class="form-row">
                    <!-- Select2 CSS -->
                    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

                    <!-- jQuery -->
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                    <!-- Select2 JS -->
                    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
                    <!--link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" -->

                    <!-- nadajemy tutaj styl obramowań list rozwijanych z możliwością wyszukiwania - na taki sam jak reszta z bootstrapa -->
                    <style>
                    .select2-container .select2-selection--single {
                        height: calc(1.5em + 0.75rem + 2px);
                        border: 1px solid #ced4da;
                    }
                    </style>

                    <!-- formujemy przyciski -->
                    <div class="form-group col-md-2">
                        <label for="jobnumber">Numer zadania*</label>
                        <input type="text" id='jobnumber' name='jobnumber' class="form-control <?php echo (!empty($jobnumber_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobnumber; ?>">
                        <span class="invalid-feedback"><?php echo $jobnumber_err; ?></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="jobname">Nazwa postępowania*</label>
                        <input type="text" id='jobname' name='jobname' class="form-control <?php echo (!empty($jobname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobname; ?>">
                        <span class="invalid-feedback"><?php echo $jobname_err; ?></span>
                    </div>

                    <!-- lista z możliwością wpisywania dla PRODUKTU -->
                    <?php

                    $jobproduct_sql = "SELECT prod_name, prod_id  FROM products where prod_active=1";

                    $jobproduct_result = mysqli_query($link, $jobproduct_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobproduct_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>

                    <div class="form-group col-md-3">
                        <label for="jobproduct">Produkt*</label>
                        <select id='jobproduct' name='jobproduct' class="form-control <?php echo (!empty($jobproduct_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobproduct; ?>> <?php echo $jobproduct_text; ?> </option>
                            <OPTION> <?php echo $options ?> </option>
                        </select>
                        <span class="invalid-feedback"><?php echo $jobproduct_err; ?></span>
                    </div>
                    
                    <!-- po co to ???????????????????????????????????????? -->
                    <br />
                    <div id='result'></div>

                    <script>
                        $(document).ready(function() {

                            // Initialize select2
                            $("#jobproduct").select2();

                            // Read selected option
                            $('#but_read').click(function() {
                            var username = $('#inputcnt option:selected').text();
                            var userid = $('#inputcnt').val();

                            $('#result').html("id : " + userid + ", name : " + username);

                            });
                        });
                    </script>
                    

                    <!-- lista dla RODZAJ OBIEKTU -->
                    <?php
                    $jobpropertyname_sql = "SELECT jobproperty_name, jobproperty_id  FROM job_properties where jobproperty_active=1";

                    $jobpropertyname_result = mysqli_query($link, $jobpropertyname_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobpropertyname_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>

                    <div class="form-group col-md-2">
                        <label for="jobpropertyname">Rodzaj obiektu*</label>
                        <select id='jobpropertyname' name='jobpropertyname' class="form-control <?php echo (!empty($jobpropertyname_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobpropertyname; ?>> <?php echo $jobpropertyname_text; ?> </option>
                            <OPTION> <?php echo $options ?> </option>    
                        </select>
                        <span class="invalid-feedback"><?php echo $jobpropertyname_err; ?></span>
                    </div>
                </div>

                <div class="form-row">
                    <!-- lista dla TYP SPRZEDAŻY -->
                    <?php
                    $jobsalestype_sql = "SELECT sal_type_name, sal_type_id  FROM sales_types where sal_type_active=1";

                    $jobsalestype_result = mysqli_query($link, $jobsalestype_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobsalestype_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>

                    <div class="form-group col-md-2">
                        <label for="jobsalestype">Typ sprzedaży*</label>
                        <select id='jobsalestype' name='jobsalestype' class="form-control <?php echo (!empty($jobsalestype_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobsalestype; ?>> <?php echo $jobsalestype_text; ?> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                        <span class="invalid-feedback"><?php echo $jobsalestype_err; ?></span>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="jobdeadline">Termin realizacji [mc]*</label>
                        <input type="text" id='jobdeadline' name='jobdeadline' class="form-control <?php echo (!empty($jobdeadline_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobdeadline; ?>">
                        <span class="invalid-feedback"><?php echo $jobdeadline_err; ?></span>
                    </div>

                    <?php
                    $jobregion_sql = "SELECT reg_name, reg_id  FROM regions where reg_active=1";

                    $jobregion_result = mysqli_query($link, $jobregion_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobregion_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-2">
                        <label for="jobregion">Region*</label>
                        <select id='jobregion' name='jobregion' class="form-control <?php echo (!empty($jobregion_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobregion; ?>> <?php echo $jobregion_text; ?> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                        <span class="invalid-feedback"><?php echo $jobregion_err; ?></span>
                    </div>

                    <?php
                    $jobdepartment_sql = "SELECT dep_name, dep_id  FROM departments where dep_active=1";

                    $jobdepartment_result = mysqli_query($link, $jobdepartment_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobdepartment_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-2">
                        <label for="jobdepartment">Oddział*</label>
                        <select id='jobdepartment' name='jobdepartment' class="form-control <?php echo (!empty($jobdepartment_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobdepartment; ?>> <?php echo $jobdepartment_text; ?> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                        <span class="invalid-feedback"><?php echo $jobdepartment_err; ?></span>
                    </div>
                    
                    <?php
                    $jobmerchant_sql = "SELECT concat(merch_name, ' ', merch_surname) as merchant_name, merch_id  FROM merchants where merch_active=1";

                    $jobmerchant_result = mysqli_query($link, $jobmerchant_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobmerchant_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-3">
                        <label for="jobmerchant">Handlowiec*</label>
                        <select id='jobmerchant' name='jobmerchant' class="form-control <?php echo (!empty($jobmerchant_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobmerchant; ?>> <?php echo $jobmerchant_text; ?> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                        <span class="invalid-feedback"><?php echo $jobmerchant_err; ?></span>
                    </div>

                    <!-- po co to ???????????????????????????????????????? -->
                    <br />
                    <div id='result'></div>

                    <script>
                        $(document).ready(function() {

                            // Initialize select2
                            $("#jobmerchant").select2();

                            // Read selected option
                            $('#but_read').click(function() {
                            var username = $('#inputcnt option:selected').text();
                            var userid = $('#inputcnt').val();

                            $('#result').html("id : " + userid + ", name : " + username);

                            });
                        });
                    </script>
                </div>

                <div class="form-row">

                    <div class="form-group col-md-2">
                        <label for="jobSAPnumber">Numer szansy*</label>
                        <input type="text" id='jobSAPnumber' name='jobSAPnumber' class="form-control <?php echo (!empty($jobSAPnumber_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobSAPnumber; ?>">
                        <span class="invalid-feedback"><?php echo $jobSAPnumber_err; ?></span>
                    </div>
                    
                    <?php
                    $jobstatus_sql = "SELECT jobstat_name, jobstat_id FROM job_statuses where jobstat_active=1";

                    $jobstatus_result = mysqli_query($link, $jobstatus_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobstatus_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-2">
                        <label for="jobstatus">Status*</label>
                        <select id='jobstatus' name='jobstatus' class="form-control <?php echo (!empty($jobstatus_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobstatus; ?>> <?php echo $jobstatus_text; ?> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                        <span class="invalid-feedback"><?php echo $jobstatus_err; ?></span>
                    </div>
                    
                    <div class="form-group col-md-3">
                        <label for="jobresignationreason">Powód rezygnacji</label>
                        <select id='jobresignationreason' name='jobresignationreason' class="form-control <?php // echo (!empty($jobresignationreason_err)) ? 'is-invalid' : ''; ?>">
                            <option selected="selected" hidden value=<?php echo $jobresignationreason; ?>> <?php echo $jobresignationreason; ?> </option>
                            <option value="Ekonomiczne"> ekonomiczne </option>
                            <option value="Formalne"> formalne </option>    
                        </select>
                    </div>

                    <?php
                    $jobresignationreasondetails_sql = "SELECT jobresign_name, jobresign_id FROM job_resignations where jobresign_active=1";

                    $jobresignationreasondetails_result = mysqli_query($link, $jobresignationreasondetails_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobresignationreasondetails_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-4">
                        <label for="jobresignationreasondetails">Powód rezygnacji - szczegółowo</label>
                        <select id='jobresignationreasondetails' name='jobresignationreasondetails' class="form-control <?php // echo (!empty($jobresignationreasondetails_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobresignationreasondetails; ?>> <?php echo $jobresignationreasondetails_text; ?> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                    </div>

                    <!-- po co to ???????????????????????????????????????? -->
                    <br />
                    <div id='result'></div>

                    <script>
                        $(document).ready(function() {

                            // Initialize select2
                            $("#jobresignationreasondetails").select2();

                            // Read selected option
                            $('#but_read').click(function() {
                            var username = $('#inputcnt option:selected').text();
                            var userid = $('#inputcnt').val();

                            $('#result').html("id : " + userid + ", name : " + username);

                            });
                        });
                    </script>

                </div>

                <div class="form-row">

                    <div class="form-group col-md-2">
                        <label for="jobestimatedvalue">Wartość szacunkowa [mc]*</label>
                        <input type="text" id='jobestimatedvalue' name='jobestimatedvalue' class="form-control <?php echo (!empty($jobestimatedvalue_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobestimatedvalue; ?>">
                        <span class="invalid-feedback"><?php echo $jobestimatedvalue_err; ?></span>
                    </div>

                    <?php
                    $jobvaluetype_sql = "SELECT jobval_name, jobval_type_id FROM job_value_types where jobval_active=1";

                    $jobvaluetype_result = mysqli_query($link, $jobvaluetype_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobvaluetype_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-3">
                        <label for="jobvaluetype">Typ wartości*</label>
                        <select id='jobvaluetype' name='jobvaluetype' class="form-control <?php  echo (!empty($jobvaluetype_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobvaluetype; ?>> <?php echo $jobvaluetype_text; ?> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                        <span class="invalid-feedback"><?php echo $jobvaluetype_err; ?></span>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="jobunitsnumber">Liczba jednostek [mc]</label>
                        <input type="text" id='jobunitsnumber' name='jobunitsnumber' class="form-control <?php // echo (!empty($jobunitsnumber_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobunitsnumber; ?>">
                    </div>

                    <div class="form-group col-md-2">
                        <label for="jobcontractorbudget">Budżet zamawiającego</label>
                        <input type="text" id='jobcontractorbudget' name='jobcontractorbudget' class="form-control <?php // echo (!empty($jobcontractorbudget_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobcontractorbudget; ?>">
                    </div>
                </div>

                <div class="form-row">

                    <div class="form-group col-md-2">
                        <label for="jobdeposit">Wadium - kwota</label>
                        <input type="text" id='jobdeposit' name='jobdeposit' class="form-control <?php // echo (!empty($jobdeposit_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobdeposit; ?>">
                    </div>
                    
                    <?php
                    $jobdeposittype_sql = "SELECT jobdeposit_name, jobdeposit_id FROM job_deposit_types where jobdeposit_active=1";

                    $jobdeposittype_result = mysqli_query($link, $jobdeposittype_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobdeposittype_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-3">
                        <label for="jobdeposittype">Wadium - rodzaj</label>
                        <select id='jobdeposittype' name='jobdeposittype' class="form-control <?php // echo (!empty($jobdeposittype_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobdeposittype; ?>> <?php echo $jobdeposittype_text; ?> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                    </div>
                    
                    <div class="form-group col-md-2">
                        <label for="jobdepositvaliddate">Wadium - ważność</label>
                        <input type="date" name="jobdepositvaliddate" min="2022-01-01" class="form-control <?php // echo (!empty($jobdepositvaliddate_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobdepositvaliddate; ?>">
                        <span class="invalid-feedback"><?php echo $jobdepositvaliddate_err; ?></span>
                    </div>
                </div>

                <div class="form-row">

                    <?php
                    $jobcurrentoperator_sql = "SELECT offnames_name, offnames_id FROM offerors_names where offnames_active=1";

                    $jobcurrentoperator_result = mysqli_query($link, $jobcurrentoperator_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobcurrentoperator_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-4">
                        <label for="jobcurrentoperator">Aktualny wykonawca</label>
                        <select id='jobcurrentoperator' name='jobcurrentoperator' class="form-control <?php // echo (!empty($jobcurrentoperator_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobcurrentoperator; ?>> <?php echo $jobcurrentoperator_text; ?> </option>
                            <OPTION> <?php echo $options ?> </option>
                        </select>
                    </div>

                    <!-- po co to ???????????????????????????????????????? -->
                    <br />
                    <div id='result'></div>

                    <script>
                        $(document).ready(function() {

                            // Initialize select2
                            $("#jobcurrentoperator").select2();

                            // Read selected option
                            $('#but_read').click(function() {
                            var username = $('#inputcnt option:selected').text();
                            var userid = $('#inputcnt').val();

                            $('#result').html("id : " + userid + ", name : " + username);

                            });
                        });
                    </script>

                    <?php
                    $jobindexname_sql = "SELECT jobindex_name, jobindex_id FROM job_indexation_types where jobindex_active=1";

                    $jobindexname_result = mysqli_query($link, $jobindexname_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobindexname_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-2">
                        <label for="jobindexname">Waloryzacja</label>
                        <select id='jobindexname' name='jobindexname' class="form-control <?php // echo (!empty($jobindexname_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobindexname; ?>> <?php echo $jobindexname_text; ?> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="jobtakeover23">Przejęcie 23</label>
                        <select id='jobtakeover23' name='jobtakeover23' class="form-control <?php // echo (!empty($jobtakeover23_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobtakeover23; ?>> <?php echo $jobtakeover23; ?> </option>
                            <option value="tak"> tak </option>
                            <option value="nie"> nie </option>    
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="jobtookoverworkers">Liczba pracowników przejmowanych</label>
                        <input type="text" id='jobtookoverworkers' name='jobtookoverworkers' class="form-control <?php // echo (!empty($jobtookoverworkers_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobtookoverworkers; ?>">
                    </div>
                </div>
                
                <div class="form-row">
                    
                    <?php
                    $jobZNWUtype_sql = "SELECT jobZNWU_name, jobZNWU_id FROM job_ZNWU_types where jobZNWU_active=1";

                    $jobZNWUtype_result = mysqli_query($link, $jobZNWUtype_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobZNWUtype_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-3">
                        <label for="jobZNWUtype">Rodzaj ZNWU</label>
                        <select id='jobZNWUtype' name='jobZNWUtype' class="form-control <?php // echo (!empty($jobZNWUtype_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobZNWUtype; ?>> <?php echo $jobZNWUtype_text; ?> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="jobZNWUvalue">Wartość ZNWU [%]</label>
                        <input type="text" id='jobZNWUvalue' name='jobZNWUvalue' class="form-control <?php // echo (!empty($jobZNWUvalue_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobZNWUvalue; ?>">
                    </div>
                    
                    <?php
                    $jobcontracttype_sql = "SELECT jobcontract_name, jobcontract_id FROM job_contract_types where jobcontract_active=1";

                    $jobcontracttype_result = mysqli_query($link, $jobcontracttype_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobcontracttype_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-3">
                        <label for="jobcontracttype">Rodzaj umowy</label>
                        <select id='jobcontracttype' name='jobcontracttype' class="form-control <?php // echo (!empty($jobcontracttype_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobcontracttype; ?>> <?php echo $jobcontracttype_text; ?> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                    </div>
                    
                    <?php
                    $jobsubcontractor_sql = "SELECT jobsubcontractor_name, jobsubcontractor_id FROM job_subcontractors where jobsubcontractor_active=1";

                    $jobsubcontractor_result = mysqli_query($link, $jobsubcontractor_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobsubcontractor_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-3">
                        <label for="jobsubcontractor">Podwykonawstwo</label>
                        <select id='jobsubcontractor' name='jobsubcontractor' class="form-control <?php // echo (!empty($jobsubcontractor_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobsubcontractor; ?>> <?php echo $jobsubcontractor_text; ?> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                    </div>
                </div>

                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label for="jobinternalareas">Tereny wewnętrzne</label>
                        <input type="text" id='jobinternalareas' name='jobinternalareas' class="form-control <?php // echo (!empty($jobinternalareas_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobinternalareas; ?>">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="jobexternalareas">Tereny zewnętrzne</label>
                        <input type="text" id='jobexternalareas' name='jobexternalareas' class="form-control <?php // echo (!empty($jobexternalareas_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobexternalareas; ?>">
                    </div>
                </div>

                <div class="form-row">
                    
                    <?php
                    $jobqualifiedworkers_sql = "SELECT jobqualifiedworker_name, jobqualifiedworker_id FROM job_qualifiedworkers where jobqualifiedworker_active=1";

                    $jobqualifiedworkers_result = mysqli_query($link, $jobqualifiedworkers_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobqualifiedworkers_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-3">
                        <label for="jobqualifiedworkers">Pracownicy kwalifikowani</label>
                        <select id='jobqualifiedworkers' name='jobqualifiedworkers' class="form-control <?php // echo (!empty($jobqualifiedworkers_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobqualifiedworkers; ?>> <?php echo $jobqualifiedworkers_text; ?> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                    </div>
                    
                    <?php
                    $jobweapon_sql = "SELECT jobweapon_name, jobweapon_id FROM job_weapons where jobweapon_active=1";

                    $jobweapon_result = mysqli_query($link, $jobweapon_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobweapon_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-2">
                        <label for="jobweapon">Broń</label>
                        <select id='jobweapon' name='jobweapon' class="form-control <?php // echo (!empty($jobweapon_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobweapon; ?>> <?php echo $jobweapon_text; ?> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                    </div>
                    
                    <?php
                    $jobinterventiongroups_sql = "SELECT jobinterventiongroup_name, jobinterventiongroup_id FROM job_interventiongroup_types where jobinterventiongroup_active=1";

                    $jobinterventiongroups_result = mysqli_query($link, $jobinterventiongroups_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobinterventiongroups_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-3">
                        <label for="jobinterventiongroups">Grupy interwencyjne</label>
                        <select id='jobinterventiongroups' name='jobinterventiongroups' class="form-control <?php // echo (!empty($jobinterventiongroups_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobinterventiongroups; ?>> <?php echo $jobinterventiongroups_text; ?> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    
                    <?php
                    // tutaj zadeklarujemy tabelę do zaciągania dla wszystkich 5 pól z wyborem kryteriów
                    $jobcriterianame_sql = "SELECT jobcrit_name, jobcrit_id FROM job_criteria where jobcrit_active=1";

                    $jobcriterianame_result = mysqli_query($link, $jobcriterianame_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobcriterianame_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <!-- tutaj zaczynamy ustawiać pola -->
                    <div class="form-group col-md-3">
                        <label for="jobcriterianame1">Kryterium wyboru 1 - opis</label>
                        <select id='jobcriterianame1' name='jobcriterianame1' class="form-control <?php // echo (!empty($jobcriterianame1_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobcriterianame1; ?>> <?php echo $jobcriterianame1_text; ?> </option>
                            <OPTION> <?php echo $options ?> </option>
                        </select>
                    </div>

                    <!-- po co to ???????????????????????????????????????? -->
                    <br />
                    <div id='result'></div>

                    <script>
                        $(document).ready(function() {

                            // Initialize select2
                            $("#jobcriterianame1").select2();

                            // Read selected option
                            $('#but_read').click(function() {
                            var username = $('#inputcnt option:selected').text();
                            var userid = $('#inputcnt').val();

                            $('#result').html("id : " + userid + ", name : " + username);

                            });
                        });
                    </script>

                    <div class="form-group col-md-2">
                        <label for="jobcriteriaweight1">Waga kryterium 1 [%]</label>
                        <input type="text" id='jobcriteriaweight1' name='jobcriteriaweight1' class="form-control <?php // echo (!empty($jobcriteriaweight1_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobcriteriaweight1; ?>">
                    </div>

                    
                    <div class="form-group col-md-3">
                        <label for="jobcriterianame2">Kryterium wyboru 2 - opis</label>
                        <select id='jobcriterianame2' name='jobcriterianame2' class="form-control <?php // echo (!empty($jobcriterianame2_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobcriterianame2; ?>> <?php echo $jobcriterianame2_text; ?> </option>
                            <OPTION> <?php echo $options ?> </option>
                        </select>
                    </div>

                    <!-- po co to ???????????????????????????????????????? -->
                    <br />
                    <div id='result'></div>

                    <script>
                        $(document).ready(function() {

                            // Initialize select2
                            $("#jobcriterianame2").select2();

                            // Read selected option
                            $('#but_read').click(function() {
                            var username = $('#inputcnt option:selected').text();
                            var userid = $('#inputcnt').val();

                            $('#result').html("id : " + userid + ", name : " + username);

                            });
                        });
                    </script>

                    <div class="form-group col-md-2">
                        <label for="jobcriteriaweight2">Waga kryterium 2 [%]</label>
                        <input type="text" id='jobcriteriaweight2' name='jobcriteriaweight2' class="form-control <?php // echo (!empty($jobcriteriaweight2_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobcriteriaweight2; ?>">
                    </div>
                </div>

                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label for="jobcriterianame3">Kryterium wyboru 3 - opis</label>
                        <select id='jobcriterianame3' name='jobcriterianame3' class="form-control <?php // echo (!empty($jobcriterianame3_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobcriterianame3; ?>> <?php echo $jobcriterianame3_text; ?> </option>
                            <OPTION> <?php echo $options ?> </option>
                        </select>
                    </div>

                    <!-- po co to ???????????????????????????????????????? -->
                    <br />
                    <div id='result'></div>

                    <script>
                        $(document).ready(function() {

                            // Initialize select2
                            $("#jobcriterianame3").select2();

                            // Read selected option
                            $('#but_read').click(function() {
                            var username = $('#inputcnt option:selected').text();
                            var userid = $('#inputcnt').val();

                            $('#result').html("id : " + userid + ", name : " + username);

                            });
                        });
                    </script>

                    <div class="form-group col-md-2">
                        <label for="jobcriteriaweight3">Waga kryterium 3 [%]</label>
                        <input type="text" id='jobcriteriaweight3' name='jobcriteriaweight3' class="form-control <?php // echo (!empty($jobcriteriaweight3_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobcriteriaweight3; ?>">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="jobcriterianame4">Kryterium wyboru 4 - opis</label>
                        <select id='jobcriterianame4' name='jobcriterianame4' class="form-control <?php // echo (!empty($jobcriterianame4_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobcriterianame4; ?>> <?php echo $jobcriterianame4_text; ?> </option>
                            <OPTION> <?php echo $options ?> </option>
                        </select>
                    </div>

                    <!-- po co to ???????????????????????????????????????? -->
                    <br />
                    <div id='result'></div>

                    <script>
                        $(document).ready(function() {

                            // Initialize select2
                            $("#jobcriterianame4").select2();

                            // Read selected option
                            $('#but_read').click(function() {
                            var username = $('#inputcnt option:selected').text();
                            var userid = $('#inputcnt').val();

                            $('#result').html("id : " + userid + ", name : " + username);

                            });
                        });
                    </script>

                    <div class="form-group col-md-2">
                        <label for="jobcriteriaweight4">Waga kryterium 4 [%]</label>
                        <input type="text" id='jobcriteriaweight4' name='jobcriteriaweight4' class="form-control <?php // echo (!empty($jobcriteriaweight4_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobcriteriaweight4; ?>">
                    </div>
                </div>

                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label for="jobcriterianame5">Kryterium wyboru 5 - opis</label>
                        <select id='jobcriterianame5' name='jobcriterianame5' class="form-control <?php // echo (!empty($jobcriterianame5_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobcriterianame5; ?>> <?php echo $jobcriterianame5_text; ?> </option>
                            <OPTION> <?php echo $options ?> </option>
                        </select>
                    </div>

                    <!-- po co to ???????????????????????????????????????? -->
                    <br />
                    <div id='result'></div>

                    <script>
                        $(document).ready(function() {

                            // Initialize select2
                            $("#jobcriterianame5").select2();

                            // Read selected option
                            $('#but_read').click(function() {
                            var username = $('#inputcnt option:selected').text();
                            var userid = $('#inputcnt').val();

                            $('#result').html("id : " + userid + ", name : " + username);

                            });
                        });
                    </script>

                    <div class="form-group col-md-2">
                        <label for="jobcriteriaweight5">Waga kryterium 5 [%]</label>
                        <input type="text" id='jobcriteriaweight5' name='jobcriteriaweight5' class="form-control <?php // echo (!empty($jobcriteriaweight5_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobcriteriaweight5; ?>">
                    </div>
                </div>

                <!-- nie wiem co to dokładnie, ale chyba potrzebne-->
            

                <!-- guziki dodania przetargu i powrotu -->
                <input type="submit" class="btn btn-primary" value="Zmodyfikuj zadanie przetargowe">
                <input type="hidden" id="paramid" name="paramid" value=<?php echo $_SESSION['paramid'] ?>>
                <a href="tasks.php?tnd_id=<?php echo $_SESSION['tndid'] ?>" class="btn btn-secondary ml-2">Powrót</a>
                
            </form>
        </div> 
    </div>

</body>



<?php


// Check existence of id parameter before processing further
if (isset($_SESSION['paramid']) && !empty(trim($_SESSION['paramid']))) {
    // Get URL parameter
    $id =  $_SESSION['paramid'];
    // Prepare a select statement
    $sql = "SELECT * FROM tenders_jobs t WHERE job_id = ?";
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
                $tnd_modification_date = $row1["job_modification_date"];
                $tnd_creation_date = $row1["job_creation_date"];
                $tnd_modification_emp = $row1["job_modification_work"];
                $tnd_creation_emp = $row1["job_creation_work"];
            } else {

                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    mysqli_stmt_close($stmt1);

    // Close connection

}
?>

<br>
<style>
    p {
        text-indent: 130px;
    }

    h1 {
        font-size: 10px;
    }
</style>

<h1>
    <p>
        <?php echo "utworzono: " . $tnd_creation_date . " przez " . $tnd_creation_emp ?> <br>
    <p>
        <?php echo "ostatnio zmodyfikowano: " . $tnd_modification_date . " przez " . $tnd_modification_emp; ?>


        <?php
        mysqli_close($link);



        ?>

</html>


</html>

