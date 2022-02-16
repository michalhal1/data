<?php if (isset($_GET["tnd_number"]) && !empty(trim($_GET["tnd_number"]))) {
    // Get URL parameter
    $id =  trim($_GET["tnd_number"]);
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nowy zamawiający</title>
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
                    <div class="alert alert-success">Dodano nowego zamawiającego </div>
                    <a href="contractor_new.php" class="btn btn-success">Powrót</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>