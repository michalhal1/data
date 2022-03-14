<?php session_start();

if (isset($_GET["cnt_id"])) {
    $paramid = trim($_GET["cnt_id"]);
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
$cnt_name = $cnt_NIP = $cnt_city = $cnt_postal_code = $cnt_street =  "";
$cnt_name_err = $cnt_NIP_err = $cnt_city_err = $cnt_postal_code_err = $cnt_street_err = "";





// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate contractor name

    $input_cnt_name = trim($_POST["inputname"]);
    if (empty($input_cnt_name)) {
        $cnt_name_err = "Wpisz nazwę zamawiającego";
    } //elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
    elseif (strlen($input_cnt_name) <= 3) {
        $cnt_name_err = "Wpisz poprawną nazwę zamawiającego";
    } else {
        $cnt_name = $input_cnt_name;
    }


    // Validate cnt_NIP
    $input_cnt_NIP = trim($_POST["inputNIP"]);
    if (empty($input_cnt_NIP)) {
        $cnt_NIP_err = "Wpisz NIP";
    } elseif (strlen($input_cnt_NIP) != 10 || !ctype_digit($input_cnt_NIP)) {
        $cnt_NIP_err = "Wpisz poprawny NIP";
    } else {
        $cnt_NIP = $input_cnt_NIP;
    }

    // Validate city
    $input_cnt_city = trim($_POST["inputcity"]);
    if (empty($input_cnt_city)) {
        $cnt_city_err = "Wpisz nazwę miejscowości";
    } else {
        $cnt_city = $input_cnt_city;
    }



    // Validate street
    $input_cnt_street = trim($_POST["inputstreet"]);
    if (empty($input_cnt_street)) {
        $cnt_street_err = "Wpisz ulicę";
    } else {
        $cnt_street = $input_cnt_street;
    }


    // Validate postal code 

    $regex_postal_code = "^[0-9]{2}-[0-9]{3}$";
    // Validate postal code 
    $input_cnt_postal_code = trim($_POST["inputZip"]);
    if (empty($input_cnt_postal_code)) {
        $cnt_postal_code_err = "Wpisz kod pocztowy";
    } elseif (preg_match("/^[0-9]{2}-[0-9]{3}$/", $input_cnt_postal_code) == 0) {
        $cnt_postal_code_err = "Wpisz poprawny kod pocztowy XX-XXX";
    } else {
        $cnt_postal_code = $input_cnt_postal_code;
    }

    $cnt_record_creation_work = "michal halama";




    // '%d-%m-%y')inputZip

    // Check input errors before inserting in database
    if (empty($cnt_name_err) && empty($cnt_NIP_err) && empty($cnt_city_err)   && empty($cnt_street_err)   && empty($cnt_postal_code_err)) {
        // Prepare an insert statement



        $sql = "UPDATE tenders_test.contractors SET cnt_name=?, cnt_NIP=?, cnt_city=?, cnt_postal_code=?, cnt_street=?, cnt_record_modification_work=? , cnt_record_modification_date= now() WHERE cnt_id=?";


        if ($stmt = mysqli_prepare($link, $sql)) {


            // $id = ($_GET["cnt_id"]);
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssi", $param_cnt_name, $param_cnt_NIP, $param_cnt_city, $param_cnt_postal_code, $param_cnt_street, $param_cnt_record_modification_work, $param_id);

            // Set parameters


            $param_cnt_name = $input_cnt_name;
            $param_cnt_NIP = $input_cnt_NIP;
            $param_cnt_postal_code = $input_cnt_postal_code;
            $param_cnt_street = $input_cnt_street;
            $param_cnt_city = $input_cnt_city;
            $param_cnt_record_modification_work = $cnt_record_creation_work;
            $param_id = intval($_SESSION['paramid']);


            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records updated successfully. Redirect to landing page
                //  echo mysqli_stmt_error($stmt);

                header("location: contractor_update_ok.php");

                // echo trim($_POST["inputname"]); 
                //echo $stmt;
                exit();
                mysqli_stmt_close($stmt);
            } else {
                echo "Oops! Something went wrong. Please try again later.";
                echo mysqli_stmt_error($stmt);
                echo $stmt;
            }
        }
    }
} else {
    // Check existence of id parameter before processing further

    if (isset($_GET["cnt_id"]) && !empty(trim($_GET["cnt_id"]))) {
        // Get URL parameter
        $id =  trim($_GET["cnt_id"]);
        // Prepare a select statement
        $sql = "SELECT * FROM  tenders_test.contractors cnt  WHERE cnt_id = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_id);

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
                    $cnt_name = $row["cnt_name"];
                    $cnt_city = $row["cnt_city"];
                    $cnt_street = $row["cnt_street"];
                    $cnt_record_creation_work = $row["cnt_record_creation_work"];
                    $cnt_postal_code = $row["cnt_postal_code"];
                    $cnt_NIP = $row["cnt_NIP"];
                    $cnt_id = $row["cnt_id"];
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

        // Close statement


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


    <div class="wrapper">
        <div class="container-fluid">
            <h2 class="mt-5">Edytuj dane zamawiającego</h2>
            <p>Uzupełnij formularz i zatwierdź</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">


                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="inputname">Nazwa</label>
                        <input type="text" id="inputname" name="inputname" class="form-control <?php echo (!empty($cnt_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cnt_name; ?>">
                        <span class="invalid-feedback"><?php echo $cnt_name_err; ?></span>
                    </div>



                    <div class="form-group col-md-2">
                        <label for="inputNIP">NIP</label>
                        <input id="inputNIP" name="inputNIP" type="text" class="form-control <?php echo (!empty($cnt_NIP_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cnt_NIP; ?>">
                        <span class="invalid-feedback"><?php echo $cnt_NIP_err; ?></span>
                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group col-md-4">
                        <label for="inputstreet">Ulica</label>
                        <input type="text" id="inputstreet" name="inputstreet" placeholder="np. Ślężna 118/2" class="form-control <?php echo (!empty($cnt_street_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cnt_street; ?>">
                        <span class="invalid-feedback"><?php echo $cnt_street_err; ?></span>
                    </div>

                    <div class="form-group col-sm-2">
                        <label for="inputZip">Kod pocztowy</label>
                        <input type="text" id="inputZip" name="inputZip" class="form-control <?php echo (!empty($cnt_postal_code_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cnt_postal_code; ?>">
                        <span class="invalid-feedback"><?php echo $cnt_postal_code_err; ?></span>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="inputcity">Miejsowość</label>
                        <input type="text" id="inputcity" name="inputcity" class="form-control <?php echo (!empty($cnt_city_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cnt_city; ?>">
                        <span class="invalid-feedback"><?php echo $cnt_city_err; ?></span>
                    </div>
                </div>




                <input type="submit" class="btn btn-primary" value="Zmodyfikuj dane zamawiającego">

                <a href="contractor_new.php" class="btn btn-secondary ml-2">Powrót</a>



                <?php

                // Check existence of id parameter before processing further

                if (isset($_SESSION['paramid']) && !empty(trim($_SESSION['paramid']))) {
                    // Get URL parameter
                    $id =  $_SESSION['paramid'];
                    // Prepare a select statement
                    $sql = "SELECT * FROM  tenders_test.contractors cnt  WHERE cnt_id = ?";
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
                                $row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
                                //$tnd_number = $tnd_NIP = $tnd_contractor = $tnd_type = $tnd_segment = $tnd_announce_date = $tnd_submit_date =  "";
                                // Retrieve individual field value
                                $cnt_creation_work = $row["cnt_record_creation_work"];
                                $cnt_creation_date = $row["cnt_record_creation_date"];
                                $cnt_modification_work = $row["cnt_record_modification_work"];
                                $cnt_modification_date = $row["cnt_record_modification_date"];
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

                    // Close statement


                    // Close connection

                }

                ?>

                <br>
                <br>
                <style>
                    p {
                        text-indent: 5px;
                    }

                    h1 {
                        font-size: 10px;
                    }
                </style>

                <h1>
                    <p>
                        <?php echo "utworzono: " . $cnt_creation_date . " przez " . $cnt_creation_work ?> <br>
                    <p>
                        <?php echo "ostatnio zmodyfikowano: " . $cnt_modification_date . " przez " . $cnt_modification_work; ?>