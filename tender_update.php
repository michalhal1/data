<?php session_start();

//zmienna sesyjna , po kliknięciu w stronę zapamiętuje parametr
if (isset($_GET["tnd_number"])) {
    $paramid = trim($_GET["tnd_number"]);
    $_SESSION['paramid'] = $paramid;
};


if (isset($_SESSION["logid"])) {
   $logid = $_SESSION['logid'];
 } else {
   header("location:login.php");
};


require_once "config.php";



// Define variables and initialize with empty values
$tnd_number  = $tnd_contractor = $tnd_type = $tnd_segment = $tnd_announce_date = $tnd_submit_date  = $tnd_einvoice = "";
$tnd_number_err  = $tnd_contractor_id_err = $tnd_type_err = $tnd_segment_err = $tnd_announce_date_err = $tnd_submit_date_err = $tnd_einvoice_err =  "";


// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $input_tnd_number = trim($_POST["inputtendernumber"]);
    if (empty($input_tnd_number)) {
        $tnd_number_err = "Wpisz numer przetargu";
    } //elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
    elseif (strlen($input_tnd_number) <= 3) {
        $tnd_number_err = "Wpisz poprawny numer przetargu";
    } else {
        $tnd_number = $input_tnd_number;
    }


    // // Validate cnt_NIP
    // $input_tnd_NIP = trim($_POST["inputNIP"]);
    // if(empty($input_tnd_NIP)){
    //     $cnt_NIP_err = "Wpisz NIP";     
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
        $tnd_contractor = intval($input_tnd_contractor_id);
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
        $tnd_type = intval($input_tnd_type);
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

    $input_tnd_creation_worker = $logid;

    // validate e-invoice 

    if (isset($_POST['inputinvoice']) && $_POST['inputinvoice'] >= 0) {
        $input_tnd_einvoice = (($_POST["inputinvoice"]));
    }
    if (empty($input_tnd_einvoice)) {
        $tnd_einvoice_err = "Wybierz rodzaj faktury";
    } else {
        $tnd_einvoice = $input_tnd_einvoice;
    }
    // '%d-%m-%y')inputZip

    // validate binding date     
    $input_tnd_binding_date = trim($_POST["binding_date"]);
    if (empty($input_tnd_binding_date)) {
        $tnd_binding_date_err = "Wybierz datę";
    } else {
        $tnd_binding_date = $input_tnd_binding_date;
    }

    // jeżeli naciśnięto submit i wszystkie komuniaty błędów są puste updatuj (metoda POST)
    // Check input errors before inserting in database
    if (empty($tnd_number_err) and empty($tnd_binding_date_err) and empty($tnd_type_err)  and empty($tnd_segment_err)  and empty($tnd_contractor_id_err)  and empty($tnd_einvoice_err)   and empty($tnd_submit_date_err)  and empty($tnd_announce_date_err)) {
        // Prepare an insert statement


        $sql = "UPDATE tenders set tnd_contractor_id=?, tnd_segment_id=?, tnd_type=?, tnd_announce_date=?, tnd_submit_date=?, tnd_e_invoice_correction=? ,tnd_modification_worker=? ,  tnd_binding_date=? , tnd_record_modification_date= now() where tnd_number=?";

        if ($stmt = mysqli_prepare($link, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iiissssss", $param_tnd_contractor_id, $param_tnd_segment_id, $param_tnd_type, $param_tnd_announce_date, $param_tnd_submit_date, $param_tnd_einvoice, $param_tnd_creation_worker, $param_tnd_binding_date, $param_tnd_number);

            // Set parameters

            // $param_tnd_NIP = $input_tnd_NIP;
            $param_tnd_contractor_id = $input_tnd_contractor_id;
            $param_tnd_segment_id = $input_tnd_segment_id;
            $param_tnd_type = $input_tnd_type;
            $param_tnd_announce_date = $input_tnd_announce_date;
            $param_tnd_submit_date = $input_tnd_submit_date;
            $param_tnd_einvoice = $input_tnd_einvoice;
            $param_tnd_creation_worker = $input_tnd_creation_worker;
            $param_tnd_binding_date = $input_tnd_binding_date;
            $param_tnd_number = ($_SESSION['paramid']);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                // echo "Dodano nowy przetarg";
                header("location: tender_update_ok.php");
                // echo trim($_POST["inputname"]); 
                // echo $stmt;
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
                echo mysqli_stmt_error($stmt);
            }


            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // jeżeli był błąd to ściągnij dane z bazy z dotychczasowymi danymi i załaduj je do pól w czesci HTML
    $selected_segment_name_sql = "select distinct segm_name, segm_id from segments where segm_id=?";

    if ($stmt5 = mysqli_prepare($link, $selected_segment_name_sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt5, "i", $tnd_segment);

        if (mysqli_stmt_execute($stmt5)) {
            $result_segm_name = mysqli_stmt_get_result($stmt5);
            $row3 = mysqli_fetch_array($result_segm_name);
            //
            if (!$row3 == NULL) {
                $tnd_segment_name = $row3[0];
                $tnd_segment = $row3[1];
            } else {
                // $tnd_segm_name = NULL;

            }
        }
    }

    $selected_cotractor_name_sql = "select distinct cnt_name, cnt_id from contractors where cnt_id = ?";


    if ($stmt3 = mysqli_prepare($link, $selected_cotractor_name_sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt3, "i", $tnd_contractor);

        if (mysqli_stmt_execute($stmt3)) {
            $result_contractor_name = mysqli_stmt_get_result($stmt3);
            $row1 = mysqli_fetch_array($result_contractor_name);

            if (!$row1 == NULL) {
                $tnd_contractor_name = $row1[0];
                $tnd_contractor = $row1[1];
            }
        }
    }



    $selected_type_name_sql = "select distinct tend_type_name, tend_type_id from tender_types where tend_type_id=?";

    if ($stmt4 = mysqli_prepare($link, $selected_type_name_sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt4, "i", $tnd_type);

        if (mysqli_stmt_execute($stmt4)) {
            $result_type_name = mysqli_stmt_get_result($stmt4);
            $row2 = mysqli_fetch_array($result_type_name);
            //
            if (!$row2 == NULL) {
                $tnd_type_name = $row2[0];
                $tnd_type = $row2[1];
            } else {
                $tnd_type_name = NULL;
            }
        }
    }
} else { //jeżeli nie było submita to sćiągnij z bazy dane i załaduj pola
    // Check existence of id parameter before processing further
    if (isset($_GET["tnd_number"]) && !empty(trim($_GET["tnd_number"]))) {
        // Get URL parameter
        $id =  trim($_GET["tnd_number"]);
        // Prepare a select statement
        $sql = "SELECT * FROM tenders t 
        left join tender_types tt on tt.tend_type_id = t.tnd_type
        left join contractors cnt on t.tnd_contractor_id= cnt.cnt_id
        left join segments seg on seg.segm_id= t.tnd_segment_id WHERE tnd_number = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_tnd_number);

            // Set parameters
            $param_tnd_number = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    //$tnd_number = $tnd_NIP = $tnd_contractor = $tnd_type = $tnd_segment = $tnd_announce_date = $tnd_submit_date =  "";
                    // Retrieve individual field value
                    $tnd_number = $row["tnd_number"];
                    //     $tnd_NIP = $row["tnd_NIP"];
                    $tnd_contractor_name = $row["cnt_name"];
                    $tnd_contractor = $row["cnt_id"];
                    $tnd_type_name = $row["tend_type_name"];
                    $tnd_type = $row["tend_type_id"];
                    $tnd_segment_name = $row["segm_name"];
                    $tnd_segment = $row["segm_id"];
                    $tnd_announce_date = $row["tnd_announce_date"];
                    $tnd_submit_date = $row["tnd_submit_date"];
                    $tnd_einvoice = $row['tnd_e_invoice_correction'];
                    $tnd_binding_date = $row['tnd_binding_date'];
                } else {
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection

    } else {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
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

    <div class="wrapper">

        <div class="container-fluid">
            <h2 class="mt-5">Edytuj przetarg</h2>
            Uzupełnij formularz i zatwierdź <br> <br>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">


                <div class="form-row">

                    <div class="form-group col-md-2">
                        <label for="inputtendernumber">Numer przetargu</label>
                        <input type="text" id="inputtendernumber" name="inputtendernumber" class="form-control <?php echo (!empty($tnd_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $tnd_number; ?>">
                        <span class="invalid-feedback"><?php echo $tnd_number_err; ?></span>
                    </div>


                    <!-- 
    <div class="form-group col-md-2">
      <label for="inputNIP">NIP</label>
      <input  id="inputNIP" name="inputNIP" type="text" class="form-control <?php // echo (!empty($tnd_NIP_err)) ? 'is-invalid' : ''; 
                                                                            ?>" value="<?php echo $tnd_NIP; ?>">
      <span class="invalid-feedback"><?php // echo $tnd_NIP_err;
                                        ?></span>
    </div> -->





                    <?php

                    //pętla która ładuje liste (opcje) zamawiających 
                    $tender_contractor_sql = "SELECT cnt_name, cnt_id  FROM contractors where cnt_active=1";

                    $tender_contractor_result = mysqli_query($link, $tender_contractor_sql);

                    $options = "";

                    while ($row2 = mysqli_fetch_array($tender_contractor_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>

                    <div class="form-group col-md-4">

                        <label for="inputcnt">Zamawiający</label>
                        <select id='inputcnt' name='inputcnt' class="form-control <?php echo (!empty($tnd_contractor_id_err)) ? 'is-invalid' : ''; ?>">>
                            <option selected="selected" hidden value=<?php echo $tnd_contractor; ?>> <?php echo $tnd_contractor_name; ?> </option>
                            <div class="invalid-feedback"><?php echo $tnd_contractor_id_err; ?></div>
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
                        <span class="invalid-feedback"><?php echo $annaounce_date_err; ?></span>

                    </div>

                    <div class="form-group">

                        <label>Data złożenia</label>
                        <input type="date" name="submit_date" min="2018-01-01" class="form-control <?php echo (!empty($submit_date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $tnd_submit_date; ?>">
                        <span class="invalid-feedback"><?php echo $submit_date_err; ?></span>

                    </div>


                    <div class="form-group">

                        <label>Termin związania ofertą</label>
                        <input type="date" name="binding_date" min="2018-01-01" class="form-control <?php echo (!empty($tnd_binding_date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $tnd_binding_date; ?>">
                        <span class="invalid-feedback"><?php echo $tnd_binding_date_err; ?></span>

                    </div>


                    <?php

                    $tender_types_sql = "SELECT  tend_type_name ,tend_type_id FROM tender_types";

                    $tender_types_result = mysqli_query($link, $tender_types_sql);

                    $options = "";


                    while ($row2 = mysqli_fetch_array($tender_types_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>

                    <div class="form-group col-md-4">

                        <label for="inputtyp">Typ</label>
                        <select id="exampleFormControlSelect1" name="inputtyp" class="form-control <?php echo (!empty($tnd_type_err)) ? 'is-invalid' : ''; ?>">
                            <option selected="selected" hidden value=<?php echo $tnd_type; ?>> <?php echo $tnd_type_name; ?> </option>
                            <div class="invalid-feedback"><?php echo $tnd_type_err; ?></div>
                            <OPTION> <?php echo $options ?> </option>
                        </select>
                    </div>

                </div>

                <div class="form-row">

                    <?php

                    $tender_segment_sql = "SELECT  segm_name ,segm_id FROM segments where segm_active=1";

                    $tender_segment_result = mysqli_query($link, $tender_segment_sql);

                    $options = "";


                    while ($row2 = mysqli_fetch_array($tender_segment_result)) {
                        $options = $options . "<option VALUE=" . $row2[1] . ">$row2[0]</option>";
                    }
                    ?>



                    <div class="form-group col-md-4">
                        <label for="inputsegm">Segment</label>



                        <select id="exampleFormControlSelect1" name="inputsegm" class="form-control <?php echo (!empty($tnd_segment_err)) ? 'is-invalid' : ''; ?>">
                            <option selected="selected" hidden value=<?php echo $tnd_segment; ?>> <?php echo $tnd_segment_name; ?> </option>
                            <div class="invalid-feedback"><?php echo $tnd_segment_err; ?></div>
                            <OPTION> <?php echo $options; ?> </option>
                        </select>

                    </div>



                    <div class="form-group col-md-2">
                        <label for="inputinvoice">E-korekta faktur</label>


                        <select id="exampleFormControlSelect1" name="inputinvoice" class="form-control <?php echo (!empty($tnd_einvoice_err)) ? 'is-invalid' : ''; ?>">
                            <option selected="selected" hidden value=<?php echo $tnd_einvoice; ?>> <?php echo $tnd_einvoice; ?> </option>
                            <option value="TAK"> TAK </option>
                            <option value="NIE"> NIE </option>
                        </select>
                    </div>

                </div>
        </div>





        <input type="submit" class="btn btn-primary" value="Zmodyfikuj przetarg">

        <a href="tenders.php" class="btn btn-secondary ml-2">Powrót</a>
        </form>
    </div>
    </div>
    </div>
    </div>

</body>

<!-- wyswietlammy datę stworzenia, ost modyfikacji oraz uzytkowników-->



<?php


// Check existence of id parameter before processing further
if (isset($_SESSION['paramid']) && !empty(trim($_SESSION['paramid']))) {
    // Get URL parameter
    $id =  $_SESSION['paramid'];
    // Prepare a select statement
    $sql = "SELECT * FROM tenders t 
        left join tender_types tt on tt.tend_type_id = t.tnd_type
        left join contractors cnt on t.tnd_contractor_id= cnt.cnt_id
        left join segments seg on seg.segm_id= t.tnd_segment_id WHERE tnd_number = ?";
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