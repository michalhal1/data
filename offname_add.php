<?php session_start();
// Include config file
require_once "config.php";


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
    // if (!isset($input_offname_Impelgroup)) {
    //     $offname_Impelgroup_err = "Zadeklaruj wartość";
    //     } else {
        $offname_Impelgroup = $input_offname_Impelgroup;
   // }

    $offname_record_creation_work = $logid ;
   /// $offname_Impelgroup = $input_offname_Impelgroup;

    // '%d-%m-%y')inputZip

    // Check input errors before inserting in database
    if (empty($offname_name_err) && empty($offname_Impelgroup_err)) {
        // Prepare an insert statement


        $sql = "INSERT INTO offerors_names (offnames_name, offnames_active, offnames_isimpel, offnames_record_creation_worker) VALUES (?, ?, coalesce(?,0),  ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "siis", $param_offname_name, $param_offnames_active,$param_offname_Impelgroup, $param_offnames_record_creation_worker);

            // Set parameters
            $param_offname_name = $input_offname_name;
            $param_offnames_active = 1;
            $param_offname_Impelgroup = $input_offname_Impelgroup;
           
            $param_offnames_record_creation_worker = $offname_record_creation_work;

            //date_format($date,"Y/m/d H:i:s");

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                //  echo "Dodano nowego zamawiającego";
               header("location: offname_ok.php");

              
               //  echo $stmt;
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
}

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Baza przetargowa</title>
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
            <h2 class="mt-5">Dodaj realizującego</h2>
            <p>Uzupełnij formularz i zatwierdź</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">


                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="inputname">Nazwa</label>
                        <input type="text" id="inputname" name="inputname" class="form-control <?php echo (!empty($cnt_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $offname_name; ?>">
                        <span class="invalid-feedback"><?php echo $offname_name_err; ?></span>
                    </div>


                <div class="form-group col-md-4">
                        <label for="inputinvoice">Czy należy do Grupy Impel?</label>
                        <select id="exampleFormControlSelect1" name="Impelgroup" class="form-control">
                            <option value=1> TAK </option>
                            <option value=0> NIE </option>
                        </select>
                </div>

    </div>




                <?php mysqli_close($link); ?>



                <input type="submit" class="btn btn-primary" value="Dodaj realizującego">

                <a href="offname_new.php" class="btn btn-secondary ml-2">Powrót</a>
            </form>
        </div>
    </div>
    </div>
    </div>