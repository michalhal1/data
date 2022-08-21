<?php session_start();

if (isset($_GET["job_id"])) {
    $paramid = trim($_GET["job_id"]);
    $_SESSION['paramid'] = $paramid;
};

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nowa oferta</title>
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
                    <h2 class="mt-5 mb-3">Udało się!</h2>
                    <div class="alert alert-success">Dodano nową ofertę </div>
                    <a href="offerors.php?job_id=<?php echo $_SESSION['paramid'] ?>" class="btn btn-success">Powrót</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>