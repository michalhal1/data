<?php
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


        $sql = "INSERT INTO tenders_test.contractors (cnt_name, cnt_NIP, cnt_city, cnt_postal_code, cnt_street, cnt_record_creation_work) VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_cnt_name, $param_cnt_NIP, $param_cnt_city, $param_cnt_postal_code, $param_cnt_street, $param_cnt_record_creation_work);

            // Set parameters
            $param_cnt_name = $input_cnt_name;
            $param_cnt_NIP = $input_cnt_NIP;
            $param_cnt_postal_code = $input_cnt_postal_code;
            $param_cnt_street = $input_cnt_street;
            $param_cnt_city = $input_cnt_city;
            $param_cnt_record_creation_work = $cnt_record_creation_work;
            //date_format($date,"Y/m/d H:i:s");

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                //  echo "Dodano nowego zamawiającego";
                header("location: contractor_ok.php");

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
            <h2 class="mt-5">Dodaj zamawiającego</h2>
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




                <?php mysqli_close($link); ?>



                <input type="submit" class="btn btn-primary" value="Dodaj zamawiającego">

                <a href="contractor_new.php" class="btn btn-secondary ml-2">Powrót</a>
            </form>
        </div>
    </div>
    </div>
    </div>