<?php
// Process delete operation after confirmation
if (isset($_POST["merch_id"]) && !empty($_POST["merch_id"])) {
    // Include config file
    require_once "config.php";

    // Prepare a delete statement
    $sql = "update merchants set merch_active=0 WHERE merch_id = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_id);

        // Set parameters
        $param_id = trim($_POST["merch_id"]);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Records deleted successfully. Redirect to landing page
            header("location: merchant_new.php");
            exit();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
            echo  mysqli_stmt_error($stmt);
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($link);
} else {
    // Check existence of id parameter
    if (empty(trim($_GET["merch_id"]))) {
        // URL doesn't contain id parameter. Redirect to error page
        // header("location: error.php");

        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Delete Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Usuń handlowca z bazy</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="merch_id" value="<?php echo trim($_GET["merch_id"]); ?>" />
                            <p>Czy na pewno chcesz usunąć handlowca?</p>
                            <p>
                                <input type="submit" value="Tak" class="btn btn-danger">
                                <a href="merchant_new.php" class="btn btn-secondary">Nie</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>