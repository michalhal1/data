<?php session_start();
// Include config file
require_once "config.php";


if (isset($_SESSION["logid"])) {
    $logid = $_SESSION['logid'];
  } else {
    header("location:login.php");
 };
 



// Define variables and initialize with empty values
$merch_name = $merch_surname = "";
$merch_name_err = $merch_surname_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name

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


        $sql = "INSERT INTO merchants (merch_name, merch_surname, merch_active) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssi", $param_merch_name, $param_merch_surname, $param_merch_activ);

            // Set parameters
            $param_merch_name = $input_merch_name;
            $param_merch_surname = $input_merch_surname;
            $param_merch_activ = 1;
          
            //date_format($date,"Y/m/d H:i:s");

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                //  echo "Dodano nowego zamawiającego";
                header("location: merchant_ok.php");

                // echo trim($_POST["inputname"]); 
                // echo $stmt;
                exit();
            } else {
                //  echo preg_match("/^[0-9]{2}-[0-9]{3}$/", "46-080");
                echo "Oops! Something went wrong. Please try again later.";
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
            <h2 class="mt-5">Dodaj handlowca</h2>
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



                <input type="submit" class="btn btn-primary" value="Dodaj zamawiającego">

                <a href="merchant_new.php" class="btn btn-secondary ml-2">Powrót</a>
            </form>
        </div>
    </div>
    </div>
    </div>