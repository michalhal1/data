<?php session_start();

if (isset($_GET["merch_id"])) {
    $paramid = trim($_GET["merch_id"]);
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


    $input_merch_name = trim($_POST["inputname"]);
    if (empty($input_merch_name)) {
        $merch_name_err = "Wpisz imię handlowca";
    } //elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
    elseif (strlen($input_merch_name) <= 3) {
        $merch_name_err = "Wpisz imię handlowca";
    } else {
        $merch_name = $input_merch_name;
    }


        // Validate surname

        $input_merch_surname = trim($_POST["inputsurname"]);
        if (empty($input_merch_surname)) {
            $merch_surname_err = "Wpisz nazwisko handlowca";
        } //elseif(!filter_var($input_surname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        elseif (strlen($input_merch_surname) <= 3) {
            $merch_surname_err = "Wpisz nazwisko handlowca";
        } else {
            $merch_surname = $input_merch_surname;
        }

    $cnt_record_creation_work = $logid ;



    // '%d-%m-%y')inputZip

    // Check input errors before inserting in database
    if (empty($merch_name_err) and empty($merch_surname_err)) {
        // Prepare an insert statement



        $sql = "UPDATE merchants SET merch_name=?, merch_surname=? WHERE merch_id=?";


        if ($stmt = mysqli_prepare($link, $sql)) {


            // $id = ($_GET["cnt_id"]);
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssi", $param_merch_name, $param_merch_surname, $param_merch_id);

            // Set parameters
            $param_merch_name = $input_merch_name;
            $param_merch_surname = $input_merch_surname;
            $param_merch_id = intval($_SESSION['paramid']);


            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records updated successfully. Redirect to landing page
                //  echo mysqli_stmt_error($stmt);

                header("location: merchant_update_ok.php");

                // echo trim($_POST["inputname"]); 
                //echo $stmt;
                exit();
                mysqli_stmt_close($stmt);
            } else {
                echo "Oops! Something went wrong. Please try again later.";
                echo mysqli_stmt_error($stmt);
                
            }
        }
    }
} else {
    // Check existence of id parameter before processing further

    if (isset($_GET["merch_id"]) && !empty(trim($_GET["merch_id"]))) {
        // Get URL parameter
        $id =  trim($_GET["merch_id"]);
        // Prepare a select statement
        $sql = "SELECT * FROM  merchants merch  WHERE merch_id = ?";
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
                    $merch_surname = $row["merch_surname"];
                    $merch_name = $row["merch_name"];
                   
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
            <h2 class="mt-5">Edytuj dane handlowca</h2>
            <p>Uzupełnij formularz i zatwierdź</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">


                <div class="form-row">

                    <div class="form-group col-md-2">
                        <label for="inputsurname">Imię</label>
                        <input type="text" id="inputsurname" name="inputsurname" class="form-control <?php echo (!empty($merch_surname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $merch_surname; ?>">
                        <span class="invalid-feedback"><?php echo $merch_surname_err; ?></span>
                    </div>



                    <div class="form-group col-md-2">
                        <label for="inputname">Nazwisko</label>
                        <input id="inputname" name="inputname" type="text" class="form-control <?php echo (!empty($merch_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $merch_name; ?>">
                        <span class="invalid-feedback"><?php echo $merch_name_err; ?></span>
                    </div>

                </div>




                <?php mysqli_close($link); ?>



                <input type="submit" class="btn btn-primary" value="Edytuj handlowca">

                <a href="merchant_new.php" class="btn btn-secondary ml-2">Powrót</a>
            </form>
        </div>
    </div>
    </div>
    </div>