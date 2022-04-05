<?php session_start();
// Include config file
require_once "config.php";


if (isset($_SESSION["logid"])) {
    $logid = $_SESSION['logid'];
  } else {
    header("location:login.php");
 };

 $year = date("Y");

 $sql = "SELECT * FROM  tenders_test.logins cnt  WHERE  log_name = ?";
                    if ($stmt1 = mysqli_prepare($link, $sql)) {
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt1, "s", $param_id);

                        // Set parameters
                        $param_id = $logid;

                        // Attempt to execute the prepared statement
                        if (mysqli_stmt_execute($stmt1)) {
                            $result1 = mysqli_stmt_get_result($stmt1);

                            if (mysqli_num_rows($result1) == 1) {
                                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                                $row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
                                //$tnd_number = $tnd_NIP = $tnd_contractor = $tnd_type = $tnd_segment = $tnd_announce_date = $tnd_submit_date =  "";
                                // Retrieve individual field value
                                $log_initials = $row["log_initials"];
                               
                                
                            } else {
                                // URL doesn't contain valid id. Redirect to error page
                                header("location: error.php");
                                exit();
                            }
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        mysqli_stmt_close($stmt1);
                    }

                    $sql1 = "SELECT max(substring(tnd_number, 1 , position('/' in tnd_number)-1)) + 1 as number_lp ,tnd_creation_worker FROM tenders_test.tenders
                 WHERE tnd_creation_worker = ? and year(tnd_record_creation_date) = year(now())
                    group by tnd_creation_worker "
                      ;
                    if ($stmt2 = mysqli_prepare($link, $sql1)) {
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt2, "s", $param_id);

                        // Set parameters
                        $param_id = $logid;

                        // Attempt to execute the prepared statement
                        if (mysqli_stmt_execute($stmt2)) {
                            $result1 = mysqli_stmt_get_result($stmt2);

                            if (mysqli_num_rows($result1) == 1) {
                                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                                $row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
                                //$tnd_number = $tnd_NIP = $tnd_contractor = $tnd_type = $tnd_segment = $tnd_announce_date = $tnd_submit_date =  "";
                                // Retrieve individual field value
                                $log_number = $row["number_lp"];
                                
                            } else {
                                // URL doesn't contain valid id. Redirect to error page
                                $log_number = 1;
                            }
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        mysqli_stmt_close($stmt2);
                    }



$default_tender_number =   $log_number .'/' . $log_initials . '/' . $year ;

// Define variables and initialize with empty values
$tnd_number  = $tnd_contractor = $tnd_type = $tnd_segment = $tnd_announce_date = $tnd_submit_date =  "";
$tnd_number_err  = $tnd_contractor_err = $tnd_type_err = $tnd_segment_err = $tnd_announce_date_err = $tnd_submit_date_err =  "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate TENDER


    $input_tnd_number = trim($_POST["inputtendernumber"]);

    $sql_duplikaty = "SELECT count(tnd_number) as duplikat FROM tenders_test.tenders t 
where tnd_number = ? ";

    if ($stmt = mysqli_prepare($link, $sql_duplikaty)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $input_tnd_number);


        if (mysqli_stmt_execute($stmt)) {
            $result_duplikaty = mysqli_stmt_get_result($stmt);
            $row1 = mysqli_fetch_array($result_duplikaty, MYSQLI_ASSOC);
        }
    }



    if (empty($input_tnd_number)) {
        $tnd_number_err = "Wpisz numer przetargu";
    } //elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
    elseif (strlen($input_tnd_number) <= 3) {
        $tnd_number_err = "Wpisz poprawny numer przetargu";
    } elseif ($row1["duplikat"] >= 1) {
        $tnd_number_err = "Przetarg o tym numerze już istnieje";
    } else {
        $tnd_number = $input_tnd_number;
    }


    // // Validate cnt_NIP
    // $input_tnd_NIP = trim($_POST["inputNIP"]);
    // if(empty($input_tnd_NIP)){
    //     $tnd_NIP_err = "Wpisz NIP";     
    // }  elseif(strlen($input_tnd_NIP)!=10 || !ctype_digit($input_tnd_NIP)){
    //     $tnd_NIP_err = "Wpisz poprawny NIP";
    // } else{
    //     $tnd_NIP = $input_tnd_NIP;
    // }

    // VALIDATE CONTARCTOR
    $input_tnd_contractor_id = trim($_POST["inputcnt"]);
    if (empty($input_tnd_contractor_id)) {
        $tnd_contractor_id_err = "Wybierz zamawiajacego";
    } else {
        $tnd_contractor_id = $input_tnd_contractor_id;
    }


    //VALIDATE SEGMENT 
    $input_tnd_segment_id = trim($_POST["inputsegm"]);
    if (empty($input_tnd_segment_id)) {
        $tnd_segment_err = "Wybierz segment";
    } else {
        $tnd_segment = $input_tnd_segment_id;
    }


    // validate type
    $input_tnd_type = trim($_POST["inputtyp"]);
    if (empty($input_tnd_type)) {
        $tnd_type_err = "Wybierz typ";
    } else {
        $tnd_type = $input_tnd_type;
    }

    //VALIDATE ANNOUNCE DATE 
    $input_tnd_announce_date = trim($_POST["input_announce_date"]);
    if (empty($input_tnd_announce_date)) {
        $tnd_announce_date_err = "Wybierz datę";
    } else {
        $tnd_announce_date = $input_tnd_announce_date;
    }

    // validate submit date     
    $input_tnd_submit_date = trim($_POST["submit_date"]);
    if (empty($input_tnd_submit_date)) {
        $tnd_submit_date_err = "Wybierz datę";
    } else {
        $tnd_submit_date = $input_tnd_submit_date;
    }

    $input_tnd_creation_worker = "michal halama";


    // validate e-invoice 

    if (isset($_POST['inputinvoice']) && $_POST['inputinvoice'] >= 0) {
        $input_tnd_einvoice = (($_POST["inputinvoice"]));
    }
    if (empty($input_tnd_einvoice)) {
        $tnd_einvoice_err = "Wybierz rodzaj faktury";
    } else {
        $tnd_einvoice = $input_tnd_einvoice;
    }


    // validate binding date     
    $input_tnd_binding_date = trim($_POST["binding_date"]);
    if (empty($input_tnd_binding_date)) {
        $tnd_binding_date_err = "Wybierz datę";
    } else {
        $tnd_binding_date = $input_tnd_binding_date;
    }

    $input_tnd_creation_worker = $logid;




    // '%d-%m-%y')inputZip

    // Check input errors before inserting in database
    if (empty($tnd_number_err) && empty($tnd_binding_date_err)  && empty($tnd_type_err) && empty($tnd_submit_date_err) && empty($tnd_announce_date_err) && empty($tnd_segment_err) && empty($tnd_contractor_id_err) && empty($tnd_einvoice_err)) {
        // Prepare an insert statement


        $sql = "INSERT INTO tenders_test.tenders (tnd_number, tnd_contractor_id, tnd_segment_id, tnd_type, tnd_announce_date, tnd_submit_date, tnd_e_invoice_correction ,tnd_creation_worker, tnd_binding_date) VALUES ( ?, ?, ?, ?, ?, ? ,?, ?,?)";

        if ($stmt = mysqli_prepare($link, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "siiisssss", $param_tnd_number, $param_tnd_contractor_id, $param_tnd_segment_id, $param_tnd_type, $param_tnd_announce_date, $param_tnd_submit_date, $param_tnd_einvoice, $param_tnd_creation_worker, $param_tnd_binding_worker);

            // Set parameters
            $param_tnd_number = $input_tnd_number;
            //$param_tnd_NIP = $input_tnd_NIP;
            $param_tnd_contractor_id = $input_tnd_contractor_id;
            $param_tnd_segment_id = $input_tnd_segment_id;
            $param_tnd_type = $input_tnd_type;
            $param_tnd_announce_date = $input_tnd_announce_date;
            $param_tnd_submit_date = $input_tnd_submit_date;
            $param_tnd_einvoice = $input_tnd_einvoice;
            $param_tnd_creation_worker = $input_tnd_creation_worker;
            $param_tnd_binding_worker = $input_tnd_binding_date;
            //date_format($date,"Y/m/d H:i:s");

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                //echo "Dodano nowy przetarg";
                header("location: tender_ok.php?tnd_number= $param_tnd_number");
                // echo trim($_POST["inputname"]); 
                // echo $stmt;
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
    </style>
</head>

<body>


    <div class="wrapper">
        <div class="container-fluid">
            <h2 class="mt-5">Dodaj nowy przetarg</h2>
            <p>Uzupełnij formularz i zatwierdź</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">


                <div class="form-row">

                    <div class="form-group col-md-2">
                        <label for="inputtendernumber">Numer przetargu</label>
                        <input type="text" placeholder=<?php echo $default_tender_number?> id="inputtendernumber" name="inputtendernumber" class="form-control  <?php echo (!empty($tnd_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $default_tender_number; ?>">
                        <span class="invalid-feedback"><?php echo $tnd_number_err; ?></span>
                    </div>

               

                    <?php

                    $tender_contractor_sql = "SELECT cnt_name, cnt_id  FROM tenders_test.contractors where cnt_active=1";

                    $tender_contractor_result = mysqli_query($link, $tender_contractor_sql);

                    $options = "";




                    while ($row2 = mysqli_fetch_array($tender_contractor_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }


                    //tutaj pobieramy z bazy nazwę contractora/typu/segmentu, który ma się wyświetlić jeżeli pojawi się bład w innym polu 
                    $selected_cotractor_name_sql = "select distinct cnt_name from tenders_test.contractors where cnt_active=1 and cnt_id = ?";

                    if ($stmt3 = mysqli_prepare($link, $selected_cotractor_name_sql)) {
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt3, "i", $tnd_contractor_id);

                        if (mysqli_stmt_execute($stmt3)) {
                            $result_contractor_name = mysqli_stmt_get_result($stmt3);
                            $row1 = mysqli_fetch_array($result_contractor_name);
                            //
                            if (!$row1 == NULL) {
                                $tnd_contractor_name = $row1[0];
                            } else {
                                $tnd_contractor_name = NULL;
                            }
                        }
                    }

                    $selected_type_name_sql = "select distinct tend_type_name from tenders_test.tender_types where tend_type_id=?";

                    if ($stmt4 = mysqli_prepare($link, $selected_type_name_sql)) {
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt4, "i", $tnd_type);

                        if (mysqli_stmt_execute($stmt4)) {
                            $result_type_name = mysqli_stmt_get_result($stmt4);
                            $row2 = mysqli_fetch_array($result_type_name);
                            //
                            if (!$row2 == NULL) {
                                $tnd_type_name = $row2[0];
                            } else {
                                $tnd_type_name = NULL;
                            }
                        }
                    }

                    $selected_segment_name_sql = "select distinct segm_name from tenders_test.segments where segm_id=?";

                    if ($stmt5 = mysqli_prepare($link, $selected_segment_name_sql)) {
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt5, "i", $tnd_segment);

                        if (mysqli_stmt_execute($stmt5)) {
                            $result_segm_name = mysqli_stmt_get_result($stmt5);
                            $row3 = mysqli_fetch_array($result_segm_name);
                            //
                            if (!$row3 == NULL) {
                                $tnd_segm_name = $row3[0];
                            } else {
                                $tnd_segm_name = NULL;
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

                    <style>
                    .select2-container .select2-selection--single {

                        height: calc(1.5em + 0.75rem + 2px);
                        border: 1px solid #ced4da;
                    }
                        </style>

                    <!-- Dropdown -->
                    <div class="form-group col-md-4">
                        <label for="inputcnt">Zamawiający</label>
                        <select id='inputcnt' name='inputcnt' class="form-control <?php echo (!empty($tnd_contractor_id_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $tnd_contractor_id; ?>> <?php echo $tnd_contractor_name; ?> </option>
                            <OPTION> <?php echo $options ?> </option>
                        </select>
                    </div>



                    <br />
                    <div id='result'></div>

                    <script>
                        $(document).ready(function() {

                            // Initialize select2
                            $("#inputcnt").select2();

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

                    <div class="form-group">
                        <label for="input_announce_date">Data ogłoszenia</label>
                        <input type="date" name="input_announce_date" min="2018-01-01" class="form-control <?php echo (!empty($tnd_announce_date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $tnd_announce_date; ?>">
                        <span class="invalid-feedback"><?php echo $tnd_announce_date_err; ?></span>
                    </div>

                    <div class="form-group">

                        <label>Data złożenia</label>
                        <input type="date" name="submit_date" min="2018-01-01" class="form-control <?php echo (!empty($tnd_submit_date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $tnd_submit_date; ?>">
                        <span class="invalid-feedback"><?php echo $tnd_submit_date_err; ?></span>
                    </div>

                    <div class="form-group">

                        <label>Termin związania ofertą</label>
                        <input type="date" name="binding_date" min="2018-01-01" class="form-control <?php echo (!empty($tnd_binding_date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $tnd_binding_date; ?>">
                        <span class="invalid-feedback"><?php echo $tnd_binding_date_err; ?></span>
                    </div>

                    <?php

                    $tender_types_sql = "SELECT  tend_type_name ,tend_type_id FROM tenders_test.tender_types";

                    $tender_types_result = mysqli_query($link, $tender_types_sql);

                    $options = "";



                    //ładowanie opcji do listy rozwijanej 
                    while ($row2 = mysqli_fetch_array($tender_types_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>

                    <div class="form-group col-md-4">
                        <label for="inputtyp">Typ</label>

                        <select id="exampleFormControlSelect1" name="inputtyp" class="form-control <?php echo (!empty($tnd_type_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $tnd_type_name; ?>">
                            <div class="invalid-feedback"><?php echo $tnd_type_err; ?></div>
                            <option selected="selected" hidden value=<?php echo $tnd_type; ?>> <?php echo $tnd_type_name; ?> </option>
                            <OPTION> <?php echo $options ?> </option>

                        </select>

                    </div>




                </div>

                <div class="form-row">

                    <?php

                    $tender_segment_sql = "SELECT  segm_name ,segm_id FROM tenders_test.segments";

                    $tender_segment_result = mysqli_query($link, $tender_segment_sql);

                    $options = "";




                    while ($row2 = mysqli_fetch_array($tender_segment_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>



                    <div class="form-group col-md-4">
                        <label for="inputsegm">Segment</label>



                        <select id="exampleFormControlSelect1" name="inputsegm" class="form-control <?php echo (!empty($tnd_segment_err)) ? 'is-invalid' : ''; ?>">
                            <option selected="selected" hidden value=<?php echo $tnd_segment; ?>> <?php echo $tnd_segm_name; ?> </option>
                            <div class="invalid-feedback"><?php echo $tnd_segment_err; ?></div>
                            <OPTION> <?php echo $options ?> </option>
                        </select>
                    </div>





                    <?php //jezeli ktoś po raz pierwszy wchodzi w create to przypisz nulla inaczej będzie bład

                    (isset($tnd_einvoice) ?: $tnd_einvoice = "") ?>

                    <div class="form-group col-md-2">
                        <label for="inputinvoice">E-korekta faktur</label>

                        <select id="exampleFormControlSelect1" name="inputinvoice" class="form-control <?php echo (!empty($tnd_einvoice_err)) ? 'is-invalid' : ''; ?>">
                            <option selected="selected" value=<?php echo $tnd_einvoice; ?>> <?php echo $tnd_einvoice; ?> </option>
                            <option value="TAK"> TAK </option>
                            <option value="NIE"> NIE </option>
                        </select>
                    </div>


                </div>
        </div>


        <?php mysqli_close($link); ?>



        <input type="submit" class="btn btn-primary" value="Dodaj przetarg">

        <a href="tenders.php" class="btn btn-secondary ml-2">Powrót</a>
        </form>
    </div>
    </div>
    </div>
    </div>

</body>

</html>