<?php session_start();

if (isset($_GET["job_id"])) {
    $paramid = trim($_GET["job_id"]);
    $_SESSION['paramid'] = $paramid;
};

//echo  $_SESSION['paramid'];

// Include config file
require_once "config.php";



// Define variables and initialize with empty values
$off_lead_off  = $off_key_offeror1 = $off_key_offeror2 = $off_key_offeror3 = $off_key_offeror4  = $doff_key_offeror5 = $off_contract_value = $off_points1 = $off_points2 = $off_points3 = $off_points4 = $off_points5 = $off_remarks ="";
$off_lead_off_err  = $off_key_offeror1_err = $off_key_offeror2_err = $off_key_offeror3_err = $off_key_offeror4_err  = $off_key_offeror5_err = $off_contract_value_err = $off_points1_err = $off_points2_err = $off_points3_err = $off_points4_err = $off_points5_err = "";

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
    if (empty($input_contract_value)) {
        if (!is_numeric($input_contract_value))
        $off_contract_value_err = "Wpisz wartość oferty";
    } else {
        $off_contract_value = $input_contract_value;
    }


    $off_key_offeror1 = trim($_POST["off1"]);
    $off_key_offeror2 = trim($_POST["off2"]);
    $off_key_offeror3 = trim($_POST["off3"]);
    $off_key_offeror4 = trim($_POST["off4"]);


    // VALIDATE point1
    $input_off_points1 = trim($_POST["points1"]);
    if (!empty($input_off_points1)) {
        if (!is_numeric($input_off_points1))
            $off_points1_err = "Wpisz wartość liczbową";
    } else {
        $off_points1 = $input_off_points1;
    }


    $off_points1 = trim($_POST["points1"]);
    $off_points2 = trim($_POST["points2"]);
    $off_points3 = trim($_POST["points3"]);
    $off_points4 = trim($_POST["points4"]);
    $off_points5 = trim($_POST["points5"]);
    $off_remarks = trim($_POST["remarks"]);

    if (empty($off_contract_value_err) && empty($off_lead_off_err) && empty($off_points1_err)) {
        // Prepare an insert statement

        $off_job_id = trim($_POST["paramid"]);

        $sql = "INSERT INTO tenders_test.offerors (off_job_id, off_leading_offeror, off_key_offeror1, off_key_offeror2, off_key_offeror3, off_key_offeror4, off_contract_value ,off_points_crit1, off_points_crit2,off_points_crit3,off_points_crit4,off_points_crit5, off_remarks, off_iswinner) VALUES ( ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iiiiiiiiiiiisi", $param_off_job_id, $param_off_leading_offeror, $param_off_key_offeror1, $param_off_key_offeror2,  $param_off_key_offeror3,  $param_off_key_offeror4, $param_off_contract_value, $param_off_points1, $param_off_points2, $param_off_points3, $param_off_points4, $param_off_points5, $param_off_remarks, $param_off_iswinner);

            $param_off_job_id = $off_job_id;
            $param_off_leading_offeror = $off_lead_off;
            $param_off_key_offeror1 = $off_key_offeror1;
            $param_off_key_offeror2 = $off_key_offeror2;
            $param_off_key_offeror3 = $off_key_offeror3;
            $param_off_key_offeror4 = $off_key_offeror4;
            $param_off_contract_value = $off_contract_value;
     
            $param_off_points1 = $off_points1;
            $param_off_points2 = $off_points2;
            $param_off_points3 = $off_points3;
            $param_off_points4 = $off_points4;
            $param_off_points5 = $off_points5;
            $param_off_remarks = $off_remarks;


            if ($_POST['off_winner'] == '1') {
                $param_off_iswinner = 1;
            } else {
                $param_off_iswinner = 0;
            }

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                //echo "Dodano nowy przetarg";
                header("location: offerors_ok.php");
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

                    //tutaj pobieramy z bazy nazwę oferenta, który ma się wyświetlić jeżeli pojawi się bład w innym polu 
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
                        <input type="text" id="off_value" name="off_value" class="form-control <?php echo (!empty($off_contract_value_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $off_contract_value; ?>">
                        <span class="invalid-feedback"><?php echo $off_contract_value_err; ?></span>
                    </div>




                </div>

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
                        <input type="text" id="points1" name="points1" class="form-control <?php echo (!empty($off_points1_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $off_points1; ?>">
                        <span class="invalid-feedback"><?php echo $off_points1_err; ?></span>
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="points2">Punkty kryterium 2</label>
                        <input type="text" id="points2" name="points2" class="form-control <?php echo (!empty($off_points2_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $off_points2; ?>">
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="points3">Punkty kryterium 3</label>
                        <input type="text" id="points3" name="points3" class="form-control <?php echo (!empty($off_points3_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $off_points3; ?>">
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="points4">Punkty kryterium 4</label>
                        <input type="text" id="points4" name="points4" class="form-control <?php echo (!empty($off_points4_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $off_points4; ?>">
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="points5">Punkty kryterium 5</label>
                        <input type="text" id="points5" name="points5" class="form-control <?php echo (!empty($off_points5_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $off_points5; ?>">
                        </select>
                    </div>
                </div>




                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="off_value">Uwagi</label>
                        <input type="text" id="remarks" name="remarks" class="form-control" value="<?php echo $off_remarks; ?>">
                       
                    </div>
                </div>


                <dd id="rr-element">

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="off_winner" id="off_winner" value="1" />
                        <label class="form-check-label" for="inlineCheckbox2">Zwycięzca</label>
                    </div>
                </dd>

                <?php mysqli_close($link); ?>



                <input type="submit" class="btn btn-primary" value="Dodaj przetarg">

                <input type="hidden" id="paramid" name="paramid" value=<?php echo $_SESSION['paramid'] ?>>

                <a href="index.php" class="btn btn-secondary ml-2">Powrót</a>
            </form>
        </div>
    </div>
    </div>
    </div>

</body>

</html>