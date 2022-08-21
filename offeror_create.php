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

//echo  $_SESSION['paramid'];

// Include config file
require_once "config.php";



// Define variables and initialize with empty values
$off_lead_off  = $off_key_offeror1 = $off_key_offeror2 = $off_key_offeror3 = $off_key_offeror4  = $off_key_offeror5 = $off_contract_value = $off_points1 = $off_points2 = $off_points3 = $off_points4 = $off_points5 = $off_remarks = NULL;
$off_lead_off_err  = $off_key_offeror1_err = $off_key_offeror2_err = $off_key_offeror3_err = $off_key_offeror4_err  = $off_key_offeror5_err = $off_contract_value_err = $off_points1_err = $off_points2_err = $off_points3_err = $off_points4_err = $off_points5_err = $off_tenderoutput_err = NULL;



//tutaj sprawdzamy, które kryteria są wypelnione w tasks.php

$sql_crit = 'SELECT case when job_criteria_id1 is null  or length(job_criteria_id1) = 0 then 1 else 0 end as crit1,
case when job_criteria_id2 is null  or length(job_criteria_id2) = 0 then 1 else 0 end as crit2,
case when job_criteria_id3 is null  or length(job_criteria_id3) = 0 then 1 else 0 end as crit3,
case when job_criteria_id4 is null  or length(job_criteria_id4) = 0 then 1 else 0 end as crit4,
case when job_criteria_id5 is null  or length(job_criteria_id5) = 0 then 1 else 0 end as crit5
FROM tenders_jobs
where job_id = ?';

if ($stmt_crit = mysqli_prepare($link, $sql_crit)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt_crit, "i", $_SESSION['paramid']);

    if (mysqli_stmt_execute($stmt_crit)) {
        $result_crit = mysqli_stmt_get_result($stmt_crit);
        $row_crit = mysqli_fetch_array($result_crit);
        //
        if (!$row_crit == NULL) {
            $crit1_db = $row_crit[0];
        } else {
            $crit1_db = 0;
        }


        if (!$row_crit == NULL) {
            $crit2_db = $row_crit[1];
        } else {
            $crit2_db = 0;
        }

        if (!$row_crit == NULL) {
            $crit3_db = $row_crit[2];
        } else {
            $crit3_db = 0;
        }

        if (!$row_crit == NULL) {
            $crit4_db = $row_crit[3];
        } else {
            $crit4_db = 0;
        }

        if (!$row_crit == NULL) {
            $crit5_db = $row_crit[4];
        } else {
            $crit5_db = 0;
        }
    }
}


// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate TENDER


    //$input_tnd_number = trim($_POST["inputtendernumber"]);

    // VALIDATE lead off
    $input_lead_off = trim($_POST["keyoff"]);
    if (empty($input_lead_off)) {
        $off_lead_off_err = "Wybierz społkę wiodącą";
    } else {
        $off_lead_off = $input_lead_off;
    }


    // VALIDATE lead off
     $input_contract_value = trim($_POST["off_value"]);
    // if (empty($input_contract_value) or (!is_numeric(str_replace(' ', '', str_replace(',', '.', $input_contract_value)))) 
    // or (str_replace(' ', '', str_replace(',', '.', $input_contract_value)) == 0 )) {
    //     $off_contract_value_err = "Wpisz wartość oferty";
    // } else {
         $off_contract_value = str_replace(' ', '', str_replace(',', '.', $input_contract_value));
    // }




    $off_key_offeror1 = trim($_POST["off1"]);
    $off_key_offeror2 = trim($_POST["off2"]);
    $off_key_offeror3 = trim($_POST["off3"]);
    $off_key_offeror4 = trim($_POST["off4"]);
    $off_key_offeror5 = trim($_POST["off5"]);


    // VALIDATE point1
    if ($crit1_db == 0) {
        $input_off_points1 = str_replace(',', '.', trim($_POST["points1"]));
    }


    if (empty($input_off_points1)) {
        $off_points1 = NULL;
    } elseif (!is_numeric($input_off_points1)) {
        $off_points1_err = "Wpisz wartość liczbową";
    } elseif ($input_off_points1 > 100) {
        $off_points1_err = "Wartość kryterium nie może być większe niż 100";
    } else {
        $off_points1 = $input_off_points1;
    }

    // VALIDATE point2
    if ($crit2_db == 0) {
        $input_off_points2 = str_replace(',', '.', trim($_POST["points2"]));
    }

    if (empty($input_off_points2)) {
        $off_points2 = NULL;
    } elseif (!is_numeric($input_off_points2)) {
        $off_points2_err = "Wpisz wartość liczbową";
    } elseif ($input_off_points2 > 100) {
        $off_points2_err = "Wartość kryterium nie może być większe niż 100";
    } else {
        $off_points2 = $input_off_points2;
    }

    // VALIDATE point3
    if ($crit3_db == 0) {
        $input_off_points3 = str_replace(',', '.', trim($_POST["points3"]));
    }

    if (empty($input_off_points3)) {
        $off_points3 = NULL;
    } elseif (!is_numeric($input_off_points3)) {
        $off_points3_err = "Wpisz wartość liczbową";
    } elseif ($input_off_points3 > 100) {
        $off_points3_err = "Wartość kryterium nie może być większe niż 100";
    } else {
        $off_points3 = $input_off_points3;
    }


    // VALIDATE point4
    if ($crit4_db == 0) {
        $input_off_points4 = str_replace(',', '.', trim($_POST["points4"]));
    }


    if (empty($input_off_points4)) {
        $off_points4 = NULL;
    } elseif (!is_numeric($input_off_points4)) {
        $off_points4_err = "Wpisz wartość liczbową";
    } elseif ($input_off_points4 > 100) {
        $off_points4_err = "Wartość kryterium nie może być większe niż 100";
    } else {
        $off_points4 = $input_off_points4;
    }


    // VALIDATE point5
    if ($crit5_db == 0) {
        $input_off_points5 = str_replace(',', '.', trim($_POST["points5"]));
    }

    if (empty($input_off_points5)) {
        $off_points5 = NULL;
    } elseif (!is_numeric($input_off_points5)) {
        $off_points5_err = "Wpisz wartość liczbową";
    } elseif ($input_off_points5 > 100) {
        $off_points5_err = "Wartość kryterium nie może być większe niż 100";
    } else {
        $off_points5 = $input_off_points4;
    }




    $input_off_remarks = trim($_POST["remarks"]);
    if ((strlen($input_off_remarks) > 349)) {
        $off_remarks_value_err = "Uwaga zbyt długa";
    } else {
        $off_remarks = $input_off_remarks;
    }

    // validate tender output wygrany musi miec id =1 

    $sql_winn = 'SELECT min(off_output) as output_winner FROM offerors
where off_job_id=?';

    if ($stmt_winn = mysqli_prepare($link, $sql_winn)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt_winn, "i", $_SESSION['paramid']);
        if (mysqli_stmt_execute($stmt_winn)) {
            $result_winn = mysqli_stmt_get_result($stmt_winn);
            $row_winn = mysqli_fetch_array($result_winn);
            //
            if (!$row_winn == NULL) {
                $winn_db = $row_winn[0];
            } else {
                $winn_db = 0;
            }
        }
    }


    $input_tenderoutput = trim($_POST["tenderoutput"]);
    if (empty($input_tenderoutput)) {
        $off_tenderoutput_err = "Wybierz wynik przetargu";
    } elseif ($input_tenderoutput == 1 and $winn_db == 1) {
        $off_tenderoutput_err = "Zwycięzca już istnieje";
    } else {
        $off_tenderoutput = $input_tenderoutput;
    }


    $input_off_creation_worker =  $logid;

    // validate start date     
    $input_off_start_date = trim($_POST["start_date"]);


    if (empty($off_contract_value_err) && empty($off_lead_off_err)  && empty($off_points1_err) && empty($off_points2_err) && empty($off_points3_err) && empty($off_points4_err) && empty($off_points5_err) && empty($off_tenderoutput_err)) {
        // Prepare an insert statement

        $off_job_id = trim($_POST["paramid"]);

        $sql = "INSERT INTO offerors (off_job_id, off_leading_offeror, off_key_offeror1, off_key_offeror2, off_key_offeror3, off_key_offeror4, off_key_offeror5 , off_contract_value ,off_points_crit1, off_points_crit2,off_points_crit3,off_points_crit4,off_points_crit5, off_remarks, off_output, off_creation_work,off_contract_start_date) VALUES ( ?, ?,?, ?, ?, ?, ?, ?, ?, ?,  ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iiiiiisddddddsiss", $param_off_job_id, $param_off_leading_offeror, $param_off_key_offeror1, $param_off_key_offeror2,  $param_off_key_offeror3,  $param_off_key_offeror4, $param_off_key_offeror5, $param_off_contract_value, $param_off_points1, $param_off_points2, $param_off_points3, $param_off_points4, $param_off_points5, $param_off_remarks, $param_off_output, $param_off_creation_worker, $param_off_start_date);

            $param_off_job_id = $off_job_id;
            $param_off_leading_offeror = $off_lead_off;
            $param_off_key_offeror1 = $off_key_offeror1;
            $param_off_key_offeror2 = $off_key_offeror2;
            $param_off_key_offeror3 = $off_key_offeror3;
            $param_off_key_offeror4 = $off_key_offeror4;
            $param_off_key_offeror5 = $off_key_offeror5;
            $param_off_contract_value = $off_contract_value;

            $param_off_points1 = $off_points1;
            $param_off_points2 = $off_points2;
            $param_off_points3 = $off_points3;
            $param_off_points4 = $off_points4;
            $param_off_points5 = $off_points5;
            $param_off_remarks = $off_remarks;
            $param_off_output = $off_tenderoutput;
            $param_off_creation_worker = $input_off_creation_worker;

            $param_off_start_date = $input_off_start_date;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                //echo "Dodano nowy przetarg";
                header("location: offerors_ok.php?job_id=" . $_SESSION['paramid']);
                // echo $_POST['off_winner'];
                // echo trim($_POST["inputname"]); 
                // echo $off_points1;
                exit();
            } else {
                echo "Ups! Wystąpił błąd";
                echo mysqli_stmt_error($stmt);
            }


            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
}

?>

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

        .checkbox {
            width: 50vw;
            height: 5vh;
        }

        input[type=checkbox] {
            /* Double-sized Checkboxes */
            -ms-transform: scale(2);
            /* IE */
            -moz-transform: scale(2);
            /* FF */
            -webkit-transform: scale(2);
            /* Safari and Chrome */
            -o-transform: scale(2);
            /* Opera */
            transform: scale(2);
            padding: 10px;
        }

        #rr-element {
            white-space: nowrap;
        }

        #rr-element label {
            padding-left: 0.4em;
        }

        /* Might want to wrap a span around your checkbox text */
        .checkboxtext {
            /* Checkbox text */
            font-size: 110%;
            display: inline;
        }
    </style>
</head>

<body>


    <div class="wrapper">
        <div class="container-fluid">
            <h2 class="mt-5">Dodaj ofertę</h2>
            <p>Uzupełnij formularz i zatwierdź</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">


                <div class="form-row">


                    <?php

                    $offnames_sql = "SELECT offnames_name, offnames_id  FROM offerors_names where offnames_active=1";

                    $offnames_result = mysqli_query($link, $offnames_sql);

                    $options = "";

                    while ($row2 = mysqli_fetch_array($offnames_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }

                    //tutaj pobieramy z bazy nazwę oferenta, który ma się wyświetlić jeżeli pojawi się bład w innym polu 
                    $selected_keyoff_sql = "select distinct offnames_name from offerors_names where offnames_active=1 and offnames_id = ?";

                    if ($stmt3 = mysqli_prepare($link, $selected_keyoff_sql)) {
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt3, "i", $off_lead_off);

                        if (mysqli_stmt_execute($stmt3)) {
                            $result_keyoff_name = mysqli_stmt_get_result($stmt3);
                            $row1 = mysqli_fetch_array($result_keyoff_name);
                            //
                            if (!$row1 == NULL) {
                                $keyoff_name = $row1[0];
                            } else {
                                $keyoff_name = NULL;
                            }
                        }
                    }


                    //outputs options

                    $output_options_sql = "SELECT off_tnd_name,off_tnd_out  FROM offerors_tender_output where off_tnd_active=1";

                    $output_options_results = mysqli_query($link, $output_options_sql);

                    $output_options = "";

                    while ($row2 = mysqli_fetch_array($output_options_results)) {
                        $output_options = $output_options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }



                    if ($stmt3 = mysqli_prepare($link, $selected_keyoff_sql)) {
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt3, "i", $off_key_offeror1);

                        if (mysqli_stmt_execute($stmt3)) {
                            $result_keyoff_name = mysqli_stmt_get_result($stmt3);
                            $row1 = mysqli_fetch_array($result_keyoff_name);
                            //
                            if (!$row1 == NULL) {
                                $keyoff1_name = $row1[0];
                            } else {
                                $keyoff1_name = NULL;
                            }
                        }
                    }


                    if ($stmt3 = mysqli_prepare($link, $selected_keyoff_sql)) {
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt3, "i", $off_key_offeror2);

                        if (mysqli_stmt_execute($stmt3)) {
                            $result_keyoff_name = mysqli_stmt_get_result($stmt3);
                            $row1 = mysqli_fetch_array($result_keyoff_name);
                            //
                            if (!$row1 == NULL) {
                                $keyoff2_name = $row1[0];
                            } else {
                                $keyoff2_name = NULL;
                            }
                        }
                    }
                    if ($stmt3 = mysqli_prepare($link, $selected_keyoff_sql)) {
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt3, "i", $off_key_offeror3);

                        if (mysqli_stmt_execute($stmt3)) {
                            $result_keyoff_name = mysqli_stmt_get_result($stmt3);
                            $row1 = mysqli_fetch_array($result_keyoff_name);
                            //
                            if (!$row1 == NULL) {
                                $keyoff3_name = $row1[0];
                            } else {
                                $keyoff3_name = NULL;
                            }
                        }
                    }

                    $selected_output_sql = "select distinct off_tnd_name, off_tnd_out from offerors_tender_output where off_tnd_active=1 and off_tnd_out = ?";


                    if ($stmt4 = mysqli_prepare($link, $selected_output_sql)) {
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt4, "i", $off_tenderoutput);

                        if (mysqli_stmt_execute($stmt4)) {
                            $result_output_name = mysqli_stmt_get_result($stmt4);
                            $row1 = mysqli_fetch_array($result_output_name);
                            //
                            if (!$row1 == NULL) {
                                $output_name = $row1[0];
                                $output_id = $row1[1];
                            } else {
                                $output_name = NULL;
                                $output_id = NULL;
                            }
                        }
                    }

                    if ($stmt3 = mysqli_prepare($link, $selected_keyoff_sql)) {
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt3, "i", $off_key_offeror4);

                        if (mysqli_stmt_execute($stmt3)) {
                            $result_keyoff_name = mysqli_stmt_get_result($stmt3);
                            $row1 = mysqli_fetch_array($result_keyoff_name);
                            //
                            if (!$row1 == NULL) {
                                $keyoff4_name = $row1[0];
                            } else {
                                $keyoff4_name = NULL;
                            }
                        }
                    }
                    ?>


                    <!-- Select2 CSS -->
                    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

                    <!-- jQuery -->
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                    <!-- Select2 JS -->
                    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
                    <!--link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" -->


                    <!-- Dropdown -->
                    <div class="form-group col-md-4">
                        <label for="keyoff">Spółka wiodąca</label>
                        <select id='keyoff' name='keyoff' class="form-control <?php echo (!empty($off_lead_off_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $off_lead_off; ?>> <?php echo $keyoff_name; ?> </option>
                            <OPTION> <?php echo $options ?> </option>
                        </select>
                    </div>



                    <br />
                    <div id='result'></div>

                    <script>
                        $(document).ready(function() {

                            // Initialize select2
                            $("#keyoff").select2();

                            // Read selected option
                            $('#but_read').click(function() {
                                var username = $('#inputcnt option:selected').text();
                                var userid = $('#inputcnt').val();

                                $('#result').html("id : " + userid + ", name : " + username);

                            });
                        });
                    </script>


                    <div class="form-group col-md-2">
                        <label for="off_value">Kwota oferty</label>
                        <input type="float" lang="en-150" id="off_value" name="off_value" class="form-control" value="<?php echo number_format($off_contract_value, 2, ',', ' '); ?>">
                        <span class="invalid-feedback"><?php echo $off_contract_value_err; ?></span>
                    </div>




                </div>

                <style>
                    .select2-container .select2-selection--single {

                        height: calc(1.5em + 0.75rem + 2px);
                        border: 1px solid #ced4da;
                    }
                </style>


                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="off1">Kluczowy oferent 1</label>
                        <select id='off1' name='off1' class="form-control">
                            <option selected="selected" hidden value=<?php echo $off_key_offeror1; ?>> <?php echo $keyoff1_name; ?> </option>
                            <OPTION> <?php echo $options ?> </option>
                        </select>
                    </div>



                    <script>
                        $(document).ready(function() {

                            // Initialize select2
                            $("#off1").select2();

                            // Read selected option
                            $('#but_read').click(function() {
                                var username = $('#inputcnt option:selected').text();
                                var userid = $('#inputcnt').val();

                                $('#result').html("id : " + userid + ", name : " + username);

                            });
                        });
                    </script>


                    <div class="form-group col-md-4">
                        <label for="off2">Kluczowy oferent 2</label>
                        <select id='off2' name='off2' class="form-control">
                            <option selected="selected" hidden value=<?php echo $off_key_offeror2; ?>> <?php echo $keyoff2_name; ?> </option>
                            <OPTION> <?php echo $options ?> </option>
                        </select>
                    </div>
                </div>


                <script>
                    $(document).ready(function() {

                        // Initialize select2
                        $("#off2").select2();

                        // Read selected option
                        $('#but_read').click(function() {
                            var username = $('#inputcnt option:selected').text();
                            var userid = $('#inputcnt').val();

                            $('#result').html("id : " + userid + ", name : " + username);

                        });
                    });
                </script>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="off3">Kluczowy oferent 3</label>
                        <select id='off3' name='off3' class="form-control">
                            <option selected="selected" hidden value=<?php echo $off_key_offeror3; ?>> <?php echo $keyoff3_name; ?> </option>
                            <OPTION> <?php echo $options ?> </option>
                        </select>
                    </div>




                    <script>
                        $(document).ready(function() {

                            // Initialize select2
                            $("#off3").select2();

                            // Read selected option
                            $('#but_read').click(function() {
                                var username = $('#inputcnt option:selected').text();
                                var userid = $('#inputcnt').val();

                                $('#result').html("id : " + userid + ", name : " + username);

                            });
                        });
                    </script>



                    <div class="form-group col-md-4">
                        <label for="off4">Kluczowy oferent 4</label>
                        <select id='off4' name='off4' class="form-control">
                            <option selected="selected" hidden value=<?php echo $off_key_offeror4; ?>> <?php echo $keyoff4_name; ?> </option>
                            <OPTION> <?php echo $options ?> </option>
                        </select>
                    </div>


                    <div class="form-group col-md-4">
                        <label for="off5">Kluczowy oferent 5</label>
                        <input type="text" id='off5' name='off5' class="form-control" value=<?php echo $off_key_offeror5 ?>>

                        </select>
                    </div>



                </div>


                <script>
                    $(document).ready(function() {

                        // Initialize select2
                        $("#off4").select2();

                        // Read selected option
                        $('#but_read').click(function() {
                            var username = $('#inputcnt option:selected').text();
                            var userid = $('#inputcnt').val();

                            $('#result').html("id : " + userid + ", name : " + username);

                        });
                    });
                </script>



                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="points1">Punkty kryterium 1</label>
                        <input type="text" id="points1" name="points1" class="form-control <?php echo (!empty($off_points1_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $off_points1; ?>" <?php echo ($crit1_db == 1) ? 'disabled' : ''; ?>>
                        <span class="invalid-feedback"><?php echo $off_points1_err; ?></span>
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="points2">Punkty kryterium 2</label>
                        <input type="text" id="points2" name="points2" class="form-control <?php echo (!empty($off_points2_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $off_points2; ?>" <?php echo ($crit2_db == 1) ? 'disabled' : ''; ?>>
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="points3">Punkty kryterium 3</label>
                        <input type="text" id="points3" name="points3" class="form-control <?php echo (!empty($off_points3_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $off_points3; ?>" <?php echo ($crit3_db == 1) ? 'disabled' : ''; ?>>
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="points4">Punkty kryterium 4</label>
                        <input type="text" id="points4" name="points4" class="form-control <?php echo (!empty($off_points4_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $off_points4; ?>" <?php echo ($crit4_db == 1) ? 'disabled' : '' ?>>
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="points5">Punkty kryterium 5</label>
                        <input type="text" id="points5" name="points5" class="form-control <?php echo (!empty($off_points5_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $off_points5; ?>" <?php echo ($crit5_db == 1) ? 'disabled' : '' ?>>
                        </select>
                    </div>
                </div>




                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="off_value">Uwagi</label>
                        <input type="text" id="remarks" name="remarks" class="form-control" value="<?php echo $off_remarks; ?>">

                    </div>





                    <div class="form-group col-md-4">
                        <label for="tenderoutput">Wynik przetargu</label>
                        <select id='tenderoutput' name='tenderoutput' class="form-control <?php echo (!empty($off_tenderoutput_err)) ? 'is-invalid' : ''; ?>">
                            <option selected="selected" hidden value=<?php echo $output_id; ?>> <?php echo $output_name; ?> </option>
                            <span class="text-danger"><?php echo $off_tenderoutput_err; ?>
                    </div>
                    <OPTION> <?php echo $output_options ?> </option>
                    </select>
                </div>


                <div class="form-group">
                    <label>Data rozpoczęcia kontraktu</label>
                    <input type="date" name="start_date" min="2018-01-01"  class="form-control" value="<?php echo $input_off_start_date; ?>">
                </div>


             

        </div>





        <?php mysqli_close($link); ?>



        <input type="submit" class="btn btn-primary" value="Dodaj ofertę">

        <input type="hidden" id="paramid" name="paramid" value=<?php echo $_SESSION['paramid'] ?>>

        <a href="offerors.php?job_id=<?php echo $_SESSION['paramid'] ?>" class="btn btn-secondary ml-2">Powrót</a>
        </form>
    </div>
    </div>
    </div>
    </div>

</body>

</html>