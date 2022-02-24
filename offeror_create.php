<?php
// Include config file
require_once "config.php";



// Define variables and initialize with empty values
$off_lead_off  = $off_key_offeror1 = $off_key_offeror2 = $off_key_offeror3 = $off_key_offeror4  = $doff_key_offeror5 = $off_contract_value =  "";
$off_lead_off_err  = $off_key_offeror1_err = $off_key_offeror2_err = $off_key_offeror3_err = $off_key_offeror4_err  = $off_key_offeror5_err = $off_contract_value_err =  "";

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
    $input_contract_value = trim($_POST["inputcnt"]);
    if (empty($input_contract_value)) {
        $off_contract_value_err = "Wpisz wartość oferty";
    } else {
        $off_contract_value = $input_contract_value;
    }


    if (empty($off_contract_value_err) && empty($off_lead_off_err))  {
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
            $param_tnd_creation_worker = "michal halama";
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
            <h2 class="mt-5">Dodaj oferenta</h2>
            <p>Uzupełnij formularz i zatwierdź</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">


                <div class="form-row">

                 


                    <?php

                    $offnames_sql = "SELECT offnames_name, offnames_id  FROM tenders_test.offerors_names where offnames_active=1";

                    $offnames_result = mysqli_query($link, $offnames_sql);

                    $options = "";

                    while ($row2 = mysqli_fetch_array($offnames_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }

                    //tutaj pobieramy z bazy nazwę contractora/typu/segmentu, który ma się wyświetlić jeżeli pojawi się bład w innym polu 
                    $selected_keyoff_sql = "select distinct offnames_name from tenders_test.offerors_names where offnames_active=1 and offnames_id = ?";

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

        <a href="index.php" class="btn btn-secondary ml-2">Powrót</a>
        </form>
    </div>
    </div>
    </div>
    </div>

</body>

</html>