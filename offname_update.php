<?php session_start();


require_once "config.php";


if (isset($_GET["offnames_id"])) {
    $paramid = trim($_GET["offnames_id"]);
    $_SESSION['paramid'] = $paramid;
};


if (isset($_SESSION["logid"])) {
    $logid = $_SESSION['logid'];
  } else {
    header("location:login.php");
 };
 



// Define variables and initialize with empty values
$offname_name = $offname_Impelgroup =  NULL;
$offname_name_err = $offname_Impelgroup_err = NULL;

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate contractor name

    $input_offname_name = trim($_POST["inputname"]);
    if (empty($input_offname_name)) {
        $offname_name_err = "Wpisz nazwę realizującego";
    } //elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
    elseif (strlen($input_offname_name) <= 3) {
        $offname_name_err = "Wpisz poprawną nazwę realizujacego";
    } else {
        $offname_name = $input_offname_name;
    }


    // Validate cnt_NIP
    $input_offname_Impelgroup = trim($_POST["Impelgroup"]);
 
    $offname_Impelgroup = $input_offname_Impelgroup;
    

    $offname_record_creation_work = $logid ;


    // '%d-%m-%y')inputZip

    // Check input errors before inserting in database
    if (empty($offname_name_err)) {
        // Prepare an insert statement


        $sql = "update offerors_names set offnames_name=?, offnames_active=?, offnames_isimpel=?, offnames_record_creation_worker=? where offnames_id = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "siisi", $param_offname_name, $param_offnames_active, $param_offname_Impelgroup, $param_offnames_record_creation_worker,$param_id);

            // Set parameters
            $param_offname_name = $input_offname_name;
            $param_offname_Impelgroup = $input_offname_Impelgroup;
            $param_offnames_active = 1;
            $param_offnames_record_creation_worker = $offname_record_creation_work;
            $param_id = $_SESSION['paramid'] ;
            //date_format($date,"Y/m/d H:i:s");

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                //  echo "Dodano nowego zamawiającego";
                header("location: offname_update_ok.php");

                // echo trim($_POST["inputname"]); 
                // echo $stmt;
                exit();
            } else {
                //  echo preg_match("/^[0-9]{2}-[0-9]{3}$/", "46-080");
                echo "Oops! Something went wrong. Please try again later.";
                echo mysqli_stmt_error($stmt);
                echo $stmt;
            }


            // Close statement
            mysqli_stmt_close($stmt);
        }
       
    }
   
    // Close connection
} else {
    if (isset($_GET["offnames_id"]) && !empty(trim($_GET["offnames_id"]))) {
    $id =  trim($_GET["offnames_id"]);

    $sql = "SELECT * FROM offerors_names t  WHERE offnames_id = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_offnames_id);

        // Set parameters
        $param_offnames_id = $id;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                //$tnd_number = $tnd_NIP = $tnd_contractor = $tnd_type = $tnd_segment = $tnd_announce_date = $tnd_submit_date =  "";
                // Retrieve individual field value
                $offname_name = $row["offnames_name"];
                //     $tnd_NIP = $row["tnd_NIP"];
                $offname_Impelgroup = $row["offnames_isimpel"];
                
            } else {
                // URL doesn't contain valid id. Redirect to error page
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }




    
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
            <h2 class="mt-5">Edytuj realizującego</h2>
            <p>Uzupełnij formularz i zatwierdź</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">


                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="inputname">Nazwa</label>
                        <input type="text" id="inputname" name="inputname" class="form-control <?php echo (!empty($cnt_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $offname_name; ?>">
                        <span class="invalid-feedback"><?php echo $cnt_name_err; ?></span>
                    </div>


                <div class="form-group col-md-4">
                        <label for="inputinvoice">Czy należy do Grupy Impel?</label>
                        <select id="exampleFormControlSelect1" name="Impelgroup" class="form-control">
                        <option selected="selected" hidden value=<?php echo $offname_Impelgroup; ?>> <?php echo $offname_Impelgroup==1 ? 'TAK' : 'NIE'; ?> </option>
                            <option value=1> TAK </option>
                            <option value=0> NIE </option>
                        </select>
                </div>

    </div>
              



              



                <input type="submit" class="btn btn-primary" value="Modyfikuj realizującego">

                <a href="offname_new.php" class="btn btn-secondary ml-2">Powrót</a>
            </form>
        </div>
    </div>
    </div>
    </div>


    

<?php

