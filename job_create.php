<?php session_start();

if (isset($_GET["tnd_number"])) {
    $paramid = trim($_GET["tnd_number"]);
    $_SESSION['paramid'] = $paramid;
};

if (isset($_SESSION["logid"])) {
    $logid = $_SESSION['logid'];
} else {
    header("location:login.php");
};

// Include config file
require_once "config.php";


// Define variables and initialize with empty values
$jobnumber = $jobname = $jobproduct = $jobpropertyname = $jobsalestype = $jobdeadline = $jobregion = $jobdepartment = $jobmerchant = $jobSAPnumber = $jobstatus = $jobresignationreason = $jobresignationreasondetails = $jobestimatedvalue = $jobvaluetype = $jobunitsnumber = $jobcontractorbudget = $jobdeposit = $jobdeposittype = $jobdepositvaliddate = $jobcurrentoperator = $jobindexname = $jobtakeover23 = $jobtookoverworkers = $jobZNWUtype = $jobZNWUvalue = $jobcontracttype = $jobsubcontractor = $jobinternalareas = $jobexternalareas = $jobqualifiedworkers = $jobweapon = $jobinterventiongroups = $jobcriterianame1 = $jobcriteriaweight1 = $jobcriterianame2 = $jobcriteriaweight2 = $jobcriterianame3 = $jobcriteriaweight3 = $jobcriterianame4 = $jobcriteriaweight4 = $jobcriterianame5 = $jobcriteriaweight5 = "";
$jobnumber_err = $jobname_err = $jobproduct_err = $jobpropertyname_err = $jobsalestype_err = $jobdeadline_err = $jobregion_err = $jobdepartment_err = $jobmerchant_err = $jobSAPnumber_err = $jobstatus_err = $jobresignationreason_err = $jobresignationreasondetails_err = $jobestimatedvalue_err = $jobvaluetype_err = $jobunitsnumber_err = $jobcontractorbudget_err = $jobdeposit_err = $jobdeposittype_err = $jobdepositvaliddate_err = $jobcurrentoperator_err = $jobindexname_err = $jobtakeover23_err = $jobtookoverworkers_err = $jobZNWUtype_err = $jobZNWUvalue_err = $jobcontracttype_err = $jobsubcontractor_err = $jobinternalareas_err = $jobexternalareas_err = $jobqualifiedworkers_err = $jobweapon_err = $jobinterventiongroups_err = $jobcriterianame1_err = $jobcriteriaweight1_err = $jobcriterianame2_err = $jobcriteriaweight2_err = $jobcriterianame3_err = $jobcriteriaweight3_err = $jobcriterianame4_err = $jobcriteriaweight4_err = $jobcriterianame5_err = $jobcriteriaweight5_err = "";


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
        $jobmerchant_err = "Wybierz typ sprzedaży";
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


    // TUTAJ MAMY WRZUCANIE TEGO DO BAZY!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    $input_off_creation_worker =  $logid;


    if (empty($jobnumber_err) && empty($jobname_err)  && empty($jobproduct_err) && empty($jobpropertyname_err) && empty($jobsalestype_err) && empty($jobdeadline_err) && empty($jobregion_err) && empty($jobdepartment_err) && empty($jobmerchant_err) && empty($jobSAPnumber_err) && empty($jobstatus_err)) {
    // Prepare an insert statement

        //$job_tnd_id = trim($_POST["paramid"]);
        $job_tnd_id = 3;

        $sql = "INSERT INTO tenders_test.tenders_jobs (job_tnd_id, job_number, job_name, job_product_id, job_property_type_id, job_sales_type, job_deadline ,job_region, job_department_id, job_merchant_id, job_SAP_chance_number, job_status, job_resignation_reason, job_resignation_reason_details, job_estimated_value, job_value_type_id, job_units_number, job_contractor_budget, job_deposit, job_deposit_id, job_deposit_valid_date, job_current_operator, job_indexation_type_id, job_takeover23, job_tookover_workers, job_ZNWU_type, job_ZNWU_value, job_contract_type, job_subcontractor, job_internal_areas, job_external_areas, job_qualified_workers, job_weapon, job_intervention_groups, job_criteria_id1, job_criteria_weight1, job_criteria_id2, job_criteria_weight2, job_criteria_id3, job_criteria_weight3, job_criteria_id4, job_criteria_weight4, job_criteria_id5, job_criteria_weight5) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iisiiiiiiiiisididddisiisiidiiddiiiididididid", $param_job_tnd_id, $param_jobnumber, $param_jobname, $param_jobproduct, $param_jobpropertyname, $param_jobsalestype, $param_jobdeadline, $param_jobregion, $param_jobdepartment, $param_jobmerchant, $param_jobSAPnumber, $param_jobstatus, $param_jobresignationreason, $param_jobresignationreasondetails, $param_jobestimatedvalue, $param_jobvaluetype, $param_jobunitsnumber, $param_jobcontractorbudget, $param_jobdeposit, $param_jobdeposittype, $param_jobdepositvaliddate, $param_jobcurrentoperator, $param_jobindexname, $param_jobtakeover23, $param_jobtookoverworkers, $param_jobZNWUtype, $param_jobZNWUvalue, $param_jobcontracttype, $param_jobsubcontractor, $param_jobinternalareas, $param_jobexternalareas, $param_jobqualifiedworkers, $param_jobweapon, $param_jobinterventiongroups, $param_jobcriterianame1, $param_jobcriteriaweight1, $param_jobcriterianame2, $param_jobcriteriaweight2, $param_jobcriterianame3, $param_jobcriteriaweight3, $param_jobcriterianame4, $param_jobcriteriaweight4, $param_jobcriterianame5, $param_jobcriteriaweight5);
               
            $param_job_tnd_id = $job_tnd_id;
            $param_jobnumber = $jobnumber ;
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
            
            

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                //echo "Dodano nowy przetarg";
                header("location: job_ok.php");
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
            <h2 class="mt-5">Dodaj zadanie przetargowe</h2>
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
                        <label for="jobnumber">Numer zadania</label>
                        <input type="text" id='jobnumber' name='jobnumber' class="form-control <?php echo (!empty($jobnumber_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobnumber; ?>">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="jobname">Nazwa postępowania</label>
                        <input type="text" id='jobname' name='jobname' class="form-control <?php echo (!empty($jobname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobname; ?>">
                    </div>

                    <!-- lista z możliwością wpisywania dla PRODUKTU -->
                    <?php

                    $jobproduct_sql = "SELECT prod_name, prod_id  FROM tenders_test.products where prod_active=1";

                    $jobproduct_result = mysqli_query($link, $jobproduct_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobproduct_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>

                    

                    <div class="form-group col-md-3">
                        <label for="jobproduct">Produkt</label>
                        <select id='jobproduct' name='jobproduct' class="form-control <?php echo (!empty($jobproduct_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobproduct; ?>> </option>
                            <OPTION> <?php echo $options ?> </option>
                        </select>
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
                    $jobpropertyname_sql = "SELECT jobproperty_name, jobproperty_id  FROM tenders_test.job_properties where jobproperty_active=1";

                    $jobpropertyname_result = mysqli_query($link, $jobpropertyname_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobpropertyname_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>

                    <div class="form-group col-md-2">
                        <label for="jobpropertyname">Rodzaj obiektu</label>
                        <select id='jobpropertyname' name='jobpropertyname' class="form-control <?php echo (!empty($jobpropertyname_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobpropertyname; ?>> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <!-- lista dla TYP SPRZEDAŻY -->
                    <?php
                    $jobsalestype_sql = "SELECT sal_type_name, sal_type_id  FROM tenders_test.sales_types where sal_type_active=1";

                    $jobsalestype_result = mysqli_query($link, $jobsalestype_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobsalestype_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>

                    <div class="form-group col-md-2">
                        <label for="jobsalestype">Typ sprzedaży</label>
                        <select id='jobsalestype' name='jobsalestype' class="form-control <?php echo (!empty($jobsalestype_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobsalestype; ?>> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="jobdeadline">Termin realizacji [mc]</label>
                        <input type="text" id='jobdeadline' name='jobdeadline' class="form-control <?php echo (!empty($jobdeadline_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobdeadline; ?>">
                    </div>

                    <?php
                    $jobregion_sql = "SELECT reg_name, reg_id  FROM tenders_test.regions where reg_active=1";

                    $jobregion_result = mysqli_query($link, $jobregion_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobregion_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-2">
                        <label for="jobregion">Region</label>
                        <select id='jobregion' name='jobregion' class="form-control <?php echo (!empty($jobregion_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobregion; ?>> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                    </div>

                    <?php
                    $jobdepartment_sql = "SELECT dep_name, dep_id  FROM tenders_test.departments where dep_active=1";

                    $jobdepartment_result = mysqli_query($link, $jobdepartment_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobdepartment_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-2">
                        <label for="jobdepartment">Oddział</label>
                        <select id='jobdepartment' name='jobdepartment' class="form-control <?php echo (!empty($jobdepartment_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobdepartment; ?>> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                    </div>
                    
                    <?php
                    $jobmerchant_sql = "SELECT concat(merch_name, ' ', merch_surname) as merchant_name, merch_id  FROM tenders_test.merchants where merch_active=1";

                    $jobmerchant_result = mysqli_query($link, $jobmerchant_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobmerchant_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-3">
                        <label for="jobmerchant">Handlowiec</label>
                        <select id='jobmerchant' name='jobmerchant' class="form-control <?php echo (!empty($jobmerchant_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobmerchant; ?>> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
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
                        <label for="jobSAPnumber">Numer szansy</label>
                        <input type="text" id='jobSAPnumber' name='jobSAPnumber' class="form-control <?php echo (!empty($jobSAPnumber_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobSAPnumber; ?>">
                    </div>
                    
                    <?php
                    $jobstatus_sql = "SELECT jobstat_name, jobstat_id FROM tenders_test.job_statuses where jobstat_active=1";

                    $jobstatus_result = mysqli_query($link, $jobstatus_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobstatus_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-2">
                        <label for="jobstatus">Status</label>
                        <select id='jobstatus' name='jobstatus' class="form-control <?php echo (!empty($jobstatus_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobstatus; ?>> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                    </div>
                    
                    <div class="form-group col-md-3">
                        <label for="jobresignationreason">Powód rezygnacji</label>
                        <select id='jobresignationreason' name='jobresignationreason' class="form-control <?php // echo (!empty($jobresignationreason_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" value=<?php echo $jobresignationreason; ?>> </option>
                            <option value="Ekonomiczne"> ekonomiczne </option>
                            <option value="Formalne"> formalne </option>    
                        </select>
                    </div>

                    <?php
                    $jobresignationreasondetails_sql = "SELECT jobresign_name, jobresign_id FROM tenders_test.job_resignations where jobresign_active=1";

                    $jobresignationreasondetails_result = mysqli_query($link, $jobresignationreasondetails_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobresignationreasondetails_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-4">
                        <label for="jobresignationreasondetails">Powód rezygnacji - szczegółowo</label>
                        <select id='jobresignationreasondetails' name='jobresignationreasondetails' class="form-control <?php // echo (!empty($jobresignationreasondetails_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobresignationreasondetails; ?>> </option>
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
                        <label for="jobestimatedvalue">Wartość szacunkowa [mc]</label>
                        <input type="text" id='jobestimatedvalue' name='jobestimatedvalue' class="form-control <?php echo (!empty($jobestimatedvalue_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobestimatedvalue; ?>">
                    </div>

                    <?php
                    $jobvaluetype_sql = "SELECT jobval_name, jobval_type_id FROM tenders_test.job_value_types where jobval_active=1";

                    $jobvaluetype_result = mysqli_query($link, $jobvaluetype_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobvaluetype_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-3">
                        <label for="jobvaluetype">Typ wartości</label>
                        <select id='jobvaluetype' name='jobvaluetype' class="form-control <?php  echo (!empty($jobvaluetype_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobvaluetype; ?>> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
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
                    $jobdeposittype_sql = "SELECT jobdeposit_name, jobdeposit_id FROM tenders_test.job_deposit_types where jobdeposit_active=1";

                    $jobdeposittype_result = mysqli_query($link, $jobdeposittype_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobdeposittype_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-3">
                        <label for="jobdeposittype">Wadium - rodzaj</label>
                        <select id='jobdeposittype' name='jobdeposittype' class="form-control <?php // echo (!empty($jobdeposittype_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobdeposittype; ?>> </option>
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
                    $jobcurrentoperator_sql = "SELECT offnames_name, offnames_id FROM tenders_test.offerors_names where offnames_active=1";

                    $jobcurrentoperator_result = mysqli_query($link, $jobcurrentoperator_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobcurrentoperator_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-4">
                        <label for="jobcurrentoperator">Aktualny wykonawca</label>
                        <select id='jobcurrentoperator' name='jobcurrentoperator' class="form-control <?php // echo (!empty($jobcurrentoperator_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobcurrentoperator; ?>> </option>
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
                    $jobindexname_sql = "SELECT jobindex_name, jobindex_id FROM tenders_test.job_indexation_types where jobindex_active=1";

                    $jobindexname_result = mysqli_query($link, $jobindexname_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobindexname_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-2">
                        <label for="jobindexname">Waloryzacja</label>
                        <select id='jobindexname' name='jobindexname' class="form-control <?php // echo (!empty($jobindexname_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobindexname; ?>> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="jobtakeover23">Przejęcie 23</label>
                        <select id='jobtakeover23' name='jobtakeover23' class="form-control <?php // echo (!empty($jobtakeover23_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" value=<?php echo $jobtakeover23; ?>> </option>
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
                    $jobZNWUtype_sql = "SELECT jobZNWU_name, jobZNWU_id FROM tenders_test.job_ZNWU_types where jobZNWU_active=1";

                    $jobZNWUtype_result = mysqli_query($link, $jobZNWUtype_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobZNWUtype_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-3">
                        <label for="jobZNWUtype">Rodzaj ZNWU</label>
                        <select id='jobZNWUtype' name='jobZNWUtype' class="form-control <?php // echo (!empty($jobZNWUtype_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobZNWUtype; ?>> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="jobZNWUvalue">Wartość ZNWU [%]</label>
                        <input type="text" id='jobZNWUvalue' name='jobZNWUvalue' class="form-control <?php // echo (!empty($jobZNWUvalue_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobZNWUvalue; ?>">
                    </div>
                    
                    <?php
                    $jobcontracttype_sql = "SELECT jobcontract_name, jobcontract_id FROM tenders_test.job_contract_types where jobcontract_active=1";

                    $jobcontracttype_result = mysqli_query($link, $jobcontracttype_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobcontracttype_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-3">
                        <label for="jobcontracttype">Rodzaj umowy</label>
                        <select id='jobcontracttype' name='jobcontracttype' class="form-control <?php // echo (!empty($jobcontracttype_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobcontracttype; ?>> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                    </div>
                    
                    <?php
                    $jobsubcontractor_sql = "SELECT jobsubcontractor_name, jobsubcontractor_id FROM tenders_test.job_subcontractors where jobsubcontractor_active=1";

                    $jobsubcontractor_result = mysqli_query($link, $jobsubcontractor_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobsubcontractor_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-3">
                        <label for="jobsubcontractor">Podwykonawstwo</label>
                        <select id='jobsubcontractor' name='jobsubcontractor' class="form-control <?php // echo (!empty($jobsubcontractor_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobsubcontractor; ?>> </option>
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
                    $jobqualifiedworkers_sql = "SELECT jobqualifiedworker_name, jobqualifiedworker_id FROM tenders_test.job_qualifiedworkers where jobqualifiedworker_active=1";

                    $jobqualifiedworkers_result = mysqli_query($link, $jobqualifiedworkers_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobqualifiedworkers_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-3">
                        <label for="jobqualifiedworkers">Pracownicy kwalifikowani</label>
                        <select id='jobqualifiedworkers' name='jobqualifiedworkers' class="form-control <?php // echo (!empty($jobqualifiedworkers_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobqualifiedworkers; ?>> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                    </div>
                    
                    <?php
                    $jobweapon_sql = "SELECT jobweapon_name, jobweapon_id FROM tenders_test.job_weapons where jobweapon_active=1";

                    $jobweapon_result = mysqli_query($link, $jobweapon_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobweapon_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-2">
                        <label for="jobweapon">Broń</label>
                        <select id='jobweapon' name='jobweapon' class="form-control <?php // echo (!empty($jobweapon_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobweapon; ?>> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                    </div>
                    
                    <?php
                    $jobinterventiongroups_sql = "SELECT jobinterventiongroup_name, jobinterventiongroup_id FROM tenders_test.job_interventiongroup_types where jobinterventiongroup_active=1";

                    $jobinterventiongroups_result = mysqli_query($link, $jobinterventiongroups_sql);

                    $options = "";
                    
                    while ($row2 = mysqli_fetch_array($jobinterventiongroups_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>
                    <div class="form-group col-md-3">
                        <label for="jobinterventiongroups">Grupy interwencyjne</label>
                        <select id='jobinterventiongroups' name='jobinterventiongroups' class="form-control <?php // echo (!empty($jobinterventiongroups_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $jobinterventiongroups; ?>> </option>
                            <OPTION> <?php echo $options ?> </option>        
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    
                    <?php
                    // tutaj zadeklarujemy tabelę do zaciągania dla wszystkich 5 pól z wyborem kryteriów
                    $jobcriterianame_sql = "SELECT jobcrit_name, jobcrit_id FROM tenders_test.job_criteria where jobcrit_active=1";

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
                            <option selected="selected" hidden value=<?php echo $jobcriterianame1; ?>> </option>
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
                            <option selected="selected" hidden value=<?php echo $jobcriterianame2; ?>> </option>
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
                            <option selected="selected" hidden value=<?php echo $jobcriterianame3; ?>> </option>
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
                            <option selected="selected" hidden value=<?php echo $jobcriterianame4; ?>> </option>
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
                            <option selected="selected" hidden value=<?php echo $jobcriterianame5; ?>> </option>
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
                <?php mysqli_close($link); ?>

                <!-- guziki dodania przetargu i powrotu -->
                <input type="submit" class="btn btn-primary" value="Dodaj zadanie przetargowe">
                <input type="hidden" id="paramid" name="paramid" value=<?php echo $_SESSION['paramid'] ?>>
                <a href="tasks.php?tnd_number=<?php echo $_SESSION['paramid'] ?>" class="btn btn-secondary ml-2">Powrót</a>
                
            </form>
        </div> 
    </div>

</body>

</html>